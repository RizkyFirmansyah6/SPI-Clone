<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_rekapPetugasTS extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilDaftarOrderBS_old(){
		$this->db->select("b.NOMOR, CONVERT(VARCHAR(24),b.TGL,103) as TGL,	b.NOSAL, d.KETERANGAN as DESA, p.NAMA, p.ALAMAT");
		$this->db->from("TUTUPAN b");
		$this->db->join("DESA d","d.KODE = b.DESA","left");
		$this->db->join("PELANGGAN p","p.NOSAL = b.NOSAL","left");
			$this->db->where('b.TGL_SPK is NULL');
			$this->db->where('b.NO_SPK', '');
			$this->db->where('b.tgl_bayar is null');
			$this->db->where('b.PERIODE', date('Ym'));
		$this->db->limit(1,1);
		return $this->db->get();
    }
	function ambilDaftarOrderTS($page,$rows,$jenis=null,$petugas=null,$tgl=null,$field=null,$field2=null){
        $offset = ($page-1)*$rows;
        $this->limit = $rows;
        $this->offset = $offset;
		
		$tgl = substr($tgl,6,4).'-'.substr($tgl,3,2).'-'.substr($tgl,0,2); //01-10-2016
		
		$this->db->select("b.NOMOR, CONVERT(VARCHAR(24),b.TGL,103) as TGL,	b.NOSAL, d.KETERANGAN as DESA, p.NAMA, p.ALAMAT, p.NO_BUKU,CONVERT(VARCHAR(24),b.TGL_SPK,103) TGL_SPK,b.NO_SPK,b.TUTUP,
		pt.KODE KDPETUGAS, pt.KETERANGAN NMPETUGAS ,CONVERT(VARCHAR(24),b.TGL_BAYAR,103) as TGL_BAYAR, CONVERT(VARCHAR(24),b.TGL_TEMPO,103) as TGL_TEMPO, CONVERT(VARCHAR(24),b.TGL_REALISASI,103) as TGL_REALISASI,
		(CASE b.TUTUP WHEN 1 THEN 'BERHASIL' ELSE '' END) REALISASI,b.KETERANGAN
		");
		$this->db->from("TUTUPAN b");
		$this->db->join("DESA d","d.KODE = b.DESA","left");
		$this->db->join("petugas pt","pt.kode = b.petugas","left");
		$this->db->join("jadwal_desa_ts j","d.kode=j.kode_desa","left");
		$this->db->join("PELANGGAN p","p.NOSAL = b.NOSAL","left");
		$this->db->where('b.PERIODE', date('Ym'));
		if($tgl!=null)$this->db->where('convert(varchar(10),b.tgl_spk,120)', $tgl);
		if($petugas!=null)$this->db->where('b.PETUGAS', $petugas);
		$this->db->where("b.TGL_SPK is not null"); 
		
		if ($field != null) {
			switch($field) {
				//case 'SPK' : $a="1=1"; break;
				case 'BERHASIL' : $this->db->where("b.TGL_REALISASI is not null and b.TUTUP=1"); break;
				case 'BAYAR' : $this->db->where("b.TGL_BAYAR is not null"); break;
				case 'TEMPO' : $this->db->where("(b.TGL_TEMPO is not null or b.TGL_TEMPO < convert(varchar(10),getdate(),120))"); break;
				case 'SISA' : $this->db->where("b.TGL_REALISASI is null and b.TGL_BAYAR is null "); break;
				default  : $a="1=1"; break;
			}
		}
		if ($field2 != null) {
			switch($field2) {
				//case 'SPK' : $a="1=1"; break;
				case 'BERHASIL' : $this->db->where("b.TGL_REALISASI is not null and b.TUTUP=1"); break;
				case 'BAYAR' : $this->db->where("b.TGL_BAYAR is not null"); break;
				case 'TEMPO' : $this->db->where("(b.TGL_TEMPO is not null or b.TGL_TEMPO < convert(varchar(10),getdate(),120))"); break;
				case 'SISA' : $this->db->where("b.TGL_REALISASI is null and b.TGL_BAYAR is null "); break;
				default  : $a="1=1"; break;
			}
		} 
	
        if($jenis=='total'){
			$hasil=$this->db->get ('')->num_rows();
        }else{
			$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
        }
        return $hasil;

    }
	
	function getRekapPerPtgsTS($tglJdw=null){
		$wTglSPK	= $tglJdw == null ? "1=1" : "convert(varchar(10),t.tgl_spk,120)='".$tglJdw."' ";
		$query = $this->db->query("
				SELECT
					t.petugas KDPETUGAS, 
					max(p.KETERANGAN) NMPETUGAS,
					count(t.NOMOR) SPK,
					sum(CASE WHEN t.TUTUP = 1 AND t.TGL_REALISASI IS NOT NULL  THEN 1 ELSE 0 END) BERHASIL,
					sum(CASE WHEN t.TUTUP = 0 AND t.TGL_REALISASI IS NOT NULL  THEN 1 ELSE 0 END) GAGAL,
					sum(CASE WHEN t.TGL_BAYAR is not null AND TGL_REALISASI IS NULL THEN 1 ELSE 0 END) BAYAR,
					sum(CASE WHEN t.TGL_TEMPO is not null AND convert(varchar(10),t.TGL_TEMPO,112 ) < convert(varchar(10),getdate(),112 ) THEN 1 ELSE 0 END) TEMPO,
					sum(CASE WHEN t.TGL_REALISASI IS NULL and t.TGL_BAYAR is null and (t.TGL_TEMPO is null or convert(varchar(10),t.TGL_TEMPO,112 ) >= convert(varchar(10),getdate(),112 ) ) THEN 1 ELSE 0 END) SISA
				FROM tutupan t
					LEFT JOIN petugas p ON t.petugas=p.kode
				where 
				t.petugas != '' and
				t.tgl_spk is not null and
				".$wTglSPK." and
				t.PERIODE='".date('Ym')."' 
				GROUP BY t.petugas
				ORDER BY t.petugas
		");
		
		return $query;
    }
	
	function getRekapPerBukuOrderTS($petugas,$field=null,$tglJadwal=null){
		//echo $field;
		$wTglSPK	= $tglJadwal == null ? "1=1" : "convert(varchar(10),t.tgl_spk,120)='".$tglJadwal."' ";
		$fieldWhere	= "1=1";
		if ($field != null) {
			switch($field) {
				case 'SPK' : $fieldWhere = "1=1"; break;
				case 'BERHASIL' : $fieldWhere = "t.TGL_REALISASI is not null and t.TUTUP=1"; break;
				case 'GAGAL' : $fieldWhere = "t.TGL_REALISASI is not null and t.TUTUP=0"; break;
				case 'BAYAR' : $fieldWhere = "t.TGL_BAYAR is not null and t.TGL_REALISASI is null"; break;
				case 'TEMPO' : $fieldWhere = "(t.TGL_TEMPO is not null or convert(varchar(10),t.TGL_TEMPO,112 ) < convert(varchar(10),getdate(),112 ))"; break;
				case 'SISA' : $fieldWhere = "t.TGL_REALISASI IS NULL and t.TGL_BAYAR is null and (t.TGL_TEMPO is null or convert(varchar(10),t.TGL_TEMPO,112 ) >= convert(varchar(10),getdate(),112 ) )"; break;
			}
		} 
		
		$query = $this->db->query("
				SELECT
					convert(varchar(10),t.TGL_SPK,105) TGLSPK, 
					max(t.petugas) KDPETUGAS, 
					max(p.KETERANGAN) NMPETUGAS,
					count(t.NOMOR) SPK,
					sum(CASE WHEN t.TUTUP = 1 AND t.TGL_REALISASI IS NOT NULL THEN 1 ELSE 0 END) BERHASIL,
					sum(CASE WHEN t.TUTUP = 0 AND t.TGL_REALISASI IS NOT NULL THEN 1 ELSE 0 END) GAGAL,
					sum(CASE WHEN t.TGL_BAYAR is not null THEN 1 ELSE 0 END) BAYAR,
					sum(CASE WHEN t.TGL_TEMPO is not null AND TGL_TEMPO < convert(varchar(10),getdate(),120) THEN 1 ELSE 0 END) TEMPO,
					sum(CASE WHEN t.TGL_REALISASI IS NULL and t.TGL_BAYAR is null and (t.TGL_TEMPO is null or convert(varchar(10),t.TGL_TEMPO,112 ) >= convert(varchar(10),getdate(),112 ) ) THEN 1 ELSE 0 END) SISA
				FROM tutupan t
					LEFT JOIN petugas p ON t.petugas=p.kode
				where 
				t.petugas = ".$petugas." and
				".$fieldWhere." and
				t.tgl_spk is not null and
				".$wTglSPK." and
				t.PERIODE='".date('Ym')."' 
				GROUP BY t.TGL_SPK
				ORDER BY t.TGL_SPK
		");
		
		//return $query->result_array();
		return $query;
    }
}
?>