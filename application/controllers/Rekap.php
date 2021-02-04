<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\ColumnDimension;
use PhpOffice\PhpSpreadsheet\Worksheet;

class Rekap extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('rekap_model');
		$this->load->model('admin_model');

		if (!isset($_SESSION['name'],$_SESSION['email'])) {
			redirect('auth');
		}
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

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Kegiatan');
		$sheet->setCellValue('C1', 'Anggaran');
		$sheet->setCellValue('D1', 'pengeluaran');
		$sheet->setCellValue('E1', 'Sisa');
		
		$slno = 1;
		$start = 2;

		foreach($data['hasil'] as $item){
			$sheet->setCellValue('A'.$start, $slno);
			$sheet->setCellValue('B'.$start, $item->kegiatan);
			$sheet->setCellValue('C'.$start, $item->anggaran);
			$sheet->setCellValue('D'.$start, $item->pengeluaran);
			$sheet->setCellValue('E'.$start, $item->sisa);
		
		$start = $start+1;
		$slno = $slno+1;
		}
		
		
		$styleThinBlackBorderOutline = [
					'borders' => [
						'allBorders' => [
							'borderStyle' => Border::BORDER_THIN,
							'color' => ['argb' => 'FF000000'],
						],
					],
				];
		//Font BOLD
		$sheet->getStyle('A1:E1')->getFont()->setBold(true);		
		$sheet->getStyle('A1:E10')->applyFromArray($styleThinBlackBorderOutline);
		//Alignment
		//fONT SIZE
		$sheet->getStyle('A1:E10')->getFont()->setSize(12);
		$sheet->getStyle('A1:E2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		$sheet->getStyle('A2:D100')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		//Custom width for Individual Columns
		$sheet->getColumnDimension('A')->setWidth(4);
		$sheet->getColumnDimension('B')->setWidth(20);
		$sheet->getColumnDimension('C')->setWidth(15);
		$sheet->getColumnDimension('D')->setWidth(15);
		$sheet->getColumnDimension('E')->setWidth(15);
		$curdate = date('d-m-Y H:i:s');

		$writer = new Xlsx($spreadsheet);

		$filename = 'Report'.$curdate;
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');


	}

}
