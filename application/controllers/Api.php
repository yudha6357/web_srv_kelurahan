<?php
   
require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->model('anggaran_model');
    $this->load->model('transaksi_model');
  }

  // public function index_get()
  // {

  // }

  public function anggaran_get()
  {
    $data['anggaran'] = $this->anggaran_model->get_data()->result();

    $this->response($data, REST_Controller::HTTP_OK);
  } 

  public function transaksi_get()
  {
    $data['transaksi'] = $this->transaksi_model->get_data()->result();

    $this->response($data, REST_Controller::HTTP_OK);
  } 

  public function transaksi_post()
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
  
    $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
  }

  public function transaksiUpdate_post($id)
  {
    // $id 					= $this->input->post('id');
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
    $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
  }


}