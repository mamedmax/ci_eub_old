<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod_login extends CI_Model { 
 
 	function cek_admin($data) 
 	{ 

		$sql = "select * from akademik where username='".$data['username']."' 
					and pwd='".$data['pwd']."'";
					
		$exec=$this->db->query($sql) or die (mysql_error);
		
		if ($exec->num_rows = 1)
		{
			return $exec;
		} else {

			return false;
		}

		
	}

	function cek_mhs($data) 
 	{ 

		$sql = "select * from mahasiswa where nim='".$data['nim']."' 
					and pwd='".$data['pwd']."'";

		$exec=$this->db->query($sql) or die (mysql_error);
		
		if ($exec->num_rows = 1)
		{
			return $exec;
		} else {

			return false;
		}

		
	}


	
}