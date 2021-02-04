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
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$data['anggaran'] = $this->anggaran_model->get_data()->result();
		$data['tahun_option'] = $this->tahun_model->get_tahun()->result();

		// print_r($data['anggaran']);
		// die();
		
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
			'tahun'							  => $tahun,
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
		$temp = $this->anggaran_model->get_one($where);
		// print_r($temp);
		// die;
		$temp2 = $this->transaksi_model->searchMbuh($temp[0]->kode);
		// print_r($temp);
		// die;
		// $this->anggaran_model->update($where, $data, 'anggaran');
		$this->anggaran_model->updateku('anggaran', $data, $where);

		foreach ($temp2->result() as $key => $value) {
			$this->anggaran_model->updateku('transaksi', ['kode' => $kode], ['id' => $value->id]);	
		}
		// $this->transaksi_model->update(['kode' => '008'], ['kode' => '9999'], 'transaksi');
		// print_r($res->result());
		// die;

		redirect('anggaran/index');
	}

	public function destroy()
	{
		$id = $this->uri->segment(3);
		$this->anggaran_model->delete($id);
		redirect('anggaran/index', 'refresh');
	}
}
