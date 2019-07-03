<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_auditor_tahunan extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilAuditor($No_Tahunan){
		$this->db->select("apt.No_PKPT,CONVERT(varchar,k.Nama_Karyawan,255) Nama,j.N_Jab Jabatan,k.Index_Karyawan");
		$this->db->from("Auditor_Program_Tahunan apt");
		$this->db->join('Auditor a', 'apt.No_PKPT = a.No_PKPT');
		$this->db->join('Karyawan k', 'a.NIP = k.NIP');
		$this->db->join('Jab j', 'apt.Kd_Jab = j.Kd_Jab');
		$this->db->where('apt.Nomor', strval($No_Tahunan));
		$this->db->order_by("j.Kd_Jab",'asc');
		return $this->db->get();
    }
}
?>