<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_sasaran extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilSasaran($page,$rows,$type=null,$Nomor){
		$offset = ($page-1)*$rows;
        $this->limit = $rows;
        $this->offset = $offset;

		$this->db->select("s.Nomor,s.Urut_Sasaran,s.Isi_Sasaran");
		$this->db->from("Sasaran s");
		$this->db->join('Program_Tahunan pt', 'pt.Nomor = s.Nomor');
		$this->db->where('pt.Nomor', $Nomor);
		if($type=='total'){
			$hasil=$this->db->get('')->num_rows();
        }else{
			$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
        }
        return $hasil;
    }
}
?>