<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggaran extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('anggaran_model');
		$this->load->model('transaksi_model');
		$this->load->model('tahun_model');

		if (!isset($_SESSION['name'],$_SESSION['email'])) {
			redirect('auth');
		}
	}

	public function index()
	{
		$errors = $this->session->flashdata('errors');
		$data['user'] = $this->db->get_where('users', 
			['email' => $this->session->userdata('email')]
		)->row_array();
		$data['anggaran'] = $this->anggaran_model->get_data()->result();
		$data['tahun_option'] = $this->tahun_model->get_tahun()->result();
		$data['errors'] = $errors ? $errors : [];
		
		$this->load->view('admin/anggaran/index', $data);
	}

	public function store()
	{
		$errors = $this->anggaran_model->validate_fields_store($_POST);
		
		if ($errors) {
			$this->session->set_flashdata('errors', $errors);
			redirect('anggaran/index');
		}

		$data = array(
			'kode' => $this->input->post('kode'),
			'kegiatan' => $this->input->post('kegiatan'),
			'anggaran' => $this->input->post('anggaran'),
			'volume' => $this->input->post('volume'),
			'tahun' => $this->input->post('tahun'),
			'bulan_realisasi' => json_encode($this->input->post('bulan')),
		);

		$this->anggaran_model->save($data);

		redirect('anggaran/index');
	}

	public function update()
	{
		$errors = [];

		$id					= $this->input->post('id');
		$kode				= $this->input->post('kode');
		$kegiatan			= $this->input->post('kegiatan');
		$anggaran			= $this->input->post('anggaran');
		$volume				= $this->input->post('volume');
		$bulan				= $this->input->post('bulan');
		$tahun				= $this->input->post('tahun');

		$data = array(
			'kode'								=> $kode,
			'kegiatan'						=> $kegiatan,
			'anggaran'						=> $anggaran,
			'volume'							=> $volume,
			'tahun'							  => $tahun,
			'bulan_realisasi'			=> json_encode($bulan),
		);
	
		$where = array(
			'id' => $id
		);
		$this->anggaran_model->update($where, $data);

		redirect('anggaran/index');
	}

	public function destroy()
	{
		$id = $this->uri->segment(3);
		$this->anggaran_model->delete($id);
		redirect('anggaran/index', 'refresh');
	}
}
