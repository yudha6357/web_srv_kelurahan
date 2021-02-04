<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Transaksi_model extends CI_Model
{

	function get_data()
	{
		$this->db->select('transaksi.id,transaksi.kode,transaksi.kegiatan,transaksi.pengeluaran,transaksi.tanggal,tahun.tahun,');
		$this->db->from('transaksi');
		$this->db->join('tahun', 'tahun.id = transaksi.tahun','right');
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
}
