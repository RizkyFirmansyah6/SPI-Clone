<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_tahun extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilTahun(){
		$this->db->select("t.Kd_Tahun,t.Tahun");
		$this->db->from("Tahun t");
		$this->db->order_by("t.Tahun","asc");
		return $this->db->get();
    }
    function tambahTahun($tahun){
		$data = array(
        	'Tahun' => $tahun
		);
		$this->db->insert('Tahun', $data);
    }
    function ubahTahun($kd,$tahun){
		$data = array(
        	'Tahun' => $tahun
		);
		$this->db->where('Kd_Tahun', $kd);
		$this->db->update('Tahun', $data);
    }
    function hapusTahun($kd){
		$this->db->where('Kd_Tahun', $kd);
		$this->db->delete('Tahun');
    }
}
?>