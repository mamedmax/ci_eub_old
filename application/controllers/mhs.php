<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mhs extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('datatables');
		$this->load->helper('array');
		$this->load->helper('security');

	}


	public function index0()
	{
		//$this->load->helper('url');
		
		$data = array('title'=>'Mhs EUB',
					  'isi'=>'mhs/mhs_index'
						);
		
		$this->load->view('mhs/layout/wrapper',$data);
	}

	public function index()
	{
		if($this->session->userdata('mhs_logged_in') == TRUE)
		{
			$this->dashboard();

		} else 
		{
		    $this->login();
		}
		
		
	}

	public function login()
	{

		if($this->session->userdata('mhs_logged_in') == FALSE )
		{
			//If no session, redirect to login page
			$data = array('title'=>'Login Mahasiswa | EUB',
					      'isi'=>''
						 );
		
			$this->load->view('mhs/login',$data);

		} else {

			$this->dashboard();
		
		}

	}


	public function dologin()
	{
		$data = array('nim' => $this->input->post('nim', TRUE),
					  'pwd' => do_hash($this->input->post('pw', TRUE))
					 );

		$this->load->model('mod_login');

		$exec = $this->mod_login->cek_mhs($data);

		
		if ($exec->num_rows() == 1 )
		{	
			$read=$exec->result_array();
			$prejson=array('mhs_nama'=>$read[0]['nama'],
					   		'nim'=>$read[0]['nim'],
					   		'mhs_pwd'=>$read[0]['pwd'],
					   		'id_kls'=>$read[0]['id_kls'],
					   		'mhs_logged_in'=>TRUE

					       );
								
			$this->session->set_userdata($prejson);
		
			print json_encode($prejson);

		} else {

			//echo "<script>alert('Gagal login: Cek username, password!');history.go(-1);</script>";
			//return false;
			$prejson=array(
					   		'mhs_logged_in'=>''

					       );
								
			//$this->session->set_userdata($prejson);
		
			print json_encode($prejson);

		}
		
	}

	public function kunci(){
		$readSess=$this->session->all_userdata();
		if(!isset($readSess['nim']) && !isset($readSess['mhs_pwd'])){
			redirect('mhs/login');
		}
	}

	public function logout(){
		//$this->load->library('session');
		$this->session->sess_destroy();
		redirect('mhs/login');
	}



	public function dashboard()
	{
		$this->kunci();
		
		$data = array('title'=>'EUB Dosen | Mahasiswa',
					  'head'=>'Sistem Informasi Evaluasi Umpan Balik',
					  'isi'=>'mhs/mhs_index'
					 );
		
		$this->load->view('mhs/layout/wrapper',$data);
	}

	public function eubdosen()
	{
		$this->kunci();

		$data = array('title'=>'EUB Dosen | Mahasiswa',
					  'head'=>'Sistem Informasi Evaluasi Umpan Balik',
					  'isi'=>'mhs/mhs_eubdosen'
					 );
		
		$this->load->view('mhs/layout/wrapper',$data);

	}

	public function listdosen()
	{
		$this->kunci();
		$this->load->model('mod_dosen');

		$id = $this->input->post('id');
		$nim = $this->session->userdata('nim');


		$results = $this->mod_dosen->getDosKls($id,$nim);
        echo json_encode($results);

	}

	public function isieub()
	{
		$this->kunci();

		$id = $this->uri->segment(3);
		$kls = $this->session->userdata('id_kls');

		$this->load->model('mod_dosen');
		$this->load->model('mod_eub');
		
		$id_eub = $this->mod_eub->cari_id();
		$ds = $this->mod_dosen->getADosKls($id,$kls);

		foreach($ds as $dsn){
			$data = array('title'=>'EUB Dosen | Mahasiswa',
						  'head'=>'Sistem Informasi Evaluasi Umpan Balik',
						  'isi'=>'mhs/mhs_isieub',
						  '$id_eub'=>$id_eub,
						  'id'=>$id,
						  'nm'=>$dsn['nama_dosen'],
						  'mk'=>$dsn['matakuliah']
						 );
		}

		$this->load->view('mhs/layout/wrapper',$data);

	}

	public function isieubdosen()
	{
		$this->kunci();
		$this->load->model('mod_dosen');
		$this->load->model('mod_eub');

		$id_eub = $this->mod_eub->cari_id();
		$idd = $this->input->post('idd');
		$nim = $this->input->post('nim');
		$jsn = json_decode($this->input->post('jsn'), true);

			$dhead = array(
						'id_eub_dosen' => $id_eub,
						'nim' => $nim,
						'id_dosen' => $idd,
						'total' => 0
					 );
		//$jsn['id_eub_dosen'] = $id_eub;
		//$jsn['id_soal'];
		//$jsn['n'];
		//print_r($id_eub);
		//print_r($jsn);

		$this->mod_eub->ins_eub_head($dhead);
		$this->mod_eub->ins_eub_detail($jsn,$id_eub);



/*

		$jsn[] = array();

		for($i=1;$i<17;$i++)
		{
			$jsn['id_eub_dosen'] = $id_eub;

		}

		print_r($jsn);
*/


	}

	public function testo()
	{
		$this->kunci();
		
		$id = $this->uri->segment(3);
		$kls = $this->session->userdata('id_kls');

		$this->load->model('mod_dosen');

		$dsn = $this->mod_dosen->getADosKls($id,$kls);

		echo json_encode($dsn);
	}


}
/* End of file mhs.php */
/* Location: ./application/controllers/mhs.php */