<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Rekap_model extends CI_Model
{

	function rekap($data)
	{
		$query = $this->db->query("SELECT a.kegiatan, a.anggaran, IFNULL (g.pengeluaran,0) pengeluaran, IFNULL(a.anggaran-g.pengeluaran,a.anggaran) sisa
		FROM anggaran a
		LEFT JOIN (SELECT t.kode, SUM(t.pengeluaran)as pengeluaran from transaksi t GROUP BY t.kode , t.pengeluaran) as g
		ON g.kode = a.kode WHERE a.bulan_realisasi LIKE '%$data%'")->result();
		return $query;
	}

	function anggaran_bulan($month)
	{
		$this->db->select_sum('anggaran');
		$this->db->from('anggaran');
		$this->db->like('bulan_realisasi', $month);
		return $this->db->get();
	}

	function pengeluaran_bulan($month)
	{
		$this->db->select_sum('pengeluaran');
		$this->db->from('transaksi');
		$this->db->where('month(created_at)', $month);
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
