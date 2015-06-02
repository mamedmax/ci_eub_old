<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod_user extends CI_Model { 
 
 	function getAll() 
 	{ 
 		$ambildata = $this->db->get('akademik');
		//jika data ada (lebih dari 0)
		if ($ambildata->num_rows() > 0 ) 
		{
		 	foreach ($ambildata->result() as $data) 
		 	{
		 		$hasil[] = $data;
 			}
 			return $hasil;
 		}

 		//$tkls = $this->db->count_all('kelas');
 	}

 	public function listUsr($id)
 	{
 		//if ($id){
 			$sql = "select * from akademik where nama like '%".$id."%'";
 		//} else {
 			//$sql = "select * from kelas "; 
 		//}

 		
		$cari= $this->db->query($sql)->result_array();
		return $cari;

 	}

 	public function insertUsr($data) 
 	{
		$this->db->insert('akademik', $data);
		
		if ($this->db->affected_rows() > 0)
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}

	public function updUsr($data)
	{
		
		if ( $data['pwd'] == "" )
		{
			
			$this->db->set('username',$data['username']);
			$this->db->set('nama',$data['nama']);
			$this->db->set('posisi',$data['posisi']);
			$this->db->where('id_user',$data['id_user']);
			$this->db->update('akademik');
			
		}else{
			
			$this->db->set('pwd',$data['pwd']);
			$this->db->set('username',$data['username']);
			$this->db->set('nama',$data['nama']);
			$this->db->set('posisi',$data['posisi']);
			$this->db->where('id_user',$data['id_user']);
			$this->db->update('akademik');
		}
		
	}

	public function delUsr($id)
	{
		$this->db->where('id_user', $id);
		$this->db->delete('akademik'); 
	}

	//public function




}