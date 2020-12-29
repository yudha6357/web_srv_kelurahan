<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Anggaran_model extends CI_Model
{

	function get_data()
	{
		return $this->db->get('anggaran');
	}

	function save($data)
	{
		$this->db->insert('anggaran', $data);
	}

	function update($where, $data, $table)
	{
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	function delete($id)
	{
		$this->db->delete('anggaran', array('id' => $id));
		return;
	}

	function getdata($kode = array())
	{
		$response = array();
		if (isset($kode['kode'])) {

			$this->db->select('*');
			$this->db->where('kode', $kode['kode']);
			$record = $this->db->get('anggaran');
			$response = $record->result();
		}

		// print_r($kode);
		// die;
		return $response;
		// 	$this->db->get_where('anggaran', array('kode =' => $kode))->result();
		// return;
	}
}
