<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_buku extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilBukuBukaan_S(){
		// ambil dari bukaan_s dengan parameter sama seperti halaman order
		$this->db->select("p.NO_BUKU");
		$this->db->from("BUKAAN_S b");
		$this->db->join("PELANGGAN p","b.NOSAL = p.NOSAL","left");
			$this->db->where('b.TGL_SPK is NULL');
			$this->db->where('b.NO_SPK', '');
		$this->db->group_by("p.NO_BUKU");
		$this->db->order_by("p.NO_BUKU");
		return $this->db->get();
    }
	function ambilBukuAll(){
		$this->db->select("b.desa,b.kode NO_BUKU");
		$this->db->from("no_buku b");
		$this->db->order_by("b.NO_BUKU");
		return $this->db->get();
    }
	function ambilBukuRealisasiBS(){
		// ambil dari bukaan_s dengan parameter sama seperti halaman realisasi
		$this->db->select("p.NO_BUKU");
		$this->db->from("BUKAAN_S b");
		$this->db->join("PELANGGAN p","b.NOSAL = p.NOSAL","left");
			$this->db->where('b.BUKA','0');
			$this->db->where('b.NO_SPK !=','');
		$this->db->order_by("p.NO_BUKU");
		return $this->db->get();
    }
}
?>