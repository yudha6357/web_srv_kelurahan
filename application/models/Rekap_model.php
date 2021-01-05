<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rekap_model extends CI_Model
{

	function rekap($data)
	{
		$query = $this->db->query("SELECT a.kegiatan, a.anggaran, IFNULL (g.pengeluaran,0) pengeluaran, IFNULL(a.anggaran-g.pengeluaran,a.anggaran) sisa 
			FROM anggaran a 
				LEFT JOIN( SELECT t.kode, SUM(t.pengeluaran)as pengeluaran 
				from transaksi t 
				WHERE MONTH(t.created_at) =" . $data['monthTemp'] ." AND YEAR(t.created_at) = " .$data['year'] ." GROUP BY t.kode , t.pengeluaran) as g 
			ON g.kode = a.kode WHERE a.bulan_realisasi LIKE ".$data['month'] ." and YEAR(a.created_at) = " . $data['year'])->result();
		return $query;
	}

	function anggaran_bulan($data)
	{
		$array = array('year(created_at)' => $data['year'], 'bulan_realisasi like' => '%'.$data['month'].'%');
		$this->db->select_sum('anggaran');
		$this->db->from('anggaran');
		$this->db->where($array);
		return $this->db->get();
	}

	function pengeluaran_bulan($data)
	{
		$this->db->select_sum('pengeluaran');
		$this->db->from('transaksi');
		$this->db->where('month(created_at)', $data['monthTemp']);
		$this->db->where('year(created_at)', $data['year']);
		return $this->db->get();
	}


	function anggaran_tahunan()
	{
		$query = [
			'Januari',
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
			'Desember',
		];
		$array = array();

		foreach ($query as $row) {
			$this->db->select_sum('anggaran');
			$this->db->from('anggaran');
			$this->db->like('bulan_realisasi', $row);
			$anggaran = $this->db->get()->result();
			$array[] = $anggaran[0]->anggaran;
		}
		return $array;
	}

	function sisa_tahunan()
	{
		$query = [
			'01',
			'02',
			'03',
			'04',
			'05',
			'06',
			'07',
			'08',
			'09',
			'10',
			'11',
			'12',

		];
		$array = array();

		foreach ($query as $row) {
			# code...
			$this->db->select_sum('pengeluaran');
			$this->db->from('transaksi');
			$this->db->where('month(created_at)', $row);
			$sisa = $this->db->get()->result();
			$array[] = $sisa[0]->pengeluaran;
		}

		return $array;
	}
}
