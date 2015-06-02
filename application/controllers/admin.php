<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//session_start();
class Admin extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('datatables');
		$this->load->helper('security');

	}

	public function index()
	{
		if($this->session->userdata('logged_in') == TRUE)
		{
		     //$session_data = $this->session->userdata('logged_in');
		     //$data['username'] = $session_data['username'];
		     $this->dashboard();

		} else
		{
		    $this->login();
		}
		
		
	}
	//--------------------------------------------------------------------------------
	//-------------------       LOGIN & sESSION FUNCTIONS      -----------------------
	//--------------------------------------------------------------------------------
	public function login()
	{
		if($this->session->userdata('logged_in') == FALSE )
		{
			//If no session, redirect to login page
			$data = array('title'=>'Login Admin EUB',
						  'isi'=>''
						 );
			
			$this->load->view('admin/login',$data);

		} else {

			$this->dashboard();
		

		}
	}

	public function dologin()
	{
		$data = array('username' => $this->input->post('un', TRUE),
						'pwd' => do_hash($this->input->post('pw', TRUE))
					);
		$this->load->model('mod_login');

		$exec = $this->mod_login->cek_admin($data);

		
		if ($exec->num_rows() == 1 )
		{	
			$read=$exec->result_array();
			$prejson=array('nama'=>$read[0]['nama'],
					   		'username'=>$read[0]['username'],
					   		'pwd'=>$read[0]['pwd'],
					   		'logged_in'=>TRUE
					 );
								
			$this->session->set_userdata($prejson);
		
			print json_encode($prejson);

		} else {
			//echo "<script>alert('Gagal login: Cek username, password!');history.go(-1);</script>";
			//$read=$exec->result_array();
			$prejson=array(
					   		'logged_in'=> ''
					 );
								
			//$this->session->set_userdata($prejson);
		
			print json_encode($prejson);

		}
		
	}

	public function kunci(){
		$readSess=$this->session->all_userdata();
		if(!isset($readSess['uname']) && !isset($readSess['pwd'])){
			redirect('admin/login');
		}
	}
	public function logout(){
		$this->load->library('session');
		$this->session->sess_destroy();
		redirect('admin/login');
	}

	public function logins()
	{
		//$this->load->helper('url');
		
		$data = array('title'=>'Login Admin EUB',
					  'isi'=>'admin/login'
						);
		
		$this->load->view('admin/layout/wrapper_login',$data);
	}
	//---------------------------------------------------------------------------------------
	//-------------------       END OF LOGIN & sESSION FUNCTIONS      -----------------------
	//---------------------------------------------------------------------------------------


	public function dashboard()
	{
		$this->kunci();
		
		$data = array('title'=>'Sistem Informasi Evaluasi Umpan Balik',
					  'isi'=>'admin/admin_view'
						);
		
		$this->load->view('admin/layout/wrapper',$data);
	}

	
	//--------------------------------------------------------------------------------
	//-------------------       DOSEN FUNCTIONS      -----------------------
	//--------------------------------------------------------------------------------
	public function dataDosen()
	{
		$this->kunci();
		$this->load->model('mod_dosen');

		$data = array('title'=>'Sistem Informasi Evaluasi Umpan Balik',
					  'isi'=>'admin/admin_dosen'
					  );
		$data['hasil'] = $this->mod_dosen->getAll();

 		//$this->load->view('', $data);
		$this->load->view('admin/layout/wrapper',$data);
	}

	public function alldosen()
	{
		$this->kunci();
		$this->load->model('mod_dosen');
		$results = $this->mod_dosen->alldosen();
        echo json_encode($results);
	}

	public function getDosen()
	{
		$this->kunci();
		$this->load->model('mod_dosen');
		//$id = $this->uri->segment(3);
		$id = $this->input->post('id');
		
		$execread=$this->mod_dosen->getDosen($id);

 		//$this->load->view('', $data);
		//$this->load->view('admin/layout/wrapper',$data);
		//print($execread); //buat cek
		$prejson=array();
		foreach($execread as $item){
			$prejson[]=array('id_dosen'=>$item['id_dosen'],
							 'nama_dosen'=>$item['nama_dosen']
							 );
		}
		print json_encode($prejson);

	}

	public function getDsnOnKls()
	{
		$this->kunci();
		$this->load->model('mod_dosen');
		//$id = $this->uri->segment(3);
		$id = $this->input->post('id');
		
		$execread=$this->mod_dosen->getDsnOnKls($id);

        $prejson=array();
		foreach($execread as $item){
			$prejson[]=array('id_dosen'=>$item['id_dosen'],
							 'nama_dosen'=>$item['nama_dosen']
							 );
		}
		print json_encode($prejson);
		
	}


	public function addDosen()
	{
		$this->kunci();
		$this->load->model('mod_dosen');

		$data = array(
						'id_dosen' => $this->input->post('id'),
						'nama_dosen' => $this->input->post('nama')
						//'employee_gender' => $this->input->post('select'),
						//'employee_address' => $this->input->post('address'),
					 );

		$this->mod_dosen->insertDosen($data);
		//$this->dataDosen();

	}

	public function addDetdos()
	{
		$this->kunci();
		$this->load->model('mod_dosen');

		$data = array(
						'id_dosen' => $this->input->post('iddos'),
						'id_kls' => $this->input->post('idkls'),
						'matakuliah' => $this->input->post('mtk')
						
					 );

		$this->mod_dosen->addDetdos($data);
	}

	public function updateDosen()
	{
		$this->kunci();
		$this->load->model('mod_dosen');
		$id = $this->input->post('ids');
		$data = array(
						'id_dosen' => $this->input->post('iddos'),
						'nama_dosen' => $this->input->post('nama')
						
					 );

		$this->mod_dosen->updateDos($id,$data);
		//$this->mod_dosen->updDetdos($id,$data);
	}

	public function delDosen()
	{
		$this->load->model('mod_dosen');

		//$id = $this->uri->segment(3);
		$id = $this->input->post('id');

		$this->mod_dosen->delDosen($id);

		redirect('admin/dataDosen#dataDosen');


	}

	public function delmtkDosen()
	{
		$this->load->model('mod_dosen');

		//$id = $this->uri->segment(3);
		$ids = $this->input->post('ids');
		$kls = $this->input->post('kls');
		$mtk = $this->input->post('mtk');


		$this->mod_dosen->delmtkDosen($ids,$kls,$mtk);

		//redirect('admin/dataDosen#dataDosen');
	}

	public function detailDosen()
	{
		$this->load->model('mod_dosen');
		//$id = $this->uri->segment(3);
		$id = $this->input->post('id');
		
		$execread=$this->mod_dosen->detDosen($id);

 		//$this->load->view('', $data);
		//$this->load->view('admin/layout/wrapper',$data);
		//print($execread); //buat cek
		$prejson=array();
		foreach($execread as $item){
			$prejson[]=array('id_dosen'=>$item['id_dosen'],
							 'nama_dosen'=>$item['nama_dosen'],
							 'id_kls'=>$item['id_kls'],
							 'matakuliah'=>$item['matakuliah']
							 );
		}
		print json_encode($prejson);

	}

	public function dosenDt()
	{
		/*	
		//Important to NOT load the model and let the library load it instead.  
        $this -> load-> library('Datatable', array('model' => 'modklsdt', 'rowIdCol' => 'a.id_dosen'));

        $json = $this -> datatable-> datatableJson(array(
									                'a_date_col' => 'date',
									                'a_boolean_col' => 'boolean',
									                'a_percent_col' => 'percent',
									                'a_currency_col' => 'currency'
									          ));
        
        $this -> output -> set_header("Pragma: no-cache");
        $this -> output -> set_header("Cache-Control: no-store, no-cache");
        $this -> output -> set_content_type('application/json') -> set_output(json_encode($json));
		
		//echo $json;
        */
		$this->datatables->select('id_dosen, nama_dosen');
		$this->datatables->from('dosen');
				    
		$dtb = $this->datatables->generate();
		echo $dtb;
		//$this->load->view('ajax', $data);
		
	}
	//----------------------------------------------------------------------------------
	//---------------------      END OF DOSEN'S FUNCTIONS      -------------------------
	//----------------------------------------------------------------------------------


	//----------------------------------------------------------------------------------
	//----------------------      MAHASISWA'S FUNCTIONS      ---------------------------
	//----------------------------------------------------------------------------------

	public function dataMhs()
	{
		$this->kunci();

		$data = array('title'=>'Sistem Informasi Evaluasi Umpan Balik',
					  'isi'=>'admin/admin_mhs'
					  );
		//$data['hasil'] = $this->mod_dosen->getAll();

 		//$this->load->view('', $data);
		$this->load->view('admin/layout/wrapper',$data);
	}

	public function listmhs()
	{
		//$sql = "select * from kelas where kelas like '%".$this->input->post('c')."%'";
		//$execread=$this->db->query($sql)->result_array();
		
		$this->load->model('mod_mhs');

		//$c=$this->input->post('c');
		$c="";
		
		$execread=$this->mod_mhs->listmhs($c);
		//print($execread); //buat cek
		//persiapan json
		$prejson=array();
		foreach($execread as $item){
			$prejson[]=array('nim'=>$item['nim'],
							 'nama'=>$item['nama'],
							 'jekel'=>$item['jekel'],
							 'angkatan'=>$item['angkatan'],
							 'id_kls'=>$item['id_kls'],
							 'status_'=>$item['status_']

							 );
		}
		print json_encode($prejson);
	}

	public function addMhs()
	{
		$this->load->model('mod_mhs');

		$data = array(
						'nim' => $this->input->post('nim'),
						'nama' => $this->input->post('nama'),
						'jekel' => $this->input->post('jk'),
						'angkatan' => $this->input->post('angk'),
						'id_kls' => $this->input->post('kls'),
						'pwd' => do_hash($this->input->post('nim')),
						'status' => $this->input->post('st')
					 );

		$this->mod_mhs->insertMhs($data);

	}

	public function delMhs()
	{
		$this->load->model('mod_mhs');

		$id = $this->input->post('id');

		$this->mod_mhs->delMhs($id);

	}

	//----------------------------------------------------------------------------------
	//-------------------      END OF MAHASISWA'S FUNCTIONS      -----------------------
	//----------------------------------------------------------------------------------


	//----------------------------------------------------------------------------------
	//----------------------         KELAS' FUNCTIONS        ---------------------------
	//----------------------------------------------------------------------------------
	public function dataKls()
	{
		$this->kunci();

		$data = array('title'=>'Sistem Informasi Evaluasi Umpan Balik',
					  'isi'=>'admin/admin_kls'
					  );
		//$data['hasil'] = $this->mod_dosen->getAll();

 		//$this->load->view('', $data);
		$this->load->view('admin/layout/wrapper',$data);
	}

	public function kelasCari(){
		//$sql = "select * from kelas where kelas like '%".$this->input->post('c')."%'";
		//$execread=$this->db->query($sql)->result_array();
		
		$this->load->model('mod_kelas');
		$c=$this->input->post('c');
		
		$execread=$this->mod_kelas->getKls($c);
		//print($execread); //buat cek
		//persiapan json
		$prejson=array();
		foreach($execread as $item){
			$prejson[]=array('id_kls'=>$item['id_kls'],
										//'kelas'=>$item['kelas'],
										'kelas'=>$item['kelas']);
		}
		print json_encode($prejson);
	}


	public function getKls(){
		//$sql = "select * from kelas where kelas like '%".$this->input->post('c')."%'";
		//$execread=$this->db->query($sql)->result_array();
		
		$this->load->model('mod_kelas');
		$c="";
		
		$execread=$this->mod_kelas->getKls($c);
		//print($execread); //buat cek
		//persiapan json
		$prejson=array();
		foreach($execread as $item){
			$prejson[]=array('id_kls'=>$item['id_kls'],
							 'kelas'=>$item['kelas']
							);
		}
		print json_encode($prejson);
	}

	public function addKls()
	{
		$this->load->model('mod_kelas');

		$data = array(
						'id_kls' => $this->input->post('idkls'),
						'kelas' => $this->input->post('kls')
					 );

		$this->mod_kelas->insertKls($data);
		//return true;

	}

	public function updateKls()
	{
		$this->load->model('mod_kelas');
		$id = $this->input->post('id');
		$idk = $this->input->post('idk');
		$k = $this->input->post('k');

		$this->mod_kelas->updKls($id,$idk,$k);
	}

	public function delKls()
	{
		$this->load->model('mod_kelas');

		//$id = $this->uri->segment(3);
		$id = $this->input->post('id');

		$this->mod_kelas->delKls($id);

		//redirect('admin/dataDosen#dataDosen');


	}

	//----------------------------------------------------------------------------------
	//---------------------      END OF KELAS' FUNCTIONS      --------------------------
	//----------------------------------------------------------------------------------


	//----------------------------------------------------------------------------------
	//----------------------        SOAL'S FUNCTIONS         ---------------------------
	//----------------------------------------------------------------------------------
	public function dataSoal()
	{
		$this->kunci();

		$data = array('title'=>'Sistem Informasi Evaluasi Umpan Balik',
					  'isi'=>'admin/admin_soal'
					  );
		//$data['hasil'] = $this->mod_dosen->getAll();

 		//$this->load->view('', $data);
		$this->load->view('admin/layout/wrapper',$data);
	}

	public function loadSoal()
	{
		$this->load->model('mod_soal');
		$c=$this->input->post('c');
		
		$execread=$this->mod_soal->getSoal($c);
		//print($execread); //buat cek
		//persiapan json
		$prejson=array();

		foreach($execread as $item){
			$prejson[]=array(
							'id_soal'=>$item['id_soal'],
							'soal'=>$item['soal']
							);
		}
		print json_encode($prejson);

	}

	public function addSoal()
	{
		$this->load->model('mod_soal');

		$data = array(
						'id_soal' => $this->input->post('id'),
						'soal' => $this->input->post('soal')
					 );

		$this->mod_soal->insertSoal($data);
		//return true;

	}

	public function getSoal()
	{
		$this->load->model('mod_soal');
		$id = $this->input->post('id');
		
		$execread=$this->mod_soal->getaSoal($id);

		$prejson=array();
		foreach($execread as $item){
			$prejson[]=array('id_soal'=>$item['id_soal'],
							 'soal'=>$item['soal']
							 );
		}
		print json_encode($prejson);

	}

	public function delSoal()
	{
		$this->load->model('mod_soal');
		$id = $this->input->post('id');

		$this->mod_soal->delSoal($id);

	}

	public function updateSoal()
	{
		$this->load->model('mod_soal');
		$id = $this->input->post('id');
		$s = $this->input->post('s');

		$this->mod_soal->updSoal($id,$s);
	}

	//----------------------------------------------------------------------------------
	//---------------------      END OF SOAL'S FUNCTIONS      --------------------------
	//----------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------
	//---------------------         USER'S FUNCTIONS         ---------------------------
	//----------------------------------------------------------------------------------
	
	public function dataUser()
	{
		$this->kunci();

		$data = array('title'=>'Sistem Informasi Evaluasi Umpan Balik',
					  'isi'=>'admin/admin_user'
					  );
		//$data['hasil'] = $this->mod_dosen->getAll();

 		//$this->load->view('', $data);
		$this->load->view('admin/layout/wrapper',$data);
	}

	public function listUser(){
		//$sql = "select * from kelas where kelas like '%".$this->input->post('c')."%'";
		//$execread=$this->db->query($sql)->result_array();
		
		$this->load->model('mod_user');
		$c="";
		
		$execread=$this->mod_user->listUsr($c);
		//print($execread); //buat cek
		//persiapan json
		$prejson=array();
		foreach($execread as $item){
			$prejson[]=array('id_user'=>$item['id_user'],
							 'username'=>$item['username'],
							 //'pwd'=>$item['pwd'],
							 'nama'=>$item['nama'],
							 'username'=>$item['username'],
							 'posisi'=>$item['posisi']
							);
		}
		print json_encode($prejson);
	}

	public function addUsr()
	{
		$this->load->model('mod_user');

		$data = array(
						'id_user' => $this->input->post('idusr'),
						'username' => $this->input->post('usr'),
						'pwd' => do_hash($this->input->post('pwd')),
						'nama' => $this->input->post('nm'),
						'posisi' => $this->input->post('pos')
					 );

		$this->mod_user->insertUsr($data);
		//return true;

	}

	public function updateUsr()
	{
		$this->load->model('mod_user');
		//$id = $this->input->post('id');
		//$idk = $this->input->post('idk');
		//$k = $this->input->post('k');
		
		$pw = $this->input->post('pwd');
		if ($pw == "")
		{
			$data = array(
						'id_user' => $this->input->post('idusr'),
						'username' => $this->input->post('usr'),
						'pwd' => '',
						'nama' => $this->input->post('nm'),
						'posisi' => $this->input->post('pos')
					 );

		} else {
			$data = array(
						'id_user' => $this->input->post('idusr'),
						'username' => $this->input->post('usr'),
						'pwd' => do_hash($pw),
						'nama' => $this->input->post('nm'),
						'posisi' => $this->input->post('pos')
					 );

		}
		

		$this->mod_user->updUsr($data);
	}

	public function delUsr()
	{
		$this->load->model('mod_user');

		//$id = $this->uri->segment(3);
		$id = $this->input->post('id');

		$this->mod_user->delUsr($id);

		//redirect('admin/dataDosen#dataDosen');


	}



	//----------------------------------------------------------------------------------
	//-------------------       END OF USER'S FUNCTIONS       --------------------------
	//----------------------------------------------------------------------------------


	//----------------------------------------------------------------------------------
	//----------------------         EUB'S FUNCTIONS         ---------------------------
	//----------------------------------------------------------------------------------
	
	public function dataEub()
	{
		$this->kunci();

		$data = array('title'=>'Sistem Informasi Evaluasi Umpan Balik',
					  'isi'=>'admin/admin_eub'
					  );
		//$data['hasil'] = $this->mod_dosen->getAll();

 		//$this->load->view('', $data);
		$this->load->view('admin/layout/wrapper',$data);
	}

	public function eubAllDosen()
	{

		$this->kunci();

		$this->load->model('mod_eub');
		//$id = $this->input->post('id');
		
		$execread=$this->mod_eub->eubAllDosen();

		$prejson=array();
		foreach($execread as $item){
			$prejson[]=array(
							 'id_eub_dosen'=>$item['id_eub_dosen'],
							 'id_dosen'=>$item['id_dosen'],
							 'nama_dosen'=>$item['nama_dosen'],
							 'nilai'=>$item['nilai'],
							 'ket'=>$item['ket']
							);
		}
		echo json_encode($prejson);


	}

	public function eubDsnKls()
	{
		$this->kunci();

		$this->load->model('mod_eub');
		$k = $this->input->post('k');
		
		$execread=$this->mod_eub->eubDsnKls($k);

		$prejson=array();
		foreach($execread as $item){
			$prejson[]=array(
							 'id_eub_dosen'=>$item['id_eub_dosen'],
							 'id_dosen'=>$item['id_dosen'],
							 'nama_dosen'=>$item['nama_dosen'],
							 'nilai'=>$item['nilai'],
							 'ket'=>$item['ket']
							);
		}
		echo json_encode($prejson);

	}

	public function rekapDsn()
	{

		$this->kunci();

		$this->load->model('mod_eub');
		$kls = $this->input->post('k');
		$dsn = $this->input->post('d');


		$execread=$this->mod_eub->getRekapJwbDsn($dsn,$kls);

		$prejson=array();
		foreach($execread as $item){
			$prejson[]=array(
							 'id_eub_dosen'=>$item['id_eub_dosen'],
							 's1'=>$item['s1'],
							 's2'=>$item['s2'],
							 's3'=>$item['s3'],
							 's4'=>$item['s4'],
							 's5'=>$item['s5'],
							 's6'=>$item['s6'],
							 's7'=>$item['s7'],
							 's8'=>$item['s8'],
							 's9'=>$item['s9'],
							 's10'=>$item['s10'],
							 's11'=>$item['s11'],
							 's12'=>$item['s12'],
							 's13'=>$item['s13'],
							 's14'=>$item['s14'],
							 's15'=>$item['s15'],
							 's16'=>$item['s16'],
							 'totalp'=>$item['totalp']
							);
		}
		echo json_encode($prejson);

				/*for(i=1;i<17;i++){
									's[i]'=>$item['s[i]'],
								}*/
	}


	//----------------------------------------------------------------------------------
	//--------------------       END OF EUB'S FUNCTIONS       --------------------------
	//----------------------------------------------------------------------------------
	



	public function rede()
	{

		redirect('admin/dataDosen');
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */