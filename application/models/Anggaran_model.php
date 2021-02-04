<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Anggaran_model extends CI_Model
{

	function get_data()
	{
		$this->db->select('anggaran.id,anggaran.kode,anggaran.kegiatan,anggaran.kode,anggaran.anggaran,anggaran.volume,anggaran.bulan_realisasi,tahun.tahun');
		$this->db->from('anggaran'); 
		$this->db->join('tahun', 'tahun.id = anggaran.tahun','right');
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
		$this->db->select('kode');
		$this->db->from('anggaran');
		$this->db->where($where);
		$Temp = $this->db->get()->result();
		$data['created_at'] = date("Y-m-d");
		$kode = $Temp['kode'];

		$this->db->where($where);
		$this->db->update($table, $data);

		// $this->db->query("UPDATE `transaksi` SET `kode`= '".$data['kode']."' WHERE `kode` = '".$kode."'");
		// $this->db->last_query();

		$this->db->set('kode',$data['kode']);
		$this->db->where('kode',$kode);
		$this->db->update('transaksi');


		return;
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
