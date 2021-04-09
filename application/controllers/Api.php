<?php
   
require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('anggaran_model');
		$this->load->model('transaksi_model');
		$this->load->model('admin_model');
		$this->load->model('tahun_model');
		$this->load->model('rekap_model');
	}

	public function anggaran_get()
	{
		$data['anggaran'] = $this->anggaran_model->get_data()->result();

		return $this->response($data, REST_Controller::HTTP_OK);
	}

	public function anggaran_bulan_get($bulan)
	{
		$this->db->select('anggaran.id,anggaran.kode,anggaran.kegiatan,anggaran.kode,anggaran.anggaran,anggaran.volume,anggaran.bulan_realisasi,tahun.tahun');
		$this->db->from('anggaran');
		$this->db->join('tahun', 'tahun.id = anggaran.tahun', 'left');
		$this->db->like('bulan_realisasi', $bulan);
		$data = $this->db->get();
		$response['anggaran'] = $data->result();

		return $this->response($response, REST_Controller::HTTP_OK);
	}

	public function transaksi_get()
	{
		$data['transaksi'] = $this->transaksi_model->get_data()->result();

		return $this->response($data, REST_Controller::HTTP_OK);
	}

	public function transaksi_bulan_get($bulan_num)
	{
		$data['transaksi'] = $this->transaksi_model->get_bulan_data($bulan_num)->result();

		return $this->response($data, REST_Controller::HTTP_OK);
	}

	public function tahuns_get()
	{
		$data = $this->tahun_model->get_data()->result();

		$response['tahuns'] = [];
		$response['ids'] = [];

		foreach ($data as $key => $value) {
			array_push($response['tahuns'], $value->tahun);
			array_push($response['ids'], $value->id);
		}

		return $this->response($response, REST_Controller::HTTP_OK);
	}

	public function kegiatans_get()
	{
		$data = $this->anggaran_model->get_data()->result();
		$response['kegiatans'] = [];
		$response['ids'] = [];

		foreach ($data as $key => $value) {
			array_push($response['kegiatans'], $value->kegiatan);
			array_push($response['ids'], $value->id);
		}

		return $this->response($response, REST_Controller::HTTP_OK);
	}

	public function get_by_id_get($id)
	{
		// $id = $this->input->post('id');
		$data = $this->anggaran_model->get_one(['id' => $id]);
		if (!$data) {
			return $this->response(["error" => "Anggaran not found"], 404);
		}
		return $this->response($data[0], REST_Controller::HTTP_OK);
	}

	public function anggaran_post()
	{
		$raw = json_decode($this->input->raw_input_stream, true);
		
		if (!$raw) {
			$raw = [];
		}
	
		$kode = array_key_exists('kode', $raw) ? $raw['kode'] : $this->input->post('kode');
		$kegiatan = array_key_exists('kegiatan', $raw) ? $raw['kegiatan'] : $this->input->post('kegiatan');
		$anggaran = array_key_exists('anggaran', $raw) ? $raw['anggaran'] : $this->input->post('anggaran');
		$volume = array_key_exists('volume', $raw) ? $raw['volume'] : $this->input->post('volume');
		$tahun = array_key_exists('tahun', $raw) ? $raw['tahun'] : $this->input->post('tahun');
		$bulan_realisasi = array_key_exists('bulan_realisasi', $raw) ? $raw['bulan_realisasi'] : $this->input->post('bulan_realisasi');

		$data = array(
			'kode' => $kode,
			'kegiatan' => $kegiatan,
			'anggaran' => $anggaran,
			'volume' => $volume,
			'tahun' => $tahun,
			'bulan' => $bulan_realisasi,
		);

		$errors = $this->anggaran_model->validate_fields_store($data);

		if ($errors) {
			return $this->response(["error" => $errors], 400);
		}

		$data['bulan_realisasi'] = json_encode($data['bulan']);
		unset($data['bulan']);

		$response = $this->anggaran_model->save($data);

		return $this->response($data, REST_Controller::HTTP_OK);
	}

	public function anggaran_update_post($id)
	{
		$raw = json_decode($this->input->raw_input_stream, true);
		
		if (!$raw) {
			$raw = [];
		}

		$kode = array_key_exists('kode', $raw) ? $raw['kode'] : $this->input->post('kode');
		$kegiatan = array_key_exists('kegiatan', $raw) ? $raw['kegiatan'] : $this->input->post('kegiatan');
		$anggaran = array_key_exists('anggaran', $raw) ? $raw['anggaran'] : $this->input->post('anggaran');
		$volume = array_key_exists('volume', $raw) ? $raw['volume'] : $this->input->post('volume');
		$tahun = array_key_exists('tahun', $raw) ? $raw['tahun'] : $this->input->post('tahun');
		$bulan_realisasi = array_key_exists('bulan_realisasi', $raw) ? $raw['bulan_realisasi'] : $this->input->post('bulan_realisasi');

		$data = array(
			'kode' => $kode,
			'kegiatan' => $kegiatan,
			'anggaran' => $anggaran,
			'volume' => $volume,
			'tahun' => $tahun,
			'bulan' => $bulan_realisasi,
		);

		$data['bulan_realisasi'] = json_encode($data['bulan']);
		unset($data['bulan']);
	
		$where = array(
			'id' => $id
		);

		$this->anggaran_model->update($where, $data);

		return $this->response($data, REST_Controller::HTTP_OK);
	}

	public function anggaran_destroy_post($id)
	{
		$this->anggaran_model->delete($id);
		return $this->response(['msg' => 'success'], REST_Controller::HTTP_OK);
	}

	public function transaksi_post()
	{
		$raw = json_decode($this->input->raw_input_stream, true);
		
		if (!$raw) {
			$raw = [];
		}

		$kode = array_key_exists('kode', $raw) ? $raw['kode'] : $this->input->post('kode');
		$kegiatan = array_key_exists('kegiatan', $raw) ? $raw['kegiatan'] : $this->input->post('kegiatan');
		$pengeluaran = array_key_exists('pengeluaran', $raw) ? $raw['pengeluaran'] : $this->input->post('pengeluaran');
		$tanggal = array_key_exists('tanggal', $raw) ? $raw['tanggal'] : $this->input->post('tanggal');
		$tahun = array_key_exists('tahun', $raw) ? $raw['tahun'] : $this->input->post('tahun');
		
		if (!$kegiatan) {
			return $this->response(["error" => "Kegiatan Kosong"], 400);
		}

		$data = array(
			'kode' => $kode,
			'kegiatan' => $kegiatan,
			'pengeluaran' => $pengeluaran,
			'tanggal' => $tanggal,
			'tahun' => $tahun
		);

		$errors = $this->transaksi_model->validate_fields_store($data);
		
		if ($errors) {
			return $this->response(["error" => $errors], 400);
		}

		$response = $this->transaksi_model->save($data);
  
		return $this->response($data, REST_Controller::HTTP_OK);
	}

	public function transaksi_update_post($id)
	{
		$raw = json_decode($this->input->raw_input_stream, true);
		
		if (!$raw) {
			$raw = [];
		}

		$kode = array_key_exists('kode', $raw) ? $raw['kode'] : $this->input->post('kode');
		$kegiatan = array_key_exists('kegiatan', $raw) ? $raw['kegiatan'] : $this->input->post('kegiatan');
		$pengeluaran = array_key_exists('pengeluaran', $raw) ? $raw['pengeluaran'] : $this->input->post('pengeluaran');
		$tanggal = array_key_exists('tanggal', $raw) ? $raw['tanggal'] : $this->input->post('tanggal');
		$tahun = array_key_exists('tahun', $raw) ? $raw['tahun'] : $this->input->post('tahun');

		$data = array(
			'kode' => $kode,
			'kegiatan' => $kegiatan,
			'pengeluaran' => $pengeluaran,
			'tanggal' => $tanggal,
			'tahun' => $tahun
		);

		$where = array(
			'id' => $id
		);

		$this->transaksi_model->update($where, $data, 'transaksi');

		return $this->response($data, REST_Controller::HTTP_OK);
	}

	public function transaksi_destroy_post($id)
	{
		$this->transaksi_model->delete($id);

		return $this->response(['msg' => 'success'], REST_Controller::HTTP_OK);
	}

	// public function transaksiUpdate_post($id)
	// {
	// 	$kode = $this->input->post('kode');
	// 	$kegiatan = $this->input->post('kegiatan');
	// 	$pengeluaran = $this->input->post('pengeluaran');

	// 	$data = array(
	// 		'kode' => $kode,
	// 		'kegiatan' => $kegiatan,
	// 		'pengeluaran' => $pengeluaran,
	// 	);

	// 	$where = array(
	// 		'id' => $id
	// 	);

	// 	$this->transaksi_model->update($where, $data, 'transaksi');
	// 	$this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
	// }

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
			$anggaranBulanTemp = $this->admin_model->anggaran_bulan($month);
			$pengeluaranBulanTemp = $this->admin_model->pengeluaran_bulan($monthTemp[0]->bulan);
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

	public function statistic_get()
	{
		$month = intval(date('m'));
		$anggaranBulanTemp = $this->admin_model->anggaran_bulan(month($month));
		$pengeluaranBulanTemp = $this->admin_model->pengeluaran_bulan($month);
		$data['anggaran_bulan'] = intval($anggaranBulanTemp[0]->anggaran);
		$data['pengeluaran_bulan'] = intval($pengeluaranBulanTemp[0]->pengeluaran);
		$data['sisa_anggaran'] = intval($anggaranBulanTemp[0]->anggaran - $pengeluaranBulanTemp[0]->pengeluaran);
		$data['anggaran_tahunan'] = $this->admin_model->anggaran_tahunan();
		$data['pengeluaran_tahunan'] = $this->admin_model->pengeluaran_tahunan();
		$data['sisa_tahunan'] = $this->admin_model->sisa_tahunan();
		
		$this->response($data, REST_Controller::HTTP_OK);
	}

	public function login_post()
	{
		$raw = json_decode($this->input->raw_input_stream, true);

		if (!$raw) {
			$raw = [];
		}

		$email = array_key_exists('email', $raw) ? $raw['email'] : $this->input->post('email');
		$password = array_key_exists('password', $raw) ? $raw['password'] : $this->input->post('password');

		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		
		if ($user) {
			if (password_verify($password, $user['password'])) {
				$data = [
					'email' => $user['email'],
					'name' => $user['name'],
					'role_id' => $user['role_id'],
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

	public function rekap_get($year, $month)
	{
		$data['year'] = $year;
		$data['month'] = $month;
		$data['monthTemp'] = $this->admin_model->monthstr($data['month']);
		$anggaranBulanTemp = $this->rekap_model->anggaran_bulan($data);	
		$pengeluaranBulanTemp = $this->rekap_model->pengeluaran_bulan($data);

		$data['anggaran_bulan'] = intval($anggaranBulanTemp[0]->anggaran);
		$data['pengeluaran_bulan'] = intval($pengeluaranBulanTemp[0]->pengeluaran);
		$data['sisa_anggaran'] = $anggaranBulanTemp[0]->anggaran - $pengeluaranBulanTemp[0]->pengeluaran;
		$data['rekap'] = $this->rekap_model->rekap($data);

		return $this->response($data, REST_Controller::HTTP_OK);
	}
  
	// public function logout()
	// {
	// 	$this->session->unset_userdata('email');
	// 	$this->session->unset_userdata('role_id');
	// 	$this->session->unset_userdata('password');

	// 	return $this->response(['logout successfully.'], REST_Controller::HTTP_OK);
	// }
}
