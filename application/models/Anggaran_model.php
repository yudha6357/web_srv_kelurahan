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

	function save($data)
	{
		$data['created_at'] = date("Y-m-d");
		$this->db->insert('anggaran', $data);
	}

	function update($where, $data, $table)
	{
		$data['created_at'] = date("Y-m-d");
		$this->db->where($where);
		$this->db->update($table, $data);
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
