<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_user extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilUserCombo($q){
		$this->db->select("nip, full_name");
		$this->db->from("EOFFICE.dbo.v_employee");
		$this->db->like('nip', $q, 'both');
		$this->db->or_like('full_name', $q, 'both');
		return $this->db->get();
    }
	function ambilDaftarUser($id){
		$this->db->select("u.id, u.status as status_id, u.id_user_group, g.nama as nama_group, v.nip, CASE WHEN u.status = '1' THEN 'AKTIF' ELSE 'NON-AKTIF' END as status, v.full_name");
		$this->db->from("ABT_USER u");
		$this->db->join('EOFFICE.dbo.v_employee v', 'v.nip COLLATE DATABASE_DEFAULT = u.nip COLLATE DATABASE_DEFAULT', 'left');
		$this->db->join('ABT_USER_GROUP g', 'g.id = u.id_user_group', 'left');
		$this->db->where_not_in('u.nip', array('admin'));
		if($id!=null)$this->db->where('u.id', $id);
		return $this->db->get();
    }
	function ambilUserByNIP($nip){
		$this->db->select("nip");
		$this->db->from("ABT_USER");
		$this->db->where('nip', $nip);
		return $this->db->get();
    }
	function tambahUser($postData){
		$data = null;
		if($this->db->insert('ABT_USER', $postData)){
			$data = true;
		}else{
			$data = "Error ketika menyimpan";
		}
		return $data;
	}
	function updateUser($id,$postData){
		$data = null;
		
		if($this->db->update('ABT_USER', $postData, "id = $id")){
			$data = true;
		}else{
			$data = "Error ketika menyimpan";
		}
		return $data;
	}
	function hapusUser($id){
		$data = null;
		if($this->db->delete('ABT_USER', array('id' => $id))){
			$data = true;
		}else{
			$data = "Error ketika menyimpan";
		}
		return $data;
	}
}
?>