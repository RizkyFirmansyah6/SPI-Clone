<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_group extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilDaftarGroup($id=null){
		$this->db->select("*");
		$this->db->from("ABT_USER_GROUP");
		if($id!=null)$this->db->where('id', $id);
		return $this->db->get();
    }
	function tambahGroup($postData){
		$data = null;
		if($this->db->insert('ABT_USER_GROUP', $postData)){
			$data = true;
		}else{
			$data = "Error ketika menyimpan";
		}
		return $data;
	}
	function updateGroup($id,$postData){
		$data = null;
		
		if($this->db->update('ABT_USER_GROUP', $postData, "id = $id")){
			$data = true;
		}else{
			$data = "Error ketika menyimpan";
		}
		return $data;
	}
	function hapusGroup($id){
		$data = null;
		if($this->db->delete('ABT_USER_GROUP', array('id' => $id))){
			$data = true;
		}else{
			$data = "Error ketika menyimpan";
		}
		return $data;
	}
}
?>