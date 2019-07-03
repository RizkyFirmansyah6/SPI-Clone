<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_program extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilProgram(){
		$this->db->select("p.Kd_Program,p.Nama_Program");
		$this->db->from("Program p");
		$this->db->order_by("p.Kd_Program");
		return $this->db->get();
    }
}
?>