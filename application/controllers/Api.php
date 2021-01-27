<?php
   
require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->model('anggaran_model');
    $this->load->model('transaksi_model');
    $this->load->model('admin_model');
  }

  // public function index_get()
  // {

  // }

  public function anggaran_get()
  {
    $data['anggaran'] = $this->anggaran_model->get_data()->result();

    return $this->response($data, REST_Controller::HTTP_OK);
  } 

  public function transaksi_get()
  {
    $data['transaksi'] = $this->transaksi_model->get_data()->result();

    return $this->response($data, REST_Controller::HTTP_OK);
  } 

  public function transaksi_post()
  {
		$raw = json_decode($this->input->raw_input_stream, true);
		if (!$raw) {
			$raw = [];
		}
		// print_r(gettype($raw));
		// die;
		$kegiatan			= array_key_exists('kegiatan', $raw) ? $raw['kegiatan'] : $this->input->post('kegiatan');
		$pengeluaran	= array_key_exists('pengeluaran', $raw) ? $raw['pengeluaran'] : $this->input->post('pengeluaran');
		
		// print_r(gettype($kegiatan));
		// die;
		if (!$kegiatan) {
			return $this->response(["error" => "Kegiatan Kosong"], 400);
		}

		$kode = $this->transaksi_model->searchKode($kegiatan)->result();

		$data = array(
			'kode'				=> $kode[0]->kode,
			'kegiatan'		=> $kegiatan,
			'pengeluaran'	=> $pengeluaran,
		);

		$this->transaksi_model->save($data);
  
    return $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
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

  public function dashboard_get(){

    $monthTemp = $this->admin_model->get_month()->result();
    if (count($monthTemp) < 1){
			$data['anggaran_bulan'] = 0;
			$data['pengeluaran_bulan'] = 0;
			$data['sisa_anggaran'] = 0;
			$data['anggaran_tahunan'] = 0;
			$data['sisa_tahunan'] = 0;
		}else{
			$month = month($monthTemp[0]->bulan);
			// $month = date('m');
			$anggaranBulanTemp = $this->admin_model->anggaran_bulan($month)->result();
			$pengeluaranBulanTemp = $this->admin_model->pengeluaran_bulan($monthTemp[0]->bulan)->result();
			$pengeluaranTahunanTemp = $this->admin_model->pengeluaran_tahunan_api();
      $jumlahTahunanTemp = $this->admin_model->sisa_tahunan_api();
      
      $anggaran_bulan = $anggaranBulanTemp[0]->anggaran;
			$pengeluaran_bulan = $pengeluaranBulanTemp[0]->pengeluaran;
			$sisa_anggaran = $anggaranBulanTemp[0]->anggaran - $pengeluaranBulanTemp[0]->pengeluaran;
      $pengeluaran_tahunan = $pengeluaranTahunanTemp[0]->pengeluaran;
			$jumlah_tahunan = $jumlahTahunanTemp[0]->anggaran;
			$sisa_tahunan = $jumlahTahunanTemp[0]->anggaran - $pengeluaranTahunanTemp[0]->pengeluaran;
			
			$data['anggaran_bulan'] = $anggaran_bulan;
			$data['anggaran_bulan_persen'] = 100;
			$data['pengeluaran_bulan'] = $pengeluaran_bulan;
			$data['pengeluaran_bulan_persen'] = $pengeluaran_bulan / $anggaran_bulan * 100;
			$data['sisa_anggaran'] = $sisa_anggaran;
			$data['sisa_anggaran_persen'] = $sisa_anggaran / $anggaran_bulan * 100;
			$data['jumlah_tahunan'] = $jumlah_tahunan;
			$data['jumlah_tahunan_persen'] = 100;
			$data['pengeluaran_tahunan'] = $pengeluaran_tahunan;
			$data['pengeluaran_tahunan_persen'] = $pengeluaran_tahunan / $jumlah_tahunan *100;
			$data['sisa_tahunan'] = $sisa_tahunan;
			$data['sisa_tahunan_persen'] = $sisa_tahunan / $jumlah_tahunan *100;
    }
    
    $this->response($data, REST_Controller::HTTP_OK);
  }

  public function login_post()
	{
		$raw = json_decode($this->input->raw_input_stream, true);
		if (!$raw) {
			$raw = [];
		}
		// print_r(gettype($raw));
		// die;

		$email = array_key_exists('email', $raw) ? $raw['email'] : $this->input->post('email');
		$password = array_key_exists('password', $raw) ? $raw['password'] : $this->input->post('password');

		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		
		if ($user) {
			if (password_verify($password, $user['password'])) {
				$data = [
					'email' 		=> $user['email'],
					'name' 			=> $user['name'],
					'role_id' 	=> $user['role_id'],
				];

				// $this->session->set_userdata($data);
				if ($data['role_id'] == 2) {
					# code...
          return $this->response($data, REST_Controller::HTTP_OK);
				} else {
					return $this->response($data, REST_Controller::HTTP_OK);
				}
			} else {
				return $this->response(["error" => "password not match"], 400);
			}
		} else {
			return $this->response(["error" => "email not found"], 400);
		}
  }
  
  public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->session->unset_userdata('password');

		return $this->response(['logout successfully.'], REST_Controller::HTTP_OK);
	}
}