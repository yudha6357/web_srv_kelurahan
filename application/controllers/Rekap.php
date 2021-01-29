<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('rekap_model');
		$this->load->model('admin_model');
	}

	public function index()
	{
		$data['tahun'] = $this->db->select('year(created_at) as tahun')->group_by('year(created_at)')->get('anggaran')->result_array();
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('admin/rekap/index', $data);
	}

	public function ajax()
	{

		$data['year'] = $this->input->post('year');
		$data['month'] = $this->input->post('month');
		$data['monthTemp'] = $this->admin_model->monthstr($data['month']);
		$anggaranBulanTemp = $this->rekap_model->anggaran_bulan($data);	
		$pengeluaranBulanTemp = $this->rekap_model->pengeluaran_bulan($data);

		$data['anggaran_bulan'] = $anggaranBulanTemp[0]->anggaran;
		$data['pengeluaran_bulan'] = $pengeluaranBulanTemp[0]->pengeluaran;
		$data['sisa_anggaran'] = $anggaranBulanTemp[0]->anggaran - $pengeluaranBulanTemp[0]->pengeluaran;
		$data['anggaran_tahunan'] = $this->admin_model->anggaran_tahunan();
		$data['sisa_tahunan'] = $this->admin_model->sisa_tahunan();
		$data['rekap'] = $this->rekap_model->rekap($data);


		echo json_encode($data);

	}

	public function pdf()
	{
		$parm['monthTemp'] = $this->input->get('id');
		$parm['month'] = $this->input->get('bulan');
		$parm['year'] = $this->input->get('tahun');
		
		// print_r($parm);
		// die;
		
		$this->load->library('pdf');
		$data['hasil'] = $this->rekap_model->rekap($parm);
		$this->load->view('admin/rekap/laporan_pdf',$data);
		$paper_size = 'A4';
		$orientation = 'landscape';
		$html = $this->output->get_output();
		$this->pdf->set_paper($paper_size,$orientation);
		$this->pdf->load_html($html);
		$this->pdf->render();
		$this->pdf->stream("laporan_keuangan.pdf",array('Attachment'=>0));
	}
	
	public function excel()
	{
		$parm['monthTemp'] = $this->input->get('id');
		$parm['month'] = $this->input->get('bulan');
		$parm['year'] = $this->input->get('tahun');
		
		// print_r($parm);
		// die;
		
		$data['hasil'] = $this->rekap_model->rekap($parm);

		require(APPPATH.'PHPExcel-1.8/Classes/PHPExcel.php');
		require(APPPATH.'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

		$object = new PHPExcel();

		$object->getProperties()->setCreator("yudha");
		$object->getProperties()->setLastModifiedBy("yudha");
		$object->getProperties()->setTitle("Laporan");
		
		$object->setActiveSheetIndex(0);

		$object->getActiveSheet()->setCellValue('A1','NO');
		$object->getActiveSheet()->setCellValue('A1','Kode');
		$object->getActiveSheet()->setCellValue('A1','Kegiatan');
		$object->getActiveSheet()->setCellValue('A1','Transaksi');
		$object->getActiveSheet()->setCellValue('A1','Tidak Terealisasi');

		$baris = 2;
		$no =1;

		foreach ($data['hasil'] as $item) {
			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('A'.$baris,  $item->kegiatan);
			$object->getActiveSheet()->setCellValue('A'.$baris, $item->anggaran);
			$object->getActiveSheet()->setCellValue('A'.$baris, $item->pengeluaran);
			$object->getActiveSheet()->setCellValue('A'.$baris, $item->sisa);

			$baris++;
		}

		$filename = "laporan Keuangan".'xlsx';

		$object->getActiveSheet()->setTitle('Laporan');

		header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=o');

		$writer = PHPExcel_IOFactory::createWriter($object,'Excel2007');
		$writer->save('php://output');

		exit;


	}

}
