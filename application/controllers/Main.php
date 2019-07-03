<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	public function index(){
		if($_POST){
			$this->validasiLogin($_POST);
		}else{
			if($this->session->userdata('login') != ''){
				$this->load->view('main');
			}else{
				$this->load->view('login');
			}
		}
	}
	function validasiLogin(){
		 
	
		if($_POST){
			$ux = $this->input->post('lName');
			$px = $this->input->post('lPass');
			if(($ux != '') && ($px != '')){
				if($ux == 'admin' && $px == '1'){
				
					$uxX 		= 'admin';
					$namaL		= 'admin';
					$kodeJab	= '1.01.00.00.03';
					
					$array = array(
						"login" 		=> array('nip'=>$uxX),
						"nama_lengkap" 	=> $namaL,
						"kode_jabatan" 	=> $kodeJab
					);
					$this->session->set_userdata($array);
					echo 1;
				}
				
				
			}else{
				echo "<i class='fa fa-exclamation-triangle'></i>&nbsp;&nbsp;Kolom isian tidak boleh kosong";
			}
		}else{
			echo "Akses ditolak !!";
		}
	}
	function validasilogout(){
		$this->session->sess_destroy();
		header('Location: '.base_url());
	}
	/*public function genPs(){
		$this->load->library('encrypt');
		echo $this->encrypt->encode('admin');
	}*/
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */