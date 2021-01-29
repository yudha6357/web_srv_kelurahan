<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
	}

	public function index()
	{
		
		$monthTemp = $this->admin_model->get_month()->result();
		// print_r($monthTemp);
		// die();
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		if (count($monthTemp) < 1){
			$data['anggaran_bulan'] = 0;
			$data['pengeluaran_bulan'] = 0;
			$data['sisa_anggaran'] = 0;
			$data['anggaran_tahunan'] = 0;
			$data['sisa_tahunan'] = 0;
		}else{
			$month = month($monthTemp[0]->bulan);
			// $month = date('m');
			$anggaranBulanTemp = $this->admin_model->anggaran_bulan($month);
			$pengeluaranBulanTemp = $this->admin_model->pengeluaran_bulan($monthTemp[0]->bulan);
			$data['anggaran_bulan'] = $anggaranBulanTemp[0]->anggaran;
			$data['pengeluaran_bulan'] = $pengeluaranBulanTemp[0]->pengeluaran;
			$data['sisa_anggaran'] = $anggaranBulanTemp[0]->anggaran - $pengeluaranBulanTemp[0]->pengeluaran;
			$data['anggaran_tahunan'] = $this->admin_model->anggaran_tahunan();
			$data['sisa_tahunan'] = $this->admin_model->sisa_tahunan();
			// print_r($data['sisa_tahunan']);
			// die();
		}

		$this->load->view('admin/home/index', $data);
	}
}
