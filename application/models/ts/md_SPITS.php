<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_SPITS extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilDaftarSPITS($page,$rows,$type=null,$tahun=null,$program=null,$jenis=null){
        $offset = ($page-1)*$rows;
        $this->limit = $rows;
        $this->offset = $offset;
        // $this->offset = $page;
		
		$this->db->select("pt.Nomor,pt.Obyek,pt.Ruang_Lingkup,pt.Kd_Jenis,j.Nama_Jenis Jenis,pt.Waktu,pt.Tgl_Mulai,pt.Tgl_LHA,pt.Kd_Program,p.Nama_Program Program,pt.No_Tugas,pt.Dasar,pt.Periode_Audit,pt.Tgl_Selesai,pt.Tgl_Audit_Meeting,pt.Tgl_Ke_Direksi,pt.Tgl_Dari_Direksi,pt.Disposisi_Direksi,pt.Kd_Tahun,t.Tahun
		");
		$this->db->from("Program_Tahunan pt");
		$this->db->join("Tahun t","pt.Kd_Tahun = t.Kd_Tahun");
		$this->db->join("Program p","pt.Kd_Program = p.Kd_Program");
		$this->db->join("Jenis j","pt.Kd_Jenis=j.Kd_Jenis");
			$this->db->where('pt.Status',1);
			if($tahun!=null)$this->db->where('pt.Kd_Tahun', $tahun);
			if($program!=null)$this->db->where('pt.Kd_Program', $program);
			if($jenis!=null)$this->db->where('pt.Kd_Jenis', $jenis);
		
        if($type=='total'){
			$hasil=$this->db->get('')->num_rows();
			// $hasil=$this->db->count_all_results();
        }else{
			$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
			// $hasil=$this->db->query('EXECUTE GetProgramTahunanAktiv '.$this->limit.','.$this->offset.',null,null,null')->result_array();
        }
        return $hasil;

    }
	
	// function getRekapPerDesaOrderTS(){
	// 	$query = $this->db->query("
	// 			SELECT t.desa KODE, 
	// 				max(d.KETERANGAN) DESA, 
	// 				count(t.nomor) ORDERS,
	// 				sum(CASE WHEN t.TGL_SPK is not null and TGL_BAYAR is null and TGL_TEMPO is null THEN 1 ELSE 0 END) SPK,
	// 				sum(CASE WHEN t.TGL_BAYAR is not null THEN 1 ELSE 0 END) BAYAR,
	// 				sum(CASE WHEN t.TGL_TEMPO is not null or TGL_TEMPO < convert(varchar(10),getdate(),120) THEN 1 ELSE 0 END) TEMPO,
	// 				sum(CASE WHEN t.TGL_SPK is null and TGL_BAYAR is null THEN 1 ELSE 0 END) SISA
	// 			FROM tutupan t
	// 				LEFT JOIN DESA d ON t.desa=d.kode
	// 				LEFT JOIN jadwal_desa_ts j ON d.kode=j.kode_desa
	// 			where t.desa != '' and
	// 			t.PERIODE='".date('Ym')."' 
	// 			GROUP BY t.desa
	// 			ORDER BY t.desa
	// 	");
	// 	//and (TGL_TEMPO is null or TGL_TEMPO >= convert(varchar(10),getdate(),120) ) 
		
	// 	return $query;
 //    }
	
	// function getRekapPerBukuOrderTS($desa){
	// 	$query = $this->db->query("
	// 			SELECT t.NO_BUKU, 
	// 				max(t.DESA) DESA,
	// 				max(t.PETUGAS) PETUGAS,
	// 				'0' JMLSPK,
	// 				count(t.nomor) ORDERS,
	// 				sum(CASE WHEN t.TGL_SPK is not null and TGL_BAYAR is null and TGL_TEMPO is null THEN 1 ELSE 0 END) SPK,
	// 				sum(CASE WHEN t.TGL_BAYAR is not null THEN 1 ELSE 0 END) BAYAR,
	// 				sum(CASE WHEN t.TGL_TEMPO is not null or TGL_TEMPO < convert(varchar(10),getdate(),120) THEN 1 ELSE 0 END) TEMPO,
	// 				sum(CASE WHEN t.TGL_SPK is null and TGL_BAYAR is null THEN 1 ELSE 0 END) SISA,
	// 				t.NO_BUKU productid
	// 			FROM tutupan t
	// 			where 
	// 			t.tgl_realisasi is null and
	// 			t.desa = '".$desa."' and
	// 			t.PERIODE='".date('Ym')."' 
	// 			GROUP BY t.PETUGAS,t.NO_BUKU
	// 			ORDER BY t.NO_BUKU,t.PETUGAS
	// 	");
	// 	//and (TGL_TEMPO is null or TGL_TEMPO >= convert(varchar(10),getdate(),120) ) 
	// 	//return $query->result_array();
	// 	return $query;
 //    }
}
?>