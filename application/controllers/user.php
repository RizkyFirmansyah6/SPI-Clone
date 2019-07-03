<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('master_data/md_user');
    }
	public function index(){
		$this->listUser();
	}
	public function listUser(){
		$this->previlege->check_access(array('id_menu'=>'1','tipe'=>'view'));
		$data["tabelDaftarUser"] = "";
		$view = $this->load->view('user/user_general',$data,true);
		echo $view;
	}
	public function daftarDataPegawai($page=1){
		$query = $this->md_user->ambilDaftarUser(null);
		echo json_encode($query->result());
	}
	public function comboDataPegawai(){
		$q = $this->input->post('q');
		$query = $this->md_user->ambilUserCombo($q);
		echo json_encode($query->result());
	}
	public function formEditUser(){
		$this->previlege->check_access(array('id_menu'=>'1','tipe'=>'update'));
		if($_POST){
			$query = $this->md_user->ambilDaftarUser($_POST['id']);
			$view = $this->load->view('user/user_formEdit',array("data"=>$query->result()),true);
			echo $view;
		}else{
			echo "no";
		}
	}
	
################################################
##CRUD##
################################################

	function updateUser(){
		$this->previlege->check_access(array('id_menu'=>'1','tipe'=>'update'));
		if($_POST){
			$data = array("status"=>$_POST['status'],"id_user_group"=>$_POST['id_user_group']);
			$query = $this->md_user->updateUser($_POST['id'],$data);
			if($query){
				echo 1;
			}else{
				echo $query;
			}
		}else{
			echo "No Direct Access";
		}
	}
	public function tambahUser(){
		$this->previlege->check_access(array('id_menu'=>'1','tipe'=>'insert'));
		if($_POST){
			$lihatNIP = $this->md_user->ambilUserByNIP($_POST['nip']);
			if($lihatNIP->num_rows() < 1){
				$query = $this->md_user->tambahUser($_POST);
				if($query){
					echo 1;
				}else{
					echo $query;
				}
			}else{
				echo "NIP Sudah terdaftar.";
			}
		}else{
			echo "No Direct Access";
		}
	}
	public function hapusUser(){
		$this->previlege->check_access(array('id_menu'=>'1','tipe'=>'delete'));
		if($_POST){
			$query = $this->md_user->hapusUser($_POST['id']);
			if($query){
				echo 1;
			}else{
				echo $query;
			}
		}else{
			echo "No Direct Access";
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */