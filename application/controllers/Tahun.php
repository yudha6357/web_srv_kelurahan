<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tahun extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('tahun_model');

		if (!isset($_SESSION['name'],$_SESSION['email'])) {
			redirect('auth');
		}
	}

	public function index()
	{
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		$data['tahun'] = $this->tahun_model->get_data()->result();
		$data['tahun_option'] = $this->tahun_model->tahun_option();
		// print_r($data['tahun']);
		// die;
		$this->load->view('admin/tahun/index', $data);
	}

	public function store(){
		$tahun					= $this->input->post('tahun');
		$status			= $this->input->post('status');
		// print_r($tahun);
		// die;
		$data = array(
			'tahun'								=> $tahun,
			'is_active'						=> $status,
		);

		$this->tahun_model->save($data);

		redirect('tahun/index');
	}

	public function cek()
	{
		// $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
		// $data['tahun'] = $this->tahun_model->get_data()->result();
		// $data['tahun_option'] = $this->tahun_model->tahun_option();
		// // print_r($data['tahun']);
		// // die;
		print_r($this->session->userdata);
		// $this->load->view('cek');
	}

}
