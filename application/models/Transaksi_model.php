<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Transaksi_model extends CI_Model
{

	private $STORE_REQUIRED_FIELDS = ['kode:string', 'kegiatan:string', 'pengeluaran:integer', 'tahun:integer', 'tanggal:string'];
	private $MONTH = [
		'Januari' => 1,
		'Februari' => 2,
		'Maret' => 3,
		'April' => 4,
		'Mei' => 5,
		'Juni' => 6,
		'Juli' => 7,
		'Agustus' => 8,
		'September' => 9,
		'Oktober' => 10,
		'November' => 11,
		'Desember' => 12
	];

	function get_data()
	{
		$this->db->select('transaksi.id,transaksi.kode,transaksi.kegiatan,transaksi.pengeluaran,transaksi.tanggal,tahun.tahun,');
		$this->db->from('transaksi');
		$this->db->join('tahun', 'tahun.id = transaksi.tahun','left');
		$data = $this->db->get();
		return $data;
	}

	function save($data)
	{
		$data['created_at'] = date("Y-m-d");
		$this->db->insert('transaksi', $data);
	}

	function update($where, $data, $table)
	{
		$data['created_at'] = date("Y-m-d");
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	function searchKode($data)
	{
		$this->db->select('kode');
		$this->db->from('anggaran');
		$this->db->where('kegiatan', $data);
		return $this->db->get();

	}

	function searchMbuh($kode)
	{
		$this->db->select('id, kode');
		$this->db->from('transaksi');
		$this->db->where('kode', $kode);
		return $this->db->get();

	}

	function delete($id)
	{
		$this->db->delete('transaksi', array('id' => $id));
	}

	function validate_fields_store($post)
	{
		$errors = array();

		foreach ($this->STORE_REQUIRED_FIELDS as $key => $value) {
			$field = explode(':', $value);
			$name = $field[0];
			$type = $field[1];
			if (!array_key_exists($name, $post) || (array_key_exists($name, $post) && ($post[$name] == null || $post[$name] == ''))) {
				array_push($errors, $name . ' tidak boleh kosong');
			} else {
				if ($type == 'integer') {
					if (intval($post[$name]) == 0) {
						array_push($errors, $name . ' harus angka');
					}
				} else if (gettype($post[$name]) != $type) {
					array_push($errors, $name . ' harus ' . $type);
				}
			}
		}
		
		if ($errors) {
			return $errors;
		}

		$bulan_tanggal = $this->bulan_indo(date("Y-m-d", strtotime($post['tanggal'])));
		$tahun_tanggal = $this->tahun_indo(date("Y-m-d", strtotime($post['tanggal'])));

		$this->db->select('id, kode, bulan_realisasi');
		$this->db->from('anggaran');
		$this->db->where('kode', $post['kode']);
		$anggaran = $this->db->get()->result();

		$bulans = json_decode($anggaran[0]->bulan_realisasi);

		if (!in_array($bulan_tanggal, $bulans)) {
			array_push($errors, 'Transaksi hanya untuk bulan berikut : ' . $anggaran[0]->bulan_realisasi);
		} else {
			$this->db->select('id, kode');
			$this->db->from('transaksi');
			$this->db->where('kode', $post['kode']);
			$this->db->where('MONTH(tanggal)', $this->MONTH[$bulan_tanggal]);
			$this->db->where('YEAR(tanggal)', $tahun_tanggal);
			$transaksi = $this->db->get()->result();
			if (count($transaksi) > 0) {
				array_push($errors, 'Transaksi di bulan tersebut sudah ada');
			}
		}
		
		if ($errors) {
			return $errors;
		}
		
		return false;
	}

	// tgl_indo(date("Y-m-d", strtotime($item->tanggal)))
	function bulan_indo($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		
		// variabel pecahkan 0 = tahun
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tanggal
	 
		return $bulan[ (int)$pecahkan[1] ];
	}

	// tgl_indo(date("Y-m-d", strtotime($item->tanggal)))
	function tahun_indo($tanggal){
		$pecahkan = explode('-', $tanggal);
		
		// variabel pecahkan 0 = tahun
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tanggal
	 
		return $pecahkan[0];
	}
}
