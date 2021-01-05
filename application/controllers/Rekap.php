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
		$data['tahun'] = $this->db->select('year(created_at) as tahun')->get('anggaran')->result_array();
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->view('admin/rekap/index', $data);
	}

	public function ajax()
	{

		$data['year'] = $this->input->post('year');
		$data['month'] = $this->input->post('month');
		$data['monthTemp'] = $this->admin_model->monthstr($data['month']);
		$anggaranBulanTemp = $this->rekap_model->anggaran_bulan($data)->result();	
		$pengeluaranBulanTemp = $this->rekap_model->pengeluaran_bulan($data)->result();
		$hasil['anggaran_bulan'] = $anggaranBulanTemp[0]->anggaran;
		$hasil['pengeluaran_bulan'] = $pengeluaranBulanTemp[0]->pengeluaran;
		$hasil['sisa_anggaran'] = $anggaranBulanTemp[0]->anggaran - $pengeluaranBulanTemp[0]->pengeluaran;
		$hasil['anggaran_tahunan'] = $this->admin_model->anggaran_tahunan();
		$hasil['sisa_tahunan'] = $this->admin_model->sisa_tahunan();
		$hasil['rekap'] = $this->rekap_model->rekap($data);
		print_r($hasil['rekap']);
		die;


		echo json_encode($hasil);

	}

	public function pdf()
	{
		$parm = $this->input->get('id');

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
		
	}

}
