<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod_dosen extends CI_Model { 
 
 	function getAll() 
 	{ 
 		$ambildata = $this->db->get('dosen');
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

 	public function alldosen() 
 	{
        $query = $this
                    ->db
                    ->select('id_dosen, nama_dosen')
                    //->where('status', 'Active')
                    //->where('username !=', $this->session->userdata('username'))
                    ->get('dosen');
        return $query->result(); //return result to array
    }

 	public function insertDosen($data) 
 	{
		$this->db->insert('dosen', $data);
		
		if ($this->db->affected_rows() > 0)
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}

	public function getDosen($id)
	{
		$sql = "SELECT * FROM dosen WHERE id_dosen='".$id."'";
		
		$det = $this->db->query($sql)->result_array();
		return $det;
	}

	public function getDosKls($id,$nim)
	{
		$sql = "SELECT 
					a.id_dosen, 
					a.nama_dosen, 
					group_concat(b.matakuliah ORDER BY b.matakuliah ASC SEPARATOR ', ') as matakuliah,
					IF( (SELECT c.id_eub_dosen FROM eub_dosen c WHERE c.nim='".$nim."' AND c.id_dosen=a.id_dosen) IS NULL, 'Belum', 'Sudah') as stat
				FROM 
					dosen a 
				JOIN 
					dosen_detail b 
				ON a.id_dosen=b.id_dosen
				WHERE b.id_kls='".$id."'
				GROUP BY a.id_dosen
				";
		
		$dsn = $this->db->query($sql)->result_array();
		return $dsn;
	}

	public function getADosKls($id,$kls)
	{
		$sql = "SELECT 
					a.id_dosen, 
					a.nama_dosen, 
					group_concat(b.matakuliah ORDER BY b.matakuliah ASC SEPARATOR ', ') as matakuliah 
				FROM 
					dosen a 
				JOIN 
					dosen_detail b 
				ON a.id_dosen=b.id_dosen
				WHERE b.id_kls='".$kls."' AND a.id_dosen='".$id."' GROUP BY a.id_dosen";
		
		$dsn = $this->db->query($sql)->result_array();
		return $dsn;
	}

	public function getDsnOnKls($kls)
	{
		$sql = "SELECT a.id_dosen, a.nama_dosen
				FROM dosen a JOIN dosen_detail b ON a.id_dosen=b.id_dosen
				WHERE b.id_kls='".$kls."'
				GROUP BY a.id_dosen
				ORDER BY a.id_dosen ASC ";

		$dsn = $this->db->query($sql)->result_array();
		return $dsn;
	}

	public function detDosen($id)
	{
		$sql = "SELECT a.id_dosen, a.nama_dosen, b.id_kls, b.matakuliah FROM dosen a JOIN dosen_detail b WHERE a.id_dosen=b.id_dosen AND a.id_dosen='".$id."'";
		
		$det = $this->db->query($sql)->result_array();
		return $det;
	}

	public function addDetdos($data)
	{
		$this->db->insert('dosen_detail', $data);
		
		if ($this->db->affected_rows() > 0)
		{
			return true;
		} 
		else 
		{
			return false;
		}

	}

	public function updateDos($id,$data)
	{

		$this->db->set('a.id_dosen', $data['id_dosen']);
		$this->db->set('a.nama_dosen', $data['nama_dosen']);
		$this->db->set('b.id_dosen', $data['id_dosen']);

		$this->db->where('a.id_dosen', $id);
		$this->db->where('a.id_dosen = b.id_dosen');
		$this->db->update('dosen as a, dosen_detail as b');

	}

	public function updDetdos($id,$data)
	{
		$this->db->where('id_dosen', $id);
		$this->db->update('dosen_detail', $data["id_dosen"]);


	}

	public function delDosen($id)
	{
		$this->db->where('id_dosen', $id);
		$this->db->delete('dosen'); 
	}

	public function delmtkDosen($ids,$kls,$mtk)
	{
		$this->db->where('id_dosen', $ids);
		$this->db->where('id_kls', $kls);
		$this->db->where('matakuliah', $mtk);
		$this->db->delete('dosen_detail'); 
	}



}