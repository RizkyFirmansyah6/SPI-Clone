<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_laporanTS extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	function tessss($page,$rows,$jenis=null,$desa=null){
        $offset = ($page-1)*$rows;
        $this->limit = $rows;
        $this->offset = $offset;
		
		$this->db->select("b.NOMOR, b.NOSAL, d.KETERANGAN as DESA, p.NAMA, p.ALAMAT, p.NO_BUKU, b.NO_SPK, t.nomor NO_BPB, CONVERT(VARCHAR(24),b.TGL_REALISASI,103) as TGL_REALISASI, b.JENIS_MTR, b.STAND, b.NO_SLAG, b.REALISASI, b.PETUGAS, CONVERT(VARCHAR(24),b.TGL,103) as TGL, b.KETERANGAN	");
		$this->db->from("TUTUPAN b");
		$this->db->join("DESA d","d.KODE = b.DESA","left");
		$this->db->join("TOTBPB t","t.no_reg=b.nomor","left");
		$this->db->join("PELANGGAN p","p.NOSAL = b.NOSAL","left");
			$this->db->where('b.TUTUP','0');
			$this->db->where('b.NO_SPK !=','');
			if($desa!=null)$this->db->where('d.KODE', $desa);
		
        if($jenis=='total'){
			$hasil=$this->db->get ('')->num_rows();
        }else{
			$hasil=$this->db->get ('',$this->limit, $this->offset)->result_array();
        }
       
        return $hasil;

    }
	
	function getRekapPerPetugas($namaTabel,$filterPeriode) {
		// $q = $this->db->query("select	
						// x.petugas, 
						// x.keterangan, 
						// ISNULL(x.spk, 0 ) as spk, 
						// ISNULL(x.buka, 0 ) as buka, 						
						// ISNULL(x.bayar, 0 ) as bayar, 
						// ISNULL(x.gagal, 0 ) as gagal,
						// ISNULL(x.tempo, 0 ) as tempo,
						// (ISNULL(x.spk, 0 ) -  ISNULL(x.buka, 0 ) - ISNULL(x.bayar, 0 ) - ISNULL(x.gagal, 0 ) - ISNULL(x.tempo, 0 )) as sisa
					// from(
						// select 
							// b.petugas, 
							// p.keterangan, 
							// (select count(*) from $namaTabel where petugas = b.petugas and convert(Varchar(6),tgl,112)='$filterPeriode' and tgl_spk is not null group by b.petugas) as spk,
							// (select count(*) from $namaTabel where petugas = b.petugas and convert(Varchar(6),tgl,112)='$filterPeriode' and tgl_bayar is not null and  tgl_Spk is not null group by b.petugas) as bayar,
							// (select count(*) from $namaTabel where petugas = b.petugas and convert(Varchar(6),tgl,112)='$filterPeriode' and tgl_tempo is not null and  tgl_Spk is not null group by b.petugas) as tempo,
							// (select count(*) from $namaTabel where petugas = b.petugas and convert(Varchar(6),tgl,112)='$filterPeriode' and tgl_spk is not null and tutup = '1' and tgl_realisasi is not null group by b.petugas) as buka,
							// (select count(*) from $namaTabel where petugas = b.petugas and convert(Varchar(6),tgl,112)='$filterPeriode' and tgl_spk is not null and tutup = '0' and tgl_realisasi is not null and tgl_bayar is null and tgl_tempo is null group by b.petugas) as gagal
						// from $namaTabel b
						// left join petugas p on p.kode = b.petugas
						// where b.petugas != ''
							// and  convert(Varchar(6),b.tgl,112)='$filterPeriode'
						// group by b.petugas, p.keterangan
					// ) x order by x.petugas;");
			
			$q1 = "select 
					T.petugas,
				  P.keterangan,
					T.PERIODE,
					COUNT(*) AS spk,
				  (SELECT COUNT(*) FROM $namaTabel T1 
					WHERE T.PERIODE = T1.PERIODE
					AND T.PETUGAS = T1.PETUGAS
					AND T1.TGL_SPK IS NOT NULL 
					AND ((T1.TGL_BAYAR IS NOT NULL AND T1.TGL_REALISASI IS NULL) 
						OR (T1.TGL_BAYAR IS NOT NULL AND T1.TGL_REALISASI IS NOT NULL AND T1.TUTUP = 0) 
				   )) AS bayar,
				  (SELECT COUNT(*) FROM $namaTabel T1 
					WHERE T.PERIODE = T1.PERIODE
					AND T.PETUGAS = T1.PETUGAS 
					AND T1.TGL_REALISASI IS NOT  NULL
					AND T1.REALISASI = '2. Kopling'
					AND T1.TGL_SPK IS NOT NULL 
				  AND T1.TUTUP = 1) AS REALISASI_KOPLING,
				  (SELECT COUNT(*) FROM $namaTabel T1 
					WHERE T.PERIODE = T1.PERIODE
					AND T.PETUGAS = T1.PETUGAS 
					AND T1.TGL_REALISASI IS NOT  NULL
					AND T1.REALISASI = '1. Melepas meter'
					AND T1.TGL_SPK IS NOT NULL 
				  AND T1.TUTUP = 1) AS REALISASI_LEPAS_METER,
				  (SELECT COUNT(*) FROM $namaTabel T1 
					WHERE T.PERIODE = T1.PERIODE
					AND T.PETUGAS = T1.PETUGAS 
					AND T1.TGL_REALISASI IS NOT  NULL
					AND T1.REALISASI = '3. DOP'
					AND T1.TGL_SPK IS NOT NULL 
				  AND T1.TUTUP = 1) AS REALISASI_DOP,
				  (SELECT COUNT(*) FROM $namaTabel T1 
					WHERE T.PERIODE = T1.PERIODE
					AND T.PETUGAS = T1.PETUGAS
					AND T1.TGL_BAYAR IS NULL
					AND T1.TGL_SPK IS NOT NULL 
					AND T1.REALISASI = '3. Tempo'
				  AND T1.TUTUP = 0) AS tempo,
				  (SELECT COUNT(*) FROM $namaTabel T1 
					WHERE T.PERIODE = T1.PERIODE
					AND T.PETUGAS = T1.PETUGAS
					AND T1.TGL_BAYAR IS NULL
					AND T1.TGL_REALISASI IS NULL 
					AND T1.TGL_SPK IS NOT NULL 
				) AS sisa
				from $namaTabel T, PETUGAS P
				WHERE  T.PERIODE = '".$filterPeriode."'
				AND P.KODE = T.PETUGAS 
				AND T.TGL_SPK IS NOT NULL


				GROUP BY 	
				  T.PERIODE,
					T.PETUGAS,
					P.KETERANGAN
					
					HAVING COUNT(*) > 1

					ORDER BY T.PETUGAS ASC

		"; 
		return $this->db->query($q1);
	}
	
	public function laporan_monitoring(){
			$periode = 	pdam_get("periode");	
			$tutupan_periode = "";
			if ($periode != self::periode()) {
					$tutupan_periode = "_".$periode;
			}
			$sql = "select 
					T.PETUGAS,
				  P.KETERANGAN,
					T.PERIODE,
					COUNT(*) AS SPK,
				  (SELECT COUNT(*) FROM TUTUPAN".$tutupan_periode." T1 
					WHERE T.PERIODE = T1.PERIODE
					AND T.PETUGAS = T1.PETUGAS
					AND T1.TGL_SPK IS NOT NULL 
					AND ((T1.TGL_BAYAR IS NOT NULL AND T1.TGL_REALISASI IS NULL) 
						OR (T1.TGL_BAYAR IS NOT NULL AND T1.TGL_REALISASI IS NOT NULL AND T1.TUTUP = 0) 
				   )) AS BAYAR,
				  (SELECT COUNT(*) FROM TUTUPAN".$tutupan_periode." T1 
					WHERE T.PERIODE = T1.PERIODE
					AND T.PETUGAS = T1.PETUGAS 
					AND T1.TGL_REALISASI IS NOT  NULL
					AND T1.REALISASI = '2. Kopling'
					AND T1.TGL_SPK IS NOT NULL 
				  AND T1.TUTUP = 1) AS REALISASI_KOPLING,
				  (SELECT COUNT(*) FROM TUTUPAN".$tutupan_periode." T1 
					WHERE T.PERIODE = T1.PERIODE
					AND T.PETUGAS = T1.PETUGAS 
					AND T1.TGL_REALISASI IS NOT  NULL
					AND T1.REALISASI = '1. Melepas meter'
					AND T1.TGL_SPK IS NOT NULL 
				  AND T1.TUTUP = 1) AS REALISASI_LEPAS_METER,
				  (SELECT COUNT(*) FROM TUTUPAN".$tutupan_periode." T1 
					WHERE T.PERIODE = T1.PERIODE
					AND T.PETUGAS = T1.PETUGAS 
					AND T1.TGL_REALISASI IS NOT  NULL
					AND T1.REALISASI = '3. DOP'
					AND T1.TGL_SPK IS NOT NULL 
				  AND T1.TUTUP = 1) AS REALISASI_DOP,
				  (SELECT COUNT(*) FROM TUTUPAN".$tutupan_periode." T1 
					WHERE T.PERIODE = T1.PERIODE
					AND T.PETUGAS = T1.PETUGAS
					AND T1.TGL_BAYAR IS NULL
					AND T1.TGL_REALISASI IS NOT  NULL
					AND T1.TGL_SPK IS NOT NULL 

				  AND T1.TUTUP = 0) AS TEMPO,
				  (SELECT COUNT(*) FROM TUTUPAN".$tutupan_periode." T1 
					WHERE T.PERIODE = T1.PERIODE
					AND T.PETUGAS = T1.PETUGAS
					AND T1.TGL_BAYAR IS NULL
					AND T1.TGL_REALISASI IS NULL 
					AND T1.TGL_SPK IS NOT NULL 
				) AS SISA
				from TUTUPAN".$tutupan_periode." T, PETUGAS P
				WHERE  T.PERIODE = '".$periode."'
				AND P.KODE = T.PETUGAS 
				AND T.TGL_SPK IS NOT NULL


				GROUP BY 	
				  T.PERIODE,
					T.PETUGAS,
					P.KETERANGAN
					
					HAVING COUNT(*) > 1

					ORDER BY SISA DESC

		"; 
		$resultData	 = $this->db->query($sql);		 
		
		$year = substr($periode, 0, 4);
		$month = substr($periode, 4, 2);
		$result['rows'] = $resultData->result() ;
		$result['periode'] = date("F Y", strtotime("01-".$month."-".$year));
		
		//die($result['periode']." == ".$month."-01-".$year);
		$this->load->view('laporan_monitoring', $result);
		// Get output html
        $html = $this->output->get_output();
         
        // Load library
        $this->load->library('dompdf_gen');
         
        // Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("laporan_ts_".$periode."_".date("Y_m_d_H_i_s").".pdf",array('Attachment'=>0));
		//T.TGL_JADWAL IS NOT NULL
	}

}
?>