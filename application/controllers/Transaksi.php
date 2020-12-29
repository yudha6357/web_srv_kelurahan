<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi_model');
		$this->load->model('anggaran_model');
	}

	public function index()
	{
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$data['transaksi'] = $this->transaksi_model->get_data()->result();
		$data['anggaran']	= $this->anggaran_model->get_data()->result();
		$this->load->view('admin/transaksi/index', $data);
	}

	public function ajax()
	{

		$kode = $this->input->post();
		$data = $this->anggaran_model->getdata($kode);
		echo json_encode($data);
	}

	public function store()
	{
		$kode 				= $this->input->post('kode');
		$kegiatan			= $this->input->post('kegiatan');
		$pengeluaran	= $this->input->post('pengeluaran');

		$data = array(
			'kode'				=> $kode,
			'kegiatan'		=> $kegiatan,
			'pengeluaran'	=> $pengeluaran,
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

		$data = array(
			'kode'				=> $kode,
			'kegiatan'		=> $kegiatan,
			'pengeluaran'	=> $pengeluaran,
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
}
