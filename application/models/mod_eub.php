<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod_eub extends CI_Model { 
 
 	function getAll() 
 	{ 
 		$ambildata = $this->db->get('eub');
		//jika data ada (lebih dari 0)
		if ($ambildata->num_rows() > 0 ) 
		{
		 	foreach ($ambildata->result() as $data) 
		 	{
		 		$hasil[] = $data;
 			}
 			return $hasil;
 		}
 	}




 	public function cari_id()
 	{
 		$sql = "SELECT IFNULL(MAX(id_eub_dosen), 0)+1 AS id_eub_dosen FROM eub_dosen ";
 		 		
		$cari = $this->db->query($sql)->result_array();
		
		foreach($cari as $item)
		{
			$id_eub = $item['id_eub_dosen'];
		}

		return $id_eub;

 	}

 	
 	public function ins_eub_head($data) 
 	{
		$this->db->insert('eub_dosen', $data);
		
		if ($this->db->affected_rows() > 0)
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}


 	public function ins_eub_detail($data,$id) 
 	{
		
 		foreach ($data as $dt)
 		{
 			$jw = array(
 					'id_eub_dosen' => $id,
 					'id_soal' => $dt['id_soal'],
 					'jwb' => $dt['n']
 				);

 			$tl = $tl + $jw['jwb'];

 			$this->db->insert('eub_dosen_detail', $jw);
 		} 

		$this->db->set('total',$tl);
		$this->db->where('id_eub_dosen',$id);
		$this->db->update('eub_dosen');

		
		if ($this->db->affected_rows() > 0)
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}


	public function eubAllDosen()
	{

		$sql = "SELECT a.id_eub_dosen, a.id_dosen, b.nama_dosen, TRUNCATE(AVG(a.total), 1) as nilai, 
					(IF(avg(a.total) >= 65.1, 'A (Sangat Memuaskan)', 
					 IF(avg(a.total) >= 55.1, 'B (Memuaskan)', 
					 IF(avg(a.total) >= 45.1, 'C (Cukup Memuaskan)', 
					 IF(avg(a.total) >= 35.1, 'D (Kurang Memuaskan)', 'E (Sangat Kurang Memuaskan)'))))) as ket

				FROM eub_dosen a 

					JOIN dosen b ON a.id_dosen=b.id_dosen

				GROUP BY a.id_dosen ";
		
		$data = $this->db->query($sql)->result_array();
		return $data;
	}

	public function eubDsnKls($k)
	{

		$sql = "SELECT a.id_eub_dosen, a.id_dosen, b.nama_dosen, TRUNCATE(AVG(a.total), 1) as nilai, 
					(IF(avg(a.total) >= 65.1, 'A (Sangat Memuaskan)', 
					 IF(avg(a.total) >= 55.1, 'B (Memuaskan)', 
					 IF(avg(a.total) >= 45.1, 'C (Cukup Memuaskan)', 
					 IF(avg(a.total) >= 35.1, 'D (Kurang Memuaskan)', 'E (Sangat Kurang Memuaskan)'))))) as ket

				FROM eub_dosen a 
					JOIN dosen b ON a.id_dosen=b.id_dosen
					JOIN mahasiswa c ON a.nim=c.nim

				WHERE c.id_kls='".$k."'
				GROUP BY a.id_dosen
				ORDER BY a.id_dosen ASC ";
		
		$data = $this->db->query($sql)->result_array();
		return $data;
	}
	


	public function getResp($dsn,$kls)
	{
		$sql = "SELECT count(a.nim) as resp

				FROM eub_dosen a JOIN mahasiswa b ON b.nim = a.nim

				WHERE a.id_dosen='".$dsn."' AND b.id_kls='".$kls."' ";

		$data = $this->db->query($sql)->result_array();
		return $data;

	}

	public function getRekapJwbDsn($id,$kls)
	{
		$sql = "SELECT  a.id_eub_dosen,
				        MAX(IF(a.id_soal = 1, a.jwb, NULL)) s1,
				        MAX(IF(a.id_soal = 2, a.jwb, NULL)) s2,
				        MAX(IF(a.id_soal = 3, a.jwb, NULL)) s3,
				        MAX(IF(a.id_soal = 4, a.jwb, NULL)) s4,
				        MAX(IF(a.id_soal = 5, a.jwb, NULL)) s5,
				        MAX(IF(a.id_soal = 6, a.jwb, NULL)) s6,
				        MAX(IF(a.id_soal = 7, a.jwb, NULL)) s7,
				        MAX(IF(a.id_soal = 8, a.jwb, NULL)) s8,
				        MAX(IF(a.id_soal = 9, a.jwb, NULL)) s9,
				        MAX(IF(a.id_soal = 10, a.jwb, NULL)) s10,
				        MAX(IF(a.id_soal = 11, a.jwb, NULL)) s11,
				        MAX(IF(a.id_soal = 12, a.jwb, NULL)) s12,
				        MAX(IF(a.id_soal = 13, a.jwb, NULL)) s13,
				        MAX(IF(a.id_soal = 14, a.jwb, NULL)) s14,
				        MAX(IF(a.id_soal = 15, a.jwb, NULL)) s15,
				        MAX(IF(a.id_soal = 16, a.jwb, NULL)) s16,
				        sum(a.jwb) as totalp
				     

				FROM eub_dosen_detail a

				JOIN eub_dosen b ON a.id_eub_dosen = b.id_eub_dosen

				JOIN mahasiswa c ON b.nim = c.nim

				WHERE b.id_dosen = '".$id."' AND c.id_kls = '".$kls."'

				GROUP BY a.id_eub_dosen  ";

		$data = $this->db->query($sql)->result_array();
		return $data;
		//--count(a.id_eub_dosen) as jml_res
	}




}