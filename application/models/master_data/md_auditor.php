<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_auditor extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilAuditor(){
		$this->db->select("a.No_PKPT,a.NIP,CONVERT(varchar,k.Nama_Karyawan,255) Nama");
		$this->db->from("Auditor a");
		$this->db->join('Karyawan k', 'a.NIP = k.NIP');
		$this->db->order_by("a.No_PKPT",'asc');
		return $this->db->get();
    }
    function ambilAuditorBy($pkpt){
		$this->db->select("a.NIP,CONVERT(varchar,k.Nama_Karyawan,255) Nama,k.Index_Karyawan");
		$this->db->from("Auditor a");
		$this->db->join('Karyawan k', 'a.NIP = k.NIP');
		$this->db->where('No_PKPT', $pkpt);
		return $this->db->get();
    }
    function ambilKaryawan(){
		$this->db->select("k.NIP,CONVERT(varchar,k.Nama_Karyawan,255) Nama");
		$this->db->from("Karyawan k");
		return $this->db->get();
    }
    function tambahAuditor($nopkpt, $nip){
		$data = array(
        	'No_PKPT' => $nopkpt,
        	'NIP' => $nip
		);
		$this->db->insert('Auditor', $data);
    }
   
    function hapusAuditor($nopkpt){
		$this->db->where('No_PKPT', $nopkpt);
		$this->db->delete('Auditor');
    }
}
?>