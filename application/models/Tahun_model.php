<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Tahun_model extends CI_Model
{

	function get_data()
	{
		return $this->db->get('tahun');
	}

	function save($data)
	{
		$data['created_at'] = date("Y-m-d");
		$this->db->insert('tahun', $data);
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

	function tahun_option()
	{
		$year = array();
        $now = date('Y', strtotime(' +1 Year'));
        $a = date('Y');
        for ($i = 0; $i < 10; $i++) {
            $year[$i] = $a . '/' . $now;
            $a = $a - 1;
            $now = $now - 1;
        }
		return $year;
	}

	function get_tahun()
	{
		$this->db->select('*');
		$this->db->from('tahun');
		$this->db->where('is_active',1);
		$data = $this->db->get();
		return $data;
	}
}
