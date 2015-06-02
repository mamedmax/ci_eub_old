<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod_kelas extends CI_Model { 
 
 	function getAll() 
 	{ 
 		$ambildata = $this->db->get('kelas');
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

 	public function getKls($id)
 	{
 		//if ($id){
 			$sql = "select * from kelas where kelas like '%".$id."%'";
 		//} else {
 			//$sql = "select * from kelas "; 
 		//}

 		
		$cari= $this->db->query($sql)->result_array();
		return $cari;

 	}

 	public function insertKls($data) 
 	{
		$this->db->insert('kelas', $data);
		
		if ($this->db->affected_rows() > 0)
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}

	public function updKls($id,$idk,$k)
	{
		$this->db->set('kelas',$k);
		$this->db->set('id_kls',$idk);
		$this->db->where('id_kls',$id);
		$this->db->update('kelas');

	}

	public function delKls($id)
	{
		$this->db->where('id_kls', $id);
		$this->db->delete('kelas'); 
	}

	//public function




}