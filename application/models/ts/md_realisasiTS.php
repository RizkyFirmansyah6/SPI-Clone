<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
set_time_limit(0);
ini_set('memory_limit', '3000M');

class Md_realisasiTS extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function ambilDaftarRealisasiTS($page,$rows,$jenis=null,$status=null,$petugas=null,$nosal=null,$tglJdw=null){
        $offset = ($page-1)*$rows;
        $this->limit = $rows;
        $this->offset = $offset;
		
		$tglJdw = $tglJdw == '' ? null : substr($tglJdw,6,4).'-'.substr($tglJdw,3,2).'-'.substr($tglJdw,0,2); 
		// $tglJdw = $tglJdw == '' ? null : substr($tglJdw,6,4).'-'.substr($tglJdw,0,2).'-'.substr($tglJdw,3,2); //02/24/2016
		
		$this->db->select("b.NOMOR, b.NOSAL, d.KETERANGAN as DESA, p.NAMA, p.ALAMAT, p.NO_BUKU, b.NO_SPK, CONVERT(VARCHAR(24),b.TGL_SPK,103) as TGL_SPK, t.nomor NO_BPB, 
		CONVERT(VARCHAR(24),b.TGL_REALISASI,103) as TGL_REALISASI, b.JENIS_MTR, b.STAND, b.NO_SLAG, b.REALISASI, b.PETUGAS,
		b.PETUGAS as petugas_sort,pt.keterangan as NM_PETUGAS,
		CONVERT(VARCHAR(24),b.TGL,103) as TGL, CONVERT(VARCHAR(24),b.TGL_BAYAR,103) as TGL_BAYAR, CONVERT(VARCHAR(24),b.TGL_TEMPO,103) as TGL_TEMPO, 
		b.KETERANGAN, b.TUTUP,b.DIAMETER,b.NO_SEGEL");
		$this->db->from("TUTUPAN b");
		$this->db->join("TOTBPB t","t.no_reg=b.nomor","left");
		$this->db->join("petugas pt","pt.kode=b.petugas","left");
		$this->db->join("PELANGGAN p","p.NOSAL = b.NOSAL","left");
		$this->db->join("DESA d","d.KODE = p.DESA","left");
		$this->db->join("jadwal_desa_ts j","d.kode=j.kode_desa","left");
			//$this->db->where('b.TUTUP','0');
			if ($status == '1') { 
				$this->db->where('b.TGL_REALISASI IS NOT NULL');
			} else if ($status == '0') {
				$this->db->where('b.TGL_REALISASI IS NULL and b.TGL_BAYAR IS NULL');
			} else if ($status == '2') {
				$this->db->where('b.TGL_BAYAR IS NOT NULL');
			} else if ($status == '3') {
				$this->db->where('b.TGL_TEMPO IS NOT NULL');
				$this->db->where('b.TUTUP = 0'); 
			} else if ($status == '4') {
				$this->db->where('b.TGL_REALISASI IS NOT NULL');
				$this->db->where('b.TUTUP = 1'); 
			} else if ($status == '5') {
				$this->db->where('b.TGL_REALISASI IS NOT NULL');
				$this->db->where('b.TUTUP = 0'); 
			}
			$this->db->where('b.NO_SPK !=','');
			$this->db->where('b.TGL_SPK IS NOT NULL');
			$this->db->where('b.PERIODE', date('Ym'));
			if ($tglJdw!=null) $this->db->where('convert(varchar(10),b.TGL_SPK,120)',$tglJdw);
			// $this->db->where('b.TGL_REALISASI IS  NULL');
			if($petugas!=null)$this->db->where('b.petugas', $petugas);
			if($nosal!=null)$this->db->where('b.nosal', $nosal);
			
			
			$this->db->order_by('petugas_sort','ASC');
		
        if($jenis=='total'){
			$hasil=$this->db->get ('')->num_rows();
        }else{
			$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
        }
       
        return $hasil;

    }
	function ambilDaftarRealisasiTSCetak($page,$rows,$jenis=null,$desa=null,$petugas=null,$tglJdw=null,$nosal=null,$tempo=null){
        $offset = ($page-1)*$rows;
        $this->limit = $rows;
        $this->offset = $offset;
		
		$tglJdw = $tglJdw == '' ? null : substr($tglJdw,6,4).'-'.substr($tglJdw,3,2).'-'.substr($tglJdw,0,2); 
		
		$this->db->select("b.NOMOR, b.NOSAL, d.KETERANGAN as DESA, p.NAMA, p.ALAMAT, p.NO_BUKU, b.NO_SPK, CONVERT(VARCHAR(24),b.TGL_REALISASI,103) as TGL_REALISASI, 
							CONVERT(VARCHAR(24),b.TGL_TEMPO,103) as TGL_TEMPO, b.JENIS_MTR, b.STAND, b.NO_SLAG, b.REALISASI, b.PETUGAS, CONVERT(VARCHAR(24),b.TGL,103) as TGL, 
							b.KETERANGAN,b.TUTUP,b.DIAMETER, CONVERT(VARCHAR(24),b.TGL_SPK,103) as TGL_SPK");
		$this->db->from("TUTUPAN b");
		//$this->db->join("TOTBPB t","t.no_reg=b.nomor","left");
		$this->db->join("PELANGGAN p","p.NOSAL = b.NOSAL","left");
		$this->db->join("DESA d","d.KODE = p.DESA","left");
		$this->db->join("jadwal_desa_ts j","d.kode=j.kode_desa","left");
			$this->db->where('b.TUTUP','0');
			//$this->db->where('b.NO_SPK !=','');
			//$this->db->where('b.tgl_realisasi is null');
			$this->db->where('b.tgl_bayar is null');
			//$this->db->where('b.tgl_tempo is null');
			$this->db->where('b.TGL_SPK IS NOT NULL');
			$this->db->where('b.PERIODE', date('Ym'));
			//$this->db->where('b.TGL_REALISASI IS  NULL');
			if($desa!=null)$this->db->where('d.KODE', $desa);
			// if($jadwal!=null)$this->db->where('j.[group]', $jadwal);
			if($tglJdw!=null)$this->db->where('CONVERT(VARCHAR(10), b.tgl_spk, 120) = ', $tglJdw);
			if($nosal!=null)$this->db->where('b.nosal', $nosal);
			if($petugas!=null)$this->db->where('b.petugas', $petugas);
			if($tempo==1)$this->db->where('b.tgl_tempo is not null');
		
		$this->db->order_by("NO_SPK");
		
        if($jenis=='total'){
			$hasil=$this->db->get ('')->num_rows();
        }else{
			$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
        }
       
        return $hasil;

    }
	function ambilBarang($q){
		$sel = "TOP 10 *";
		if($q!=null){
			$sel = "*";
		}
		$this->db->select($sel);
		$this->db->from("vstok_akhir1");
		if($q!=null){
			$this->db->like('kode', $q, 'both');
			$this->db->or_like('nama_item', $q, 'both');
		}
		return $this->db->get();
    }
	function ambilPetugas($q){
		$this->db->select("p.*");
		$this->db->from("PETUGAS p");
		$this->db->where("p.MOD_APP","PERAWATAN");
		if($q!=null){
			$this->db->like('p.KODE', $q, 'both');
			$this->db->or_like('p.KETERANGAN', $q, 'both');
		}
		return $this->db->get();
    }
	function ambilVendor($q){
		$this->db->select("*");
		$this->db->from("VENDOR");
		if($q!=null){
			$this->db->like('KODE', $q, 'both');
			$this->db->or_like('KETERANGAN', $q, 'both');
		}
		return $this->db->get();
    }
	function ambilDiameter($q){
		$this->db->select("KODE AS DIAMETER");
		$this->db->from("SEWA");
		$this->db->where("KODE != '000'");
		if($q!=null){
			$this->db->like('KODE', $q, 'both');
		}
		$this->db->order_by('KODE');
		return $this->db->get();
    }
	function ambilJenisMTR($q){
		$this->db->select("KODE");
		$this->db->from("JENIS_METER");
		if($q!=null){
			$this->db->like('KODE', $q, 'both');
		}
		$this->db->group_by('KODE');
		$this->db->order_by('KODE');
		return $this->db->get();
    }
	function ambilNoSeg($q,$pet){
		$this->db->select("NOMOR,NO_URUT,KODE,QTY");
		$this->db->from("PERMINTAAN_BAHAN_DTL");
		$this->db->where('TGL_REALISASI IS NULL');
		$batas = date('Y-m-d', strtotime(date('Y-m')." -4 month"));
		$this->db->where("CONVERT(VARCHAR(10),TGL,120) > '".$batas."'");
		
		//$this->db->where('PETUGAS',$pet);
		if($q!=null){
			$this->db->like('NO_URUT', $q, 'both');
			$this->db->or_like('NOMOR', $q, 'both');
		}
		$this->db->order_by('NO_URUT');
		return $this->db->get();
    }
	function realisasiSPK($data,$where){
		$this->db->where($where);
		$proc = $this->db->update('tutupan', $data);
		if($proc){$status = true;}else{$status = false;}
		return $status;
	}
	
	function getDataPlgPrint($noSPK,$nosal){
		/*$this->db->select("p.nosal,p.nama,p.alamat,p.rt,p.rw,t.wilayah,t.desa+'-'+t.no_buku buku,t.no_spk,convert(varchar(15),t.tgl_spk,106) tgl_spk,
			g.golongan,g.periode,g.meter,g.periode,
			g.h_air,
			
			p.no_slag,pg.keterangan petugas, pg.SIM nohp");
		$this->db->from("viewtrupiah g");
		$this->db->join('tagihan tg','g.nosal=tg.nosal','left');
		$this->db->join('pelanggan p','g.nosal=p.nosal','left');
		$this->db->join('tutupan t','t.nosal=g.nosal','left');
		$this->db->join('petugas pg','t.petugas=pg.kode','left');
		$this->db->where('t.no_spk', $noSPK);
		$this->db->where('t.nosal', $nosal);
		
		$this->db->order_by('g.periode');
		return $this->db->get();
		*/
		
		$query	= $this->db->query("
			SELECT 
			t.no_spk,
			t.tgl_spk,
			t.petugas,
			p.wilayah,
			p.rt,
			p.rw,
			p.desa+p.no_buku buku,
			p.no_slag,
			convert(varchar(15),t.tgl_spk,106) tgl_spk, 
			convert(varchar(15),t.tgl_tempo,106) tgl_tempo, 
			z.periode, z.nosal, p.nama, p.alamat, p.golongan,z.METER,z.METER_LALU,z.PAKAI_KIRA,z.PAKAI, z.air h_air, z.sewa, z.biaya_l, z.sampah, z.denda, z.potongan, z.angsuran, z.materai,
			pg.keterangan petugas,
			pg.sim nohp
			FROM (
				SELECT A.PERIODE, A.NOSAL, A.NAMA, A.ALAMAT, A.GOLONGAN,
				  A.METER,A.METER_LALU,A.PAKAI_KIRA,
				 CASE WHEN A.PAKAI_KIRA<>0 THEN A.PAKAI_KIRA
				 ELSE A.METER-A.METER_LALU END AS PAKAI, B.H_AIR AS AIR, A.N_SEWA AS SEWA, A.BIAYA_L, A.N_RETRIBUSI AS SAMPAH, 
				 A.DENDA, A.POTONGAN, B.ANGSURAN, 
				 '' MATERAI
				 FROM  dbo.TAGIHAN AS A INNER JOIN
				 dbo.viewTRupiah AS B ON A.NOSAL = B.NOSAL AND A.PERIODE = B.PERIODE
				 WHERE A.NOSAL='$nosal'
			) AS z
			left join pelanggan p on p.nosal = z.nosal AND p.nosal='$nosal'
			left join tutupan t on t.nosal = z.nosal AND t.nosal='$nosal'
			left join petugas pg on t.petugas = pg.kode

			WHERE z.NOSAL='$nosal'
		");
		return $query;
	}
	
	function getRekapPerTgl(){
		$query = $this->db->query("
				SELECT 
					convert(varchar(10),t.TGL_SPK,105) TGL_SPK, 
					count(t.nomor) SPK,
					sum(CASE WHEN t.TGL_REALISASI is not null AND TUTUP=1 THEN 1 ELSE 0 END) BERHASIL,
					sum(CASE WHEN t.TGL_BAYAR is not null THEN 1 ELSE 0 END) BAYAR,
					sum(CASE WHEN t.TGL_REALISASI is null and TGL_BAYAR is null THEN 1 ELSE 0 END) SISA
				FROM tutupan t
				where t.TGL_SPK is not null and
				t.PERIODE='".date('Ym')."'
				GROUP BY t.TGL_SPK
				ORDER BY t.TGL_SPK
		");
		
		return $query;
    }
	
	function getPelanggaran($nosal){
		$query = $this->db->query("
				SELECT 
					SUM(BIAYA) BIAYA
				FROM pelanggaran
				WHERE NOSAL = '".$nosal."'
				AND TGL_BAYAR IS NULL
		");
		
		return $query;
    }
	
	function getSisaAngsuran($nosal){
		$query = $this->db->query("
			select count(nomor) jmlAngs from d_angsuran
			where nosal = '".$nosal."' and tgl_bayar is null
		");
		
		return $query;
    }
	
	function getDataNosalRealisasi($nosal) {
		$query = $this->db->query("
			select 
				t.nosal,
				t.nomor,
				convert(varchar(10),t.tgl_realisasi,103) tgl_realisasi,
				convert(varchar(10),t.tgl_spk,103) tgl_spk,
				t.tutup,
				t.realisasi,
				t.petugas,
				t.keterangan,
				t.stand,
				t.jenis_mtr,
				t.no_slag,
				t.diameter,
				s.path foto_realisasi,
				r.latitude,
				r.longitude,
				convert(varchar(10),t.tgl_tempo,103) tgl_tempo,
				convert(varchar(10),t.tgl_bayar,103) tgl_bayar,
				t.no_spk
			from tutupan t
			left join spk_file s on s.no_spk=t.no_spk
			left join realisasi_info r on r.no_spk=t.no_spk
			where t.nosal = '".$nosal."' 
		");
		
		return $query; 
	}
}
?>