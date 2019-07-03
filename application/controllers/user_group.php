<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_group extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('master_data/md_group');
    }
	public function index(){
		$this->listGroup();
	}
	public function listGroup(){
		$this->previlege->check_access(array('id_menu'=>'2','tipe'=>'view'));
		$view = $this->load->view('group/group_general',null,true);
		echo $view;
	}
	public function daftarDataGroup($page=1){
		$query = $this->md_group->ambilDaftarGroup(null);
		echo json_encode($query->result());
	}
	public function formTambahGroup(){
		$this->previlege->check_access(array('id_menu'=>'2','tipe'=>'insert'));
		$view = $this->load->view('group/group_formTambah',null,true);
		echo $view;
	}
	public function formEditGroup(){
		$this->previlege->check_access(array('id_menu'=>'2','tipe'=>'update'));
		if($_POST){
			$query = $this->md_group->ambilDaftarGroup($_POST['id']);
			$view = $this->load->view('group/group_formEdit',array("data"=>$query->result()),true);
			echo $view;
		}else{
			echo "no";
		}
	}
	
############################################
##CRUD##
############################################

	
	function tambahGroup(){
		$this->previlege->check_access(array('id_menu'=>'2','tipe'=>'insert'));
		if($_POST){
				$data = array("nama"=>$_POST['nama'],"akses"=>serialize($_POST['menu']));
				$query = $this->md_group->tambahGroup($data);
				if($query){
					echo 1;
				}else{
					echo $query;
				}
		}else{
			echo "No Direct Access";
		}
	}
	function updateGroup(){
		$this->previlege->check_access(array('id_menu'=>'2','tipe'=>'update'));
		if($_POST){
				$data = array("nama"=>$_POST['nama'],"akses"=>serialize($_POST['menu']));
				$query = $this->md_group->updateGroup($_POST['id'],$data);
				if($query){
					echo 1;
				}else{
					echo $query;
				}
		}else{
			echo "No Direct Access";
		}
	}
	public function hapusGroup(){
		$this->previlege->check_access(array('id_menu'=>'2','tipe'=>'delete'));
		if($_POST){
			$query = $this->md_group->hapusGroup($_POST['id']);
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