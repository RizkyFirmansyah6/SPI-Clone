<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_orderTS extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilDaftarOrderTS($page,$rows,$jenis=null,$desa=null,$buku=null,$petugas=null,$jadwal=null,$field=null){
        $offset = ($page-1)*$rows;
        $this->limit = $rows;
        $this->offset = $offset;
		
		$this->db->select("b.NOMOR, CONVERT(VARCHAR(24),b.TGL,103) as TGL,	b.NOSAL, d.KETERANGAN as DESA, p.NAMA, p.ALAMAT, p.NO_BUKU,CONVERT(VARCHAR(24),b.TGL_SPK,103) TGL_SPK,b.NO_SPK,b.TUTUP,
		pt.KODE KDPETUGAS, pt.KETERANGAN NMPETUGAS ,CONVERT(VARCHAR(24),b.TGL_BAYAR,103) as TGL_BAYAR, CONVERT(VARCHAR(24),b.TGL_TEMPO,103) as TGL_TEMPO, CONVERT(VARCHAR(24),b.TGL_REALISASI,103) as TGL_REALISASI,
		(CASE b.TUTUP WHEN 1 THEN 'BERHASIL' ELSE '' END) REALISASI,b.KETERANGAN
		");
		$this->db->from("TUTUPAN b");
		$this->db->join("DESA d","d.KODE = b.DESA","left");
		$this->db->join("petugas pt","pt.kode = b.petugas","left");
		$this->db->join("jadwal_desa_ts j","d.kode=j.kode_desa","left");
		$this->db->join("PELANGGAN p","p.NOSAL = b.NOSAL","left");
		//$this->db->join("(select nosal,SUM(H_AIR + ANGSURAN) TAG1 from viewTRupiah group by nosal) v","v.NOSAL = b.NOSAL","left");
		//$this->db->join("(select nosal,SUM(N_SEWA + BIAYA_L + DENDA - POTONGAN) TAG2, SUM(N_RETRIBUSI) RET from tagihan group by nosal) tg","tg.NOSAL = b.NOSAL","left");
			//$this->db->where('b.TGL_SPK is NULL');
			//$this->db->where('b.NO_SPK', '');
			$this->db->where('b.tgl_realisasi is null');
			$this->db->where('b.PERIODE', date('Ym'));
			if($jadwal!=null)$this->db->where('j.[group]', $jadwal);
			if($desa!=null)$this->db->where('d.KODE', $desa);
			if($buku!=null)$this->db->where('b.NO_BUKU', $buku);
			if($petugas!=null)$this->db->where('b.PETUGAS', $petugas);
			
			if ($field != null) {
				switch($field) {
					case 'SPK' : $this->db->where("b.TGL_SPK is not null and b.TGL_BAYAR is null and b.TGL_TEMPO is null"); break;
					case 'BAYAR' : $this->db->where("b.TGL_BAYAR is not null"); break;
					case 'TEMPO' : $this->db->where("(b.TGL_TEMPO is not null or b.TGL_TEMPO < convert(varchar(10),getdate(),120))"); break;
					case 'SISA' : $this->db->where("b.TGL_SPK is null and b.TGL_BAYAR is null and (b.TGL_TEMPO is null or b.TGL_TEMPO >= convert(varchar(10),getdate(),120) )"); break;
				}
			} 
		
        if($jenis=='total'){
			$hasil=$this->db->get ('')->num_rows();
        }else{
			$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
        }
        return $hasil;

    }
	
	function getRekapPerDesaOrderTS(){
		$query = $this->db->query("
				SELECT t.desa KODE, 
					max(d.KETERANGAN) DESA, 
					count(t.nomor) ORDERS,
					sum(CASE WHEN t.TGL_SPK is not null and TGL_BAYAR is null and TGL_TEMPO is null THEN 1 ELSE 0 END) SPK,
					sum(CASE WHEN t.TGL_BAYAR is not null THEN 1 ELSE 0 END) BAYAR,
					sum(CASE WHEN t.TGL_TEMPO is not null or TGL_TEMPO < convert(varchar(10),getdate(),120) THEN 1 ELSE 0 END) TEMPO,
					sum(CASE WHEN t.TGL_SPK is null and TGL_BAYAR is null THEN 1 ELSE 0 END) SISA
				FROM tutupan t
					LEFT JOIN DESA d ON t.desa=d.kode
					LEFT JOIN jadwal_desa_ts j ON d.kode=j.kode_desa
				where t.desa != '' and
				t.PERIODE='".date('Ym')."' 
				GROUP BY t.desa
				ORDER BY t.desa
		");
		//and (TGL_TEMPO is null or TGL_TEMPO >= convert(varchar(10),getdate(),120) ) 
		
		return $query;
    }
	
	function getRekapPerBukuOrderTS($desa){
		$query = $this->db->query("
				SELECT t.NO_BUKU, 
					max(t.DESA) DESA,
					max(t.PETUGAS) PETUGAS,
					'0' JMLSPK,
					count(t.nomor) ORDERS,
					sum(CASE WHEN t.TGL_SPK is not null and TGL_BAYAR is null and TGL_TEMPO is null THEN 1 ELSE 0 END) SPK,
					sum(CASE WHEN t.TGL_BAYAR is not null THEN 1 ELSE 0 END) BAYAR,
					sum(CASE WHEN t.TGL_TEMPO is not null or TGL_TEMPO < convert(varchar(10),getdate(),120) THEN 1 ELSE 0 END) TEMPO,
					sum(CASE WHEN t.TGL_SPK is null and TGL_BAYAR is null THEN 1 ELSE 0 END) SISA,
					t.NO_BUKU productid
				FROM tutupan t
				where 
				t.tgl_realisasi is null and
				t.desa = '".$desa."' and
				t.PERIODE='".date('Ym')."' 
				GROUP BY t.PETUGAS,t.NO_BUKU
				ORDER BY t.NO_BUKU,t.PETUGAS
		");
		//and (TGL_TEMPO is null or TGL_TEMPO >= convert(varchar(10),getdate(),120) ) 
		//return $query->result_array();
		return $query;
    }
}
?>