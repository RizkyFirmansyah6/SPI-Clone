<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_petugas extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilPetugas($all='yes',$q=null){
	
		$this->db->select("p.*, p.KETERANGAN+' ('+p.KODE+')' AS KODENAMA");
		$this->db->from("PETUGAS p");
		if ($all != 'yes') $this->db->join("(select distinct petugas from tutupan) t","t.petugas=p.kode","inner");
		$this->db->where("p.MOD_APP","PERAWATAN");
		if($q!=null){
			$this->db->like('p.KODE', $q, 'both');
			$this->db->or_like('p.KETERANGAN', $q, 'both');
		}
		$this->db->order_by("p.KETERANGAN");
		
		return $this->db->get();
    }
}
?>