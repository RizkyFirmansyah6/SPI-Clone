<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_desa extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilDesa(){
		/*
		select 
			d.kode, d.keterangan
		from bukaan_s b 
			left join desa d on b.desa = d.kode
		group by d.kode, d.keterangan order by d.kode;
		*/
		$this->db->select("d.KODE, d.KETERANGAN");
		$this->db->from("BUKAAN_S b");
		$this->db->join("DESA d","b.DESA = d.KODE","left");
			$this->db->where('b.TGL_SPK is NULL');
			$this->db->where('b.NO_SPK', '');
		$this->db->group_by("d.KODE, d.KETERANGAN");
		$this->db->order_by("d.KODE");
		
		return $this->db->get();
    }
	function ambilDesaAll(){
		return $this->db->query("
				
			select nmdesa + '-' + desa + ' (' + convert(varchar(10),jml) + ')' DESA, xx.desa KODE
			from (
				SELECT t.desa, 
					max(d.KETERANGAN) nmdesa,
					max(d.KETERANGAN) + ' - ' + t.desa  des, 
					count(t.nomor) jml
				FROM tutupan t
					LEFT JOIN DESA d ON t.desa=d.kode
					LEFT JOIN jadwal_desa_ts j ON d.kode=j.kode_desa
				GROUP BY t.desa
			) xx
		");
    }
	function ambilDesaAllByJdw($idJdw){
		$this->db->select("d.KODE, d.KETERANGAN + ' - ' +d.KODE
							 + 
							(CASE 
							  WHEN j.[GROUP] is not null
								 THEN ' (' + convert(varchar(500), j.[GROUP]) + ')'
							  ELSE '' 
							END) DESA ");
		$this->db->from("DESA d");
		$this->db->join("jadwal_desa_ts j","d.kode=j.kode_desa","left");
		$this->db->where("j.[group]",$idJdw);
		$this->db->order_by("j.ID,d.keterangan");
		
		return $this->db->get();
    }
	function ambilDesaRealisasiBS(){
		$this->db->select("d.KODE, d.KETERANGAN");
		$this->db->from("BUKAAN_S b");
		$this->db->join("DESA d","b.DESA = d.KODE","left");
			$this->db->where('b.BUKA','0');
			$this->db->where('b.NO_SPK !=','');
		$this->db->order_by("d.KODE");
		
		return $this->db->get();
    }
	function ambilJadwal(){
		$this->db->select("distinct [group] ");
		$this->db->from("jadwal_desa_ts ");
		
		return $this->db->get();
    }
	
}
?>