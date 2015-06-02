<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod_mhs extends CI_Model { 
 
 	function listmhs($id) 
 	{ 

		$sql = "SELECT 
					nim, nama, jekel, angkatan, id_kls,
				    IF(status = 1, 'Aktif', 'Non-Aktif') as status_
				FROM mahasiswa 
				WHERE nama LIKE '%".$id."%' ";
		
		$mhs = $this->db->query($sql)->result_array();
		return $mhs;
	}


	public function insertMhs($data) 
 	{
		$this->db->insert('mahasiswa', $data);
		
		if ($this->db->affected_rows() > 0)
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}

	public function delMhs($id)
	{
		$this->db->where('nim', $id);
		$this->db->delete('mahasiswa'); 
	}

}