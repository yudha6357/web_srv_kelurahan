<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model
{

	function get_month()
	{
		$month = date('m');
		$year = date('Y');
		// print_r($b);
		// die();
		$this->db->select('month(created_at) as bulan');
		$this->db->from('transaksi');
		$this->db->where('month(created_at)', $month);
		$this->db->where('year(created_at)', $year);
		return $this->db->get();
	}

	function anggaran_bulan($month)
	{
		$year = date('Y');
		$array = array('year(created_at)' => $year, 'bulan_realisasi like' => '%'.$month.'%');
		$this->db->select_sum('anggaran');
		$this->db->from('anggaran');
		$this->db->where($array);
		return $this->db->get();
	}

	function anggaran_bulan_rekap($data)
	{
	

		// $array = array('year(created_at)' => $year, 'bulan_realisasi like' => '%'.$month.'%');
		$this->db->select_sum('anggaran');
		$this->db->from('anggaran');
		// $this->db->where($array);
		return $this->db->get();
	}

	function pengeluaran_bulan($month)
	{
		$year = date('Y');

		$this->db->select_sum('pengeluaran');
		$this->db->from('transaksi');
		$this->db->where('month(created_at)', $month);
		$this->db->where('year(created_at)', $year);
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

	function pengeluaran_tahunan_api()
	{
		$year = date('Y');

		$this->db->select_sum('pengeluaran');
		$this->db->from('transaksi');
		$this->db->where('year(created_at)', $year);
		return $this->db->get()->result();
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

	function sisa_tahunan_api()
	{
		$year = date('Y');

		$this->db->select_sum('anggaran');
		$this->db->from('anggaran');
		$this->db->where('year(created_at)', $year);
		return $this->db->get()->result();
	}

	function monthstr($month)
	{
		switch ($month) {
			case 'Januari':
				$data ='01';
				break;
			case 'Februari':
				$data ='02';
				break;
			case 'Maret':
				$data ='03';
			break;
			case 'April':
				$data ='04';
			break;
			case 'Mei':
				$data ='05';
			break;
			case 'Juni':
				$data ='06';
			break;
			case 'Juli':
				$data ='07';
			break;
			case 'Agustus':
				$data ='08';
			break;
			case 'September':
				$data ='09';
			break;
			case 'Oktober':
				$data ='10';
			break;
			case 'November':
				$data ='11';
			break;
			case 'Desember':
				$data ='12';
			break;
			default:
			$data = 'Data tidak di temukan';
		}

		return $data;
	}
}
