<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_bagian extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilBagian(){
		$this->db->select("b.Kd_Bag,b.Nama_Bag");
		$this->db->from("Bagian b");
		$this->db->order_by("b.Kd_Bag");
		return $this->db->get();
    }
    function tambahBagian($bagian){
		$data = array(
        	'Nama_Bag' => $bagian
		);

		$this->db->insert('Bagian', $data);
    }
    function ubahBagian($kd,$nama){
		$data = array(
        	'Nama_Bag' => $nama
		);

		$this->db->where('Kd_Bag', $kd);
		$this->db->update('Bagian', $data);
    }
    function hapusBagian($kd){
		$this->db->where('Kd_Bag', $kd);
		$this->db->delete('Bagian');
    }
}
?>