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

  public function login_post()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		if ($user) {
			if (password_verify($password, $user['password'])) {
				$data = [
					'email' 		=> $user['email'],
					'name' 			=> $user['name'],
					'role_id' 	=> $user['role_id'],
				];

				$this->session->set_userdata($data);
				if ($data['role_id'] == 2) {
					# code...
					echo "login sukses";
				} else {
					echo "admin";
				}
			} else {
				echo "gagal";
			}
		} else {
			echo "gagal 2";
		}
	}


}