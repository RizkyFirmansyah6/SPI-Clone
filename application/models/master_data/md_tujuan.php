<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_tujuan extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilTujuan($page,$rows,$type=null,$Nomor){
		$offset = ($page-1)*$rows;
        $this->limit = $rows;
        $this->offset = $offset;

		$this->db->select("t.Nomor,t.Urut_Tujuan,t.Isi_Tujuan");
		$this->db->from("Tujuan t");
		$this->db->join('Program_Tahunan pt', 'pt.Nomor = t.Nomor');
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