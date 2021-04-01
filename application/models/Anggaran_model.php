<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Anggaran_model extends CI_Model
{
	
	private $STORE_REQUIRED_FIELDS = ['kode:string', 'kegiatan:string', 'anggaran:integer', 'tahun:integer', 'volume:integer', 'bulan:array'];

	function get_data()
	{
		$this->db->select('anggaran.id,anggaran.kode,anggaran.kegiatan,anggaran.kode,anggaran.anggaran,anggaran.volume,anggaran.bulan_realisasi,tahun.tahun');
		$this->db->from('anggaran'); 
		$this->db->join('tahun', 'tahun.id = anggaran.tahun','left');
		$data = $this->db->get();
		return $data;
	}

	function get_one($where)
	{
		$this->db->select('anggaran.id,anggaran.kode,anggaran.kegiatan,anggaran.kode,anggaran.anggaran,anggaran.volume,anggaran.bulan_realisasi,anggaran.tahun');
		$this->db->from('anggaran');
		$this->db->where($where);
		$res = $this->db->get()->result();
		return $res;
	}

	function save($data)
	{
		$data['created_at'] = date("Y-m-d");
		$this->db->insert('anggaran', $data);
	}

	function update($where, $data, $table=null, $table2=null)
	{
		// $this->db->select('kode');
		// $this->db->from('anggaran');
		// $this->db->where($where);
		// $Temp = $this->db->get()->result();
		// $data['created_at'] = date("Y-m-d");
		// $kode = $Temp['kode'];

		$this->db->where($where);
		$this->db->update('anggaran', $data);

		// $this->db->query("UPDATE `transaksi` SET `kode`= '".$data['kode']."' WHERE `kode` = '".$kode."'");
		// $this->db->last_query();

		// $this->db->set('kode',$data['kode']);
		// $this->db->where('kode',$kode);
		// $this->db->update('transaksi');


		return;
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
		
		$anggaran = $this->get_one(['kode' => $post['kode']]);
		
		if (count($anggaran) > 0) {
			array_push($errors, 'Kode sudah ada');
		}

		if ($errors) {
			return $errors;
		}

		return false;
	}

	function updateku($table = '', $data = NULL, $where = NULL, $limit = NULL) {
		$this->db->where($where);
		return $this->db->update($table, $data);
		// $this->db->where($where);
		// $this->db->from($table);
		// $res = $this->db->get();
		// return $res; 
	}

	function delete($id)
	{
		$this->db->delete('anggaran', array('id' => $id));
		return;
	}

	function getdata($kegiatan = array())
	{
		$response = array();
		if (isset($kegiatan['kegiatan'])) {

			$this->db->select('*');
			$this->db->where('kegiatan', $kegiatan['kegiatan']);
			$record = $this->db->get('anggaran');
			$response = $record->result();
		}

		// print_r($kode);
		// die;
		return $response;
	}
}
