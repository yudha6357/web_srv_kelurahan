<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggaran extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('anggaran_model');
		$this->load->model('tahun_model');
	}

	public function index()
	{
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$data['anggaran'] = $this->anggaran_model->get_data()->result();
		$data['tahun_option'] = $this->tahun_model->get_tahun()->result();
		// print_r($data['tahun_option']);
		// die;
		$this->load->view('admin/anggaran/index', $data);
	}

	public function store()
	{
		$kode					= $this->input->post('kode');
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
			'tahun'							=> $tahun,
			'bulan_realisasi'			=> json_encode($bulan),
		);

		$this->anggaran_model->save($data);

		redirect('anggaran/index');
	}

	public function update()
	{
		$id					= $this->input->post('id');
		$kode					= $this->input->post('kode');
		$kegiatan			= $this->input->post('kegiatan');
		$anggaran			= $this->input->post('anggaran');
		$volume				= $this->input->post('volume');
		$bulan				= $this->input->post('bulan');

		$data = array(
			'kode'								=> $kode,
			'kegiatan'						=> $kegiatan,
			'anggaran'						=> $anggaran,
			'volume'							=> $volume,
			'bulan_realisasi'			=> json_encode($bulan),
		);

		$where = array(
			'id' => $id
		);

		$this->anggaran_model->update($where, $data, 'anggaran');

		redirect('anggaran/index');
	}

	public function destroy()
	{
		$id = $this->uri->segment(3);
		$this->anggaran_model->delete($id);
		redirect('anggaran/index', 'refresh');
	}
}
