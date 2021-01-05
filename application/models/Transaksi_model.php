<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Transaksi_model extends CI_Model
{

	function get_data()
	{
		return $this->db->get('transaksi');
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

	function delete($id)
	{
		$this->db->delete('transaksi', array('id' => $id));
	}
}
