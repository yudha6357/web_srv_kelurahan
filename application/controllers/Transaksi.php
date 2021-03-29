<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi_model');
		$this->load->model('anggaran_model');
		$this->load->model('tahun_model');

		if (!isset($_SESSION['name'],$_SESSION['email'])) {
			redirect('auth');
		}
	}

	public function index()
	{
		$errors = $this->session->flashdata('errors');
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$data['transaksi'] = $this->transaksi_model->get_data()->result();
		$data['anggaran']	= $this->anggaran_model->get_data()->result();
		$data['tahun_option'] = $this->tahun_model->get_tahun()->result();
		$data['errors'] = $errors ? $errors : [];
		// print_r($data['transaksi']);
		// die;
		$this->load->view('admin/transaksi/index', $data);
	}

	public function ajax()
	{

		$kegiatan = $this->input->post();
		$data = $this->anggaran_model->getdata($kegiatan);
		echo json_encode($data);
	}

	public function store()
	{
		$errors = $this->transaksi_model->validate_fields_store($_POST);
		
		if ($errors) {
			$this->session->set_flashdata('errors', $errors);
			redirect('transaksi/index');
		}

		$kode 				= $this->input->post('kode');
		$kegiatan			= $this->input->post('kegiatan');
		$pengeluaran	    = $this->input->post('pengeluaran');
		$tahun				= $this->input->post('tahun');
		$tanggal			= date("Y-m-d",strtotime($this->input->post('tanggal')));

		$data = array(
			'kode'				=> $kode,
			'kegiatan'		    => $kegiatan,
			'pengeluaran'	    => $pengeluaran,
			'tahun'				=> $tahun,
			'tanggal'			=> $tanggal,
		);

		$this->transaksi_model->save($data);

		redirect('transaksi/index');
	}

	public function update()
	{
		$id 					= $this->input->post('id');
		$kode 				= $this->input->post('kode');
		$kegiatan			= $this->input->post('kegiatan');
		$pengeluaran	= $this->input->post('pengeluaran');
		$tanggal	= $this->input->post('tanggal');

		$data = array(
			'kode'				=> $kode,
			'kegiatan'		=> $kegiatan,
			'pengeluaran'	=> $pengeluaran,
			'tanggal'	=> $tanggal,
		);

		$where = array(
			'id'	=> $id
		);

		$this->transaksi_model->update($where, $data, 'transaksi');

		redirect('transaksi/index');
	}

	public function destroy()
	{
		$id = $this->uri->segment(3);
		$this->transaksi_model->delete($id);

		redirect('transaksi/index');
	}

	public function get_by_id()
	{
		$id = $this->input->post('id');
		$data = $this->anggaran_model->get_one(['id' => $id]);
		echo json_encode($data);
	}

}
