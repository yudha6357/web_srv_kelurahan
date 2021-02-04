<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model
{

	function get_month()
	{
		$month = date('m');
		$year = date('Y');
		$this->db->select('month(tanggal) as bulan');
		$this->db->from('transaksi');
		$this->db->where('month(tanggal)', $month);
		$this->db->where('year(tanggal)', $year);
		return $this->db->get();

	}

	function anggaran_bulan($month)
	{
		$year = date('Y');
		$query = $this->db->query("SELECT sum(t.anggaran) as anggaran from (SELECT a.anggaran, a.bulan_realisasi,ta.tahun FROM `anggaran` a RIGHT join tahun ta on a.tahun = ta.id) t WHERE t.bulan_realisasi LIKE '%".$month."%' AND t.tahun = ".$year)->result();
	return $query;
	}

	function anggaran_bulan_rekap($data)
	{
	

		// $array = array('year(created_at)' => $year, 'bulan_realisasi like' => '%'.$month.'%');
		$this->db->select_sum('anggaran');
		$this->db->from('anggaran');
		$this->db->where('tahun',1);
		return $this->db->get();
	}

	function pengeluaran_bulan($month)
	{
		$year = date('Y');

		$query = $this->db->query("SELECT SUM(tr.pengeluaran) as pengeluaran FROM `transaksi` tr RIGHT JOIN tahun ta on tr.tahun = ta.id WHERE Month(tr.tanggal) =".$month." AND Year(tr.tanggal) =".$year." AND Year(tr.tanggal) = ta.tahun")->result();
		
		return $query;
	}

	function anggaran_tahunan()
	{
		$year = date('Y');

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
			$this->db->join('tahun', 'tahun.id = anggaran.tahun','right');
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
		$bulan = [
			'01'=>'Januari',
			'02'=>'Februari',
			'03'=>'Maret',
			'04'=>'April',
			'05'=>'Mei',
			'06'=>'Juni',
			'07'=>'Juli',
			'08'=>'Agustus',
			'09'=>'September',
			'10'=>'Oktober',
			'11'=>'November',
			'12'=>'Desember',

		];
	
		$array = array();

		foreach ($bulan as $i => $row) {
			$query = $this->db->query("SELECT SUM(anggaran-pengeluaran) as pengeluaran FROM (SELECT tr.pengeluaran ,tr.tahun FROM `transaksi` tr RIGHT JOIN tahun ta on tr.tahun = ta.id WHERE Month(tr.tanggal) = ".$i.") t RIGHT JOIN anggaran a on a.bulan_realisasi LIKE '%".$row."%' WHERE a.tahun = t.tahun")->result();
			$array[] = $query[0]->pengeluaran;
		
		}

		return $array;
	}

	function sisa_tahunan_api()
	{
		$year = date('Y');

		$this->db->select_sum('anggaran');
		$this->db->from('anggaran');
		$this->db->where('year(created_at)', $year);
		$this->db->where('tahun',1);
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

	private function month_id(){
		$number = [
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

		$text = [
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
	}
}
