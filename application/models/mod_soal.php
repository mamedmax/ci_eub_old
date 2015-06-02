<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod_soal extends CI_Model { 
 
 	function getAll() 
 	{ 
 		$ambildata = $this->db->get('soal');
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

 	public function getSoal($id)
 	{
 		//if ($id){
 			$sql = "select * from soal where id_soal like '%".$id."%'";
 		//} else {
 			//$sql = "select * from kelas "; 
 		//}

 		
		$list= $this->db->query($sql)->result_array();
		return $list;

 	}

 	public function getaSoal($id)
 	{
 		//if ($id){
 			$sql = "select * from soal where id_soal=".$id;
 		//} else {
 			//$sql = "select * from kelas "; 
 		//}

 		
		$list= $this->db->query($sql)->result_array();
		return $list;

 	}

 	public function insertSoal($data) 
 	{
		$this->db->insert('soal', $data);
		
		if ($this->db->affected_rows() > 0)
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}

	public function updSoal($id,$s)
	{
		$this->db->set('soal',$s);
		$this->db->where('id_soal',$id);
		$this->db->update('soal');


	}

	public function delSoal($id)
	{
		$this->db->where('id_soal',$id);
		$this->db->delete('soal'); 
	}





}