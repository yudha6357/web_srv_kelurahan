<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Transaksi_model extends CI_Model
{

	function get_data()
	{
		return $this->db->get('transaksi');
	}

	function save($data)
	{
		$this->db->insert('transaksi', $data);
	}

	function update($where, $data, $table)
	{
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	function delete($id)
	{
		$this->db->delete('transaksi', array('id' => $id));
	}
}
