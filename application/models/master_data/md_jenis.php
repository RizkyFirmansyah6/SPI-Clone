<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_jenis extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilJenis(){
		$this->db->select("j.Kd_Jenis,j.Nama_Jenis");
		$this->db->from("Jenis j");
		$this->db->order_by("j.Kd_Jenis");
		return $this->db->get();
    }
    function tambahJenis($jenis){
		$data = array(
        	'Nama_Jenis' => $jenis
		);

		$this->db->insert('Jenis', $data);
    }
    function ubahJenis($kd,$nama){
		$data = array(
        	'Nama_Jenis' => $nama
		);

		$this->db->where('Kd_Jenis', $kd);
		$this->db->update('Jenis', $data);
    }
    function hapusJenis($kd){
		$this->db->where('Kd_Jenis', $kd);
		$this->db->delete('Jenis');
    }
}
?>