<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
set_time_limit(600);
ini_set("memory_limit","1024M");
ini_set("memory_limit","-1"); #use this setting for running on windows
class Laporan_ts extends CI_Controller {
	function __construct(){
		parent::__construct();
    }
	public function index(){
		$this->rekapTS();
	}
	function rekapTS(){
		$periode = null;
		for($y=2015;$y <= date("Y"); $y++){
			$btsM	= $y == date('Y') ? date("m") : 12;
			for($m=1;$m <= $btsM; $m++){
				$mm = strlen($m) == 1 ? '0'.$m : $m;		
				$active = "";
				if($m == date("m"))$active = " selected";
				$periode .= "<option value='$y$mm' $active>$y$mm</option>";
			}
		}
		$data['listPeriode'] = $periode;
		$this->load->view('ts/laporan/laporanRekapTS',$data);
	}
	function daftarRekapTS(){
		$filterPeriode = isset($_POST['periode']) ? $_POST['periode'] : date("Ym");
		$namaTabel = "tutupan";
			$queryCekTabel=$this->db->query("select * from INFORMATION_SCHEMA.TABLES where TABLE_NAME like 'tutupan_$filterPeriode%';");
			if($queryCekTabel->num_rows() > 0){$namaTabel = $namaTabel."_".$filterPeriode;}
				$query = $this->db->query("select CONVERT(VARCHAR(24),z.tgl,103) as TGL,sum(z.orders) as ORDERS,sum(z.spk) as SPK,sum(z.buka) as BUKA,sum(z.gagal) as GAGAL,(sum(z.spk) - sum(z.buka)) as SISA from(
											select tgl,count(*) as orders ,0 as spk,0 as buka,0 as gagal from $namaTabel where convert(Varchar(6),tgl,112)='$filterPeriode' group by tgl
											union
											select tgl,0 as orders ,count(*) as spk,0 as buka,0 as gagal from $namaTabel where convert(Varchar(6),tgl,112)='$filterPeriode' and tgl_spk is not null group by tgl
											union
											select tgl,0 as orders ,0 as spk,count(*) as buka,0 as gagal from $namaTabel where convert(Varchar(6),tgl,112)='$filterPeriode' and tutup = '1' group by tgl
											union
											select tgl,0 as orders ,0 as spk,0 as buka,count(*) as gagal from $namaTabel where convert(Varchar(6),tgl,112)='$filterPeriode' and tutup = '0' and tgl_realisasi is not null group by tgl
											)z group by z.tgl");
				echo json_encode($query->result());
		
	}
	function rekapTSbyPetugas(){
		$periode = null;
		for($y=2015;$y <= date("Y"); $y++){
			$btsM	= $y == date('Y') ? date("m") : 12;
			for($m=1;$m <= $btsM; $m++){
				$mm = strlen($m) == 1 ? '0'.$m : $m;		
				$active = "";
				if($m == date("m"))$active = " selected";
				$periode .= "<option value='$y$mm' $active>$y$mm</option>";
			}
		}
		$data['listPeriode'] = $periode;
		$this->load->view('ts/laporan/laporanRekapTSbyPetugas',$data);
	}
	function daftarRekapTSbyPetugas(){
		$this->load->model('ts/Md_laporanTS');
		
		$filterPeriode = isset($_POST['periode']) ? $_POST['periode'] : date("Ym");
		$namaTabel = "tutupan";
			$queryCekTabel=$this->db->query("select * from INFORMATION_SCHEMA.TABLES where TABLE_NAME like 'tutupan_$filterPeriode';");
			if($queryCekTabel->num_rows() > 0){$namaTabel = $namaTabel."_".$filterPeriode;}
				$query = $this->Md_laporanTS->getRekapPerPetugas($namaTabel,$filterPeriode);
				
				//$totOrd = 0;
				$totSpk = 0;
				$totByr = 0;
				$totREALISASI_KOPLING = 0;
				$totREALISASI_LEPAS_METER = 0;
				$totREALISASI_DOP = 0;
				$totTem = 0;
				$totSis = 0;
				foreach ($query->result() as $row) {
					//$totOrd += $row->orders;
					$totSpk += $row->spk;
					$totByr += $row->bayar;
					$totREALISASI_KOPLING += $row->REALISASI_KOPLING;
					$totREALISASI_LEPAS_METER += $row->REALISASI_LEPAS_METER;
					$totREALISASI_DOP += $row->REALISASI_DOP;
					$totTem += $row->tempo;
					$totSis += $row->sisa;
				}
				
				echo '{"total":1,"rows":'.json_encode($query->result()).',"footer":[
						{"petugas":"TOTAL","keterangan":"","spk":'.$totSpk.',"bayar":'.$totByr.',"REALISASI_KOPLING":'.$totREALISASI_KOPLING.',"REALISASI_LEPAS_METER":'.$totREALISASI_LEPAS_METER.',"REALISASI_DOP":'.$totREALISASI_DOP.',"tempo":'.$totTem.',"sisa":'.$totSis.'}
						]}';
	}
	function rekapTSbyDesa(){
		$periode = null;
		for($y=2015;$y <= date("Y"); $y++){
			$btsM	= $y == date('Y') ? date("m") : 12;
			for($m=1;$m <= $btsM; $m++){
				$mm = strlen($m) == 1 ? '0'.$m : $m;		
				$active = "";
				if($m == date("m"))$active = " selected";
				$periode .= "<option value='$y$mm' $active>$y$mm</option>";
			}
		}
		$data['listPeriode'] = $periode;
		$this->load->view('ts/laporan/laporanRekapTSbyDesa',$data);
	}
	function daftarRekapTSbyDesa(){
		$filterPeriode = isset($_POST['periode']) ? $_POST['periode'] : date("Ym");
		$namaTabel = "tutupan";
			$queryCekTabel=$this->db->query("select * from INFORMATION_SCHEMA.TABLES where TABLE_NAME like 'tutupan_$filterPeriode%';");
			if($queryCekTabel->num_rows() > 0){$namaTabel = $namaTabel."_".$filterPeriode;}
				$query = $this->db->query("select convert(Varchar(20),tgl,112) as tgl from tutupan where convert(Varchar(6),tgl,112)='201505' group by tgl");
				#echo json_encode($query->result());
				echo "<table table width='100%' class='custom-table'>";
				echo "<tr><th>DESA</th><th width='10%'>ORDER</th><th width='10%'>SPK</th><th width='10%'>DITUTUP</th><th width='10%'>GAGAL</th><th width='10%'>SISA</th></tr>";
				$hitungGrandOrder = 0;
				$hitungGrandSPK = 0;
				$hitungGrandBuka = 0;
				$hitungGrandGagal = 0;
				$hitungGrandSisa = 0;
				foreach($query->result() as $row){
					echo "<tr><th colspan='6'>$row->tgl</th></tr>";
					$query2 = $this->db->query("select z.desa,(select KETERANGAN from desa d where d.kode = z.desa) as nama,sum(z.orders) as orders,sum(z.spk) as spk,sum(z.buka) as buka,sum(z.gagal) as gagal,(sum(z.spk) - sum(z.buka)) as sisa from(
					select b.desa,count(*) as orders ,0 as spk,0 as buka,0 as gagal from tutupan b where convert(Varchar(8),b.tgl,112)='$row->tgl' group by b.desa
					union
					select b.desa,0 as orders ,count(*) as spk,0 as buka,0 as gagal from tutupan b where convert(Varchar(8),b.tgl,112)='$row->tgl' and b.tgl_spk is not null group by b.desa
					union
					select b.desa,0 as orders ,0 as spk,count(*) as buka,0 as gagal from tutupan b where convert(Varchar(8),b.tgl,112)='$row->tgl' and b.TUTUP = '1' group by b.desa
					union
					select b.desa,0 as orders ,0 as spk,0 as buka,count(*) as gagal from tutupan b where convert(Varchar(8),b.tgl,112)='$row->tgl' and b.TUTUP = '0' and b.tgl_realisasi is not null group by b.desa
					)z 
					group by z.desa");
					$hitungOrder = 0;
					$hitungSPK = 0;
					$hitungBuka = 0;
					$hitungGagal = 0;
					$hitungSisa = 0;
					foreach($query2->result() as $row2){
						$stateRow ="";
						if($row2->sisa > 0){$stateRow = "style='background:#fad395;'";}
						echo "<tr><td $stateRow>$row2->nama</td><td $stateRow>$row2->orders</td><td $stateRow>$row2->spk</td><td $stateRow>$row2->buka</td><td $stateRow>$row2->gagal</td><td $stateRow>$row2->sisa</td></tr>";
						$hitungOrder += $row2->orders;
						$hitungSPK += $row2->spk;
						$hitungBuka += $row2->buka;
						$hitungGagal += $row2->gagal;
						$hitungSisa += $row2->sisa;
					}
					echo "<tr><td align='right'>Sub Total :</td><td>$hitungOrder</td><td>$hitungSPK</td><td>$hitungBuka</td><td>$hitungGagal</td><td>$hitungSisa</td></tr>";
					$hitungGrandOrder += $hitungOrder;
					$hitungGrandSPK += $hitungSPK;
					$hitungGrandBuka += $hitungBuka;
					$hitungGrandGagal += $hitungGagal;
					$hitungGrandSisa += $hitungSisa;
				}
				echo "<tr><td align='right'>Total :</td><td>$hitungGrandOrder</td><td>$hitungGrandSPK</td><td>$hitungGrandBuka</td><td>$hitungGrandGagal</td><td>$hitungGrandSisa</td></tr>";
				echo "</table>";
	}
	function laporanOrder($mode=0){
		$periode = null;
		for($y=2015;$y <= date("Y"); $y++){
			$btsM	= $y == date('Y') ? date("m") : 12;
			for($m=1;$m <= $btsM; $m++){
				$mm = strlen($m) == 1 ? '0'.$m : $m;		
				$active = "";
				if($m == date("m"))$active = " selected";
				$periode .= "<option value='$y$mm' $active>$y$mm</option>";
			}
		}
		$listModeTampilan = '';
		for($a=0;$a <= 1; $a++){
			$active = "";
			if($a == $mode)$active = " selected";
			$modeTitle = '';
			switch($a){
				case '1' 	: {$modeTitle = 'Daftar Order Belum SPK'; break;}
				default 	: {$modeTitle = 'Daftar Semua ORDER'; break;}
			}
			$listModeTampilan .= "<option value='$a' $active>$modeTitle</option>";
		}
		$data['listPeriode'] = $periode;
		$data['listModeTampilan'] = $listModeTampilan;
		$this->load->view('ts/laporan/laporanDaftarOrder',$data);
	}
	function daftarOrder($periode,$aw,$ak,$mode){
		$namaTabel = "tutupan";
		$where = '';
		switch($mode){
			case '1' 	: {$where = ' and tgl_spk is null '; break;}
		}
			$queryCekTabel=$this->db->query("select * from INFORMATION_SCHEMA.TABLES where TABLE_NAME like 'tutupan_$periode%';");
			if($queryCekTabel->num_rows() > 0){$namaTabel = $namaTabel."_".$filterPeriode;}
				$query = $this->db->query("select CONVERT(VARCHAR(24),b.tgl,103) as TGL , b.NOMOR, b.NOSAL, p.NAMA, p.ALAMAT, b.DESA, b.NO_BUKU, b.PETUGAS
					from $namaTabel b
					left join pelanggan p on p.NOSAL = b.NOSAL
					where 
						convert(Varchar(8),b.TGL,112) between '$aw' and '$ak' 
						$where
					order by b.TGL asc ;");
				$view = "";
				$view .= "<table border='1' width='100%'>";
				$view .= "<tr>
						<th>No</th><th>Tgl. Order</th><th>No. Order</th><th>Nosal</th><th>Nama<br>Alamat</th><th>No. Buku<br>Petugas</th></tr>";
				$i = 1;
				foreach($query->result() as $row){
					$view .= "<tr><td>$i</td><td>$row->TGL</td><td>$row->NOMOR</td><td>$row->NOSAL</td><td>$row->NAMA <br> $row->ALAMAT</td><td>$row->DESA - $row->NO_BUKU <br> $row->PETUGAS</td></tr>";
					$i++;
				}
				$view .= "</table>";
		echo $view;
	}
	function laporanSPK($mode=0){
		$periode = null;
		for($y=2015;$y <= date("Y"); $y++){
			$btsM	= $y == date('Y') ? date("m") : 12;
			for($m=1;$m <= $btsM; $m++){
				$mm = strlen($m) == 1 ? '0'.$m : $m;		
				$active = "";
				if($m == date("m"))$active = " selected";
				$periode .= "<option value='$y$mm' $active>$y$mm</option>";
			}
		}
		$listModeTampilan = '';
		for($a=0;$a <= 3; $a++){
			$active = "";
			if($a == $mode)$active = " selected";
			$modeTitle = '';
			switch($a){
				case '1' 	: {$modeTitle = 'Daftar SPK Belum Realisasi'; break;}
				case '2' 	: {$modeTitle = 'Daftar SPK Realisasi'; break;}
				case '3' 	: {$modeTitle = 'Daftar SPK Gagal Realisasi'; break;}
				default 	: {$modeTitle = 'Daftar SPK'; break;}
			}
			$listModeTampilan .= "<option value='$a' $active>$modeTitle</option>";
		}
		$data['listPeriode'] = $periode;
		$data['listModeTampilan'] = $listModeTampilan;
		$this->load->view('ts/laporan/laporanDaftarSPK',$data);
	}
	function daftarSPK($periode,$aw,$ak){
		//echo phpinfo(); die();
		$namaTabel = "tutupan";
		$where = '';
			$queryCekTabel=$this->db->query("select * from INFORMATION_SCHEMA.TABLES where TABLE_NAME like 'tutupan_$periode%';");
			if($queryCekTabel->num_rows() > 0){$namaTabel = $namaTabel."_".$periode;}
				$query = $this->db->query("select CONVERT(VARCHAR(24),b.TGL_SPK,103) as TGL_SPK, CONVERT(VARCHAR(24),b.TGL_REALISASI,103) as TGL_REALISASI, b.NOMOR, b.NO_SPK, b.NOSAL, b.KETERANGAN, p.NAMA, p.ALAMAT
					from $namaTabel b
					left join pelanggan p on p.NOSAL = b.NOSAL
					where 
						b.TGL_SPK is not null and
						b.NO_SPK != '' and
						convert(Varchar(8),b.TGL_SPK,112) between '$aw' and '$ak'
					order by b.TGL_SPK, b.TGL_REALISASI asc ;");
				$view = "";
				$view .= "<table border='1'>";
				$view .= "<tr bgcolor='#eeeeee' repeat='1'><td style='bold'>No</td><td style='bold'>Tgl. SPK <br>Tgl</td><td style='bold'>No. SPK<br>No. Order</td><td style='bold'>No. Saluran</td><td style='bold'>Nama<br>Alamat</td><td style='bold'>Keterangan</td></tr>";
				$i = 1;
				foreach($query->result() as $row){
					$view .= "<tr><td>$i</td><td>$row->TGL_SPK<br>$row->TGL_REALISASI</td><td>$row->NO_SPK<br>$row->NOMOR</td><td>$row->NOSAL</td><td>$row->NAMA <br>$row->ALAMAT</td><td>$row->KETERANGAN</td></tr>";
					$i++;
				}
				$view .= "</table>";
		//echo $view;
		
		$this->load->library('pdf/pdf');
		define("FPDF_FONTPATH",'dist/cur/');
		$pdf = new PDF('P','mm','Letter');
		
		$pdf->SetMargins(20,10,15);
		$pdf->SetDisplayMode('real','single');
		$pdf->AddPage('P');
		$pdf->SetFont('Times','B',12);
		$pdf->text(0,'LAPORAN',0,'C');
		$pdf->Ln(20);
		$pdf->SetFont('Times','',8);
		$pdf->htmltable($view);
		$pdf->output('lap_tes.pdf','I');
		exit;
	}
	function daftarBelumRealisasiSPK($periode,$aw,$ak){
		$namaTabel = "tutupan";
		$where = '';
			$queryCekTabel=$this->db->query("select * from INFORMATION_SCHEMA.TABLES where TABLE_NAME like 'tutupan_$periode%';");
			if($queryCekTabel->num_rows() > 0){$namaTabel = $namaTabel."_".$periode;}
				$query = $this->db->query("select CONVERT(VARCHAR(24),b.TGL,103) as TGL, CONVERT(VARCHAR(24),b.TGL_SPK,103) as TGL_SPK, CONVERT(VARCHAR(24),b.TGL_REALISASI,103) as TGL_REALISASI, b.NOMOR, b.NO_SPK, b.NOSAL, b.REALISASI, b.KETERANGAN, p.NAMA, p.ALAMAT, pe.KETERANGAN as PETUGAS, b.NO_SLAG, b.JENIS_MTR, b.STAND, b.SEGEL_ID
					from $namaTabel b
					left join pelanggan p on p.NOSAL = b.NOSAL
					left join petugas pe on pe.KODE = b.PETUGAS
					where 
						b.TGL_SPK is not null and
						b.NO_SPK != '' and
						b.TGL_REALISASI is null and
						convert(Varchar(8),b.TGL_SPK,112) between '$aw' and '$ak'
					order by  pe.KETERANGAN, b.TGL_SPK;");
				$view = "";
				$view .= "<table border='1' width='100%'>";
				$view .= "<tr>
						<th>No</th><th>Tgl. SPK <br>Tgl</th><th>No. SPK<br>No. Order</th><th>No. Saluran</th><th>Nama<br>Alamat</th><th>Keterangan</th></tr>";
				$i = 1;
				foreach($query->result() as $row){
					$view .= "<tr><td>$i</td><td>$row->TGL_SPK<br>$row->TGL_REALISASI</td><td>$row->NO_SPK<br>$row->NOMOR</td><td>$row->NOSAL</td><td>$row->NAMA <br>$row->ALAMAT</td><td>$row->KETERANGAN</td></tr>";
					$i++;
				}
				$view .= "</table>";
		echo $view;
	}
	function daftarRealisasiSPK($periode,$aw,$ak){
		$namaTabel = "tutupan";
		$where = '';
			$queryCekTabel=$this->db->query("select * from INFORMATION_SCHEMA.TABLES where TABLE_NAME like 'tutupan_$periode%';");
			if($queryCekTabel->num_rows() > 0){$namaTabel = $namaTabel."_".$periode;}
				$query = $this->db->query("select CONVERT(VARCHAR(24),b.TGL,103) as TGL, CONVERT(VARCHAR(24),b.TGL_SPK,103) as TGL_SPK, CONVERT(VARCHAR(24),b.TGL_REALISASI,103) as TGL_REALISASI, b.NOMOR, b.NO_SPK, b.NOSAL, b.REALISASI, b.KETERANGAN, p.NAMA, p.ALAMAT, pe.KETERANGAN as PETUGAS, b.NO_SLAG, b.JENIS_MTR, b.STAND, b.SEGEL_ID
					from $namaTabel b
					left join pelanggan p on p.NOSAL = b.NOSAL
					left join petugas pe on pe.KODE = b.PETUGAS
					where 
						b.TGL_SPK is not null and
						b.NO_SPK != '' and
						b.TGL_REALISASI is not null and
						convert(Varchar(8),b.TGL_SPK,112) between '$aw' and '$ak'
					order by  pe.KETERANGAN, b.TGL_SPK;");
				$view = "";
				$view .= "<table border='1' width='100%'>";
				$view .= "<tr><th>No</th><th>TGl. REALISASI</th><th>NOSAL</th><th>NAMA<br>ALAMAT</th><th>TGL ORDER<br>TGL SPK</th><th>CARA PENUTUPAN<br>KETERANGAN</th><th>NO SLAG<br>STAND<br>JENIS METER</th><th>SEGEL ID</th></tr>";
				$i = 1;
				foreach($query->result() as $row){
					$view .= "<tr><td>$i</td><td>$row->TGL_REALISASI</td><td>$row->NOSAL</td><td>$row->NAMA<br>$row->ALAMAT</td><td>$row->TGL<br>$row->TGL_SPK</td><td>$row->REALISASI <br>$row->KETERANGAN</td><td>$row->NO_SLAG<br>$row->STAND<br>$row->JENIS_MTR</td><td>$row->SEGEL_ID</td></tr>";
					$i++;
				}
				$view .= "</table>";
		echo $view;
	}
	
	
	///////////////////////
	
	function detailRealisasiTS(){
		$periode = null;
		for($y=2015;$y <= date("Y"); $y++){
			$btsM	= $y == date('Y') ? date("m") : 12;
			for($m=1;$m <= $btsM; $m++){
				$mm = strlen($m) == 1 ? '0'.$m : $m;		
				$active = "";
				if($m == date("m"))$active = " selected";
				$periode .= "<option value='$y$mm' $active>$y$mm</option>";
			}
		}
		$data['listPeriode'] = $periode;
		$this->load->view('ts/laporan/detailRealisasiTS',$data);
	}
	
	function daftarDetailRealisasiTS(){
		$filterPeriode = isset($_POST['periode']) ? $_POST['periode'] : date("Ym");
		
		$opt = isset($_POST['opt']) ? $_POST['opt'] : '';
		$val = isset($_POST['val']) ? $_POST['val'] : '';
		
		$namaTabel = $filterPeriode == date('Ym') ? "TUTUPAN" : "TUTUPAN_".$filterPeriode ;

		$this->db->select("t.*, ri.*, convert(varchar(20),t.tgl_realisasi,106) TGLREALISASI,convert(varchar(20),t.tgl_jadwal,106) TGLJADWAL,pt.keterangan PETUGAS,ri.KETERANGAN KETR,
							(CASE PTS WHEN 0 THEN '<font color=red>TIDAK</font>' WHEN 1 THEN '<font color=green>YA</font>' END) PTSX,
							(CASE ATS WHEN 0 THEN '<font color=red>TIDAK</font>' WHEN 1 THEN '<font color=green>YA</font>' END) ATSX,
							(CASE ATM WHEN 0 THEN '<font color=red>TIDAK</font>' WHEN 1 THEN '<font color=green>YA</font>' END) ATMX,
							(CASE PTB WHEN 0 THEN '<font color=red>TIDAK</font>' WHEN 1 THEN '<font color=green>YA</font>' END) PTBX,
							p.NAMA,p.ALAMAT,
							'<a href=# onclick=mapViewer(&quot;http://10.10.40.2/bukatutup/index.php/ts/laporan_ts/genMaps/'+REPLACE(ri.NO_SPK,'\\','~')+'&quot;)>lokasi</a>' LOKASI,
							'<a title=Nosal:'+t.NOSAL+' href=# onclick=photoViewer(&quot;http://10.10.30.2/api/assets/uploaded/'+REPLACE(s.path,'\\','/')+'&quot;)><img src=http://10.10.30.2/api/assets/uploaded/'+REPLACE(s.path,'\\','/')+' width=80 /></a>' FOTO
		");
		$this->db->from('realisasi_info ri');
		$this->db->join($namaTabel.' t','t.no_spk=ri.no_spk','left');
		$this->db->join('petugas pt','pt.kode=t.petugas','left');
		$this->db->join('pelanggan p','t.nosal=p.nosal','left');
		$this->db->join('spk_file s','s.no_spk=t.no_spk','left');
		$this->db->where('ri.tipe','TS_REALISASI');
		$this->db->where('t.TUTUP',1);
		if ($val != '') $this->db->like('p.'.$opt,$val,"BOTH");
		$this->db->where('ri.PERIODE',$filterPeriode);
		$query =  $this->db->get();
	
		echo json_encode($query->result());
		
	}
	
	public function genMaps($spk='') {
		$spk = str_replace('~','\\',$spk);
		$query = $this->db->query("select latitude,longitude from realisasi_info where tipe='TS_REALISASI' and no_spk = '".$spk."'");
		if ($query->num_rows() > 0) {
			$row = $query->row();
			
			$lat	= $row->latitude;
			$long	= $row->longitude;
			
			$data	= array(
						'lat'	=> $lat,
						'long'	=> $long
			);
			$this->load->view('ts/laporan/genMaps',$data);
		} else {
			$lat	= '';	//'-7.18130241';
			$long	= '';	//'112.61628165';
			
			echo '<center><i>-titik koordinat tidak ditemukan-</i></center>';
		}
	
		
	}
	
	
	function tempoBayarTS(){
		$periode = null;
		for($y=2015;$y <= date("Y"); $y++){
			$btsM	= $y == date('Y') ? date("m") : 12;
			for($m=1;$m <= $btsM; $m++){
				$mm = strlen($m) == 1 ? '0'.$m : $m;		
				$active = "";
				if($m == date("m"))$active = " selected";
				$periode .= "<option value='$y$mm' $active>$y$mm</option>";
			}
		}
		$data['listPeriode'] = $periode;
		$this->load->view('ts/laporan/tempoBayarTS',$data);
	}
	
	function daftarTempoBayarTS(){
		$filterPeriode = isset($_POST['periode']) ? $_POST['periode'] : date("Ym");
		
		$namaTabel = $filterPeriode == date('Ym') ? "TUTUPAN" : "TUTUPAN_".$filterPeriode ;
		$this->db->select("t.*, ri.*, convert(varchar(20),ri.tgl_realisasi,106) TGLREALISASI,pt.keterangan PETUGAS,ri.KETERANGAN KETR,
							(CASE PTS WHEN 0 THEN '<font color=red>TIDAK</font>' WHEN 1 THEN '<font color=green>YA</font>' END) PTSX,
							(CASE ATS WHEN 0 THEN '<font color=red>TIDAK</font>' WHEN 1 THEN '<font color=green>YA</font>' END) ATSX,
							(CASE ATM WHEN 0 THEN '<font color=red>TIDAK</font>' WHEN 1 THEN '<font color=green>YA</font>' END) ATMX,
							(CASE PTB WHEN 0 THEN '<font color=red>TIDAK</font>' WHEN 1 THEN '<font color=green>YA</font>' END) PTBX,
		");
		$this->db->from('realisasi_info ri');
		$this->db->join($namaTabel.' t','t.no_spk=ri.no_spk','left');
		$this->db->join('petugas pt','pt.kode=t.petugas','left');
		$this->db->where('ri.tipe','TS_TEMPO');
		$this->db->where('ri.PERIODE',$filterPeriode);
		$query =  $this->db->get();
	
		echo json_encode($query->result());
		
	}
	
	function titipBayarTS(){
		$periode = null;
		for($y=2015;$y <= date("Y"); $y++){
			$btsM	= $y == date('Y') ? date("m") : 12;
			for($m=1;$m <= $btsM; $m++){
				$mm = strlen($m) == 1 ? '0'.$m : $m;		
				$active = "";
				if($m == date("m"))$active = " selected";
				$periode .= "<option value='$y$mm' $active>$y$mm</option>";
			}
		}
		$data['listPeriode'] = $periode;
		$this->load->view('ts/laporan/titipBayarTS',$data);
	}
	
	function rekapBayarDitempat(){
		$periode = null;
		for($y=2015;$y <= date("Y"); $y++){
			$btsM	= $y == date('Y') ? date("m") : 12;
			for($m=1;$m <= $btsM; $m++){
				$mm = strlen($m) == 1 ? '0'.$m : $m;		
				$active = "";
				if($m == date("m"))$active = " selected";
				$periode .= "<option value='$y$mm' $active>$y$mm</option>";
			}
		}
		$data['listPeriode'] = $periode;
		$this->load->view('ts/laporan/bayarDitempat',$data);
	}
	
	function getBayarDitempat(){
		$filterPeriode = isset($_POST['tgl_bayar']) ? str_replace("/","-",$_POST['tgl_bayar']) : date("Y-m-d");
		$tgl=date('Ymd',strtotime($filterPeriode));
		$periode=$this->cek_tabel('BI',date('Ym',strtotime($tgl)));
		$periodeKw=$this->cek_tabel('TOTKWITANSI',date('Ym',strtotime($tgl)));
		if($periode==''){
			$t_billing='BILLING';
		}else{
			$t_billing='BI'.$periode;
		}
		
		if($periodeKw==''){
			$t_kwitansi='TOTKWITANSI';
		}else{
			$t_kwitansi='TOTKWITANSI'.$periodeKw;
		}
		
		
			$str="
					select 
					z.id_petugas,
					z.petugas,
					z.jml_rek,
					z.jml_nosal,
					case when z.air is null then 0 else z.air end as air,
					case when z.non_air is null then 0 else z.non_air end as non_air,
					isnull(z.air,0)+isnull(z.non_air,0) as total,
					case when z.blm_verifikasi is null then 0 else z.blm_verifikasi end as blm_verifikasi,
					case when z.verifikasi is null then 0 else z.verifikasi end as verifikasi,
					z.tgl_verifikasi,
					y.full_name as verifikator
					from(
						select 
							a.idpetugas as id_petugas,
							c.keterangan as petugas,
							(
								select count(nomor) from ".$t_billing."
								where user_id=a.idpetugas
								and convert(Varchar(8),tgl,112)='".$tgl."'
								
							)as jml_rek,
							(
								select count(distinct nosal) from ".$t_billing."
								where user_id=a.idpetugas
								and convert(Varchar(8),tgl,112)='".$tgl."'
								
							)as jml_nosal,
							
							(
								select sum(total+materai) from ".$t_billing."
								where user_id=a.idpetugas
								and convert(Varchar(8),tgl,112)='".$tgl."'
							)as air,
							(
								select sum(bayar) from ".$t_kwitansi."
								where user_id=a.idpetugas
								and convert(Varchar(8),tgl,112)='".$tgl."'
							)as non_air,
							(
								select count(idpetugas) from realisasi_info 
								where convert(varchar(8),tgl_Realisasi,112)='".$tgl."'
								and idpetugas=a.idpetugas
								and tgl_verifikasi is not null
								and tipe='TS_TITIP'
								group by idpetugas
							) as verifikasi,
							(
								select count(idpetugas) from realisasi_info 
								where convert(varchar(8),tgl_Realisasi,112)='".$tgl."'
								and idpetugas=a.idpetugas
								and tgl_verifikasi is null
								and tipe='TS_TITIP'
								group by idpetugas
							) as blm_verifikasi,
							(
								select top 1 convert(varchar(10),tgl_verifikasi,105) from 
								realisasi_info 
								where convert(varchar(8),tgl_realisasi,112)='".$tgl."'
								and idpetugas=a.idpetugas
								and tgl_verifikasi is not null
								order by tgl_verifikasi desc
							) as tgl_verifikasi,
							(
								select top 1 user_verifikasi from 
								realisasi_info 
								where convert(varchar(8),tgl_realisasi,112)='".$tgl."'
								and idpetugas=a.idpetugas
								and tgl_verifikasi is not null
								order by tgl_verifikasi desc
							) as user_verifikasi
						from realisasi_info a
						inner join petugas c on a.idpetugas=c.kode
						where convert(varchar(8),a.tgl_realisasi,112)='".$tgl."'
						and tipe='TS_TITIP' and nomor_re is not null
						group by a.idpetugas,c.keterangan
					)z 
					left join hrd.dbo.v_employee_all y
					on z.user_verifikasi=y.nip
			";
			
			$query = $this->db->query($str);
				echo json_encode($query->result());
	}
	
	function laporanRekapBayarDitempat($tgl_bayar){
		
		$tgl=date('Ymd',strtotime(str_replace("~","-",$tgl_bayar)));
		$periode=$this->cek_tabel('BI',date('Ym',strtotime($tgl)));
		$periodeKw=$this->cek_tabel('TOTKWITANSI',date('Ym',strtotime($tgl)));
		if($periode==''){
			$t_billing='BILLING';
		}else{
			$t_billing='BI'.$periode;
		}
		
		if($periodeKw==''){
			$t_kwitansi='TOTKWITANSI';
		}else{
			$t_kwitansi='TOTKWITANSI'.$periodeKw;
		}
		
		
		
			$str="
					select 
					z.id_petugas,
					z.petugas,
					z.jml_rek,
					z.jml_nosal,
					case when z.air is null then 0 else z.air end as air,
					case when z.non_air is null then 0 else z.non_air end as non_air,
					isnull(z.air,0)+isnull(z.non_air,0) as total,
					case when z.blm_verifikasi is null then 0 else z.blm_verifikasi end as blm_verifikasi,
					case when z.verifikasi is null then 0 else z.verifikasi end as verifikasi,
					z.tgl_verifikasi,
					y.full_name as verifikator
					from(
						select 
							a.idpetugas as id_petugas,
							c.keterangan as petugas,
							(
								select count(nomor) from ".$t_billing."
								where user_id=a.idpetugas
								and convert(Varchar(8),tgl,112)='".$tgl."'
								
							)as jml_rek,
							(
								select count(distinct nosal) from ".$t_billing."
								where user_id=a.idpetugas
								and convert(Varchar(8),tgl,112)='".$tgl."'
								
							)as jml_nosal,
							
							(
								select sum(total+materai) from ".$t_billing."
								where user_id=a.idpetugas
								and convert(Varchar(8),tgl,112)='".$tgl."'
							)as air,
							(
								select sum(bayar) from ".$t_kwitansi."
								where user_id=a.idpetugas
								and convert(Varchar(8),tgl,112)='".$tgl."'
							)as non_air,
							(
								select count(idpetugas) from realisasi_info 
								where convert(varchar(8),tgl_Realisasi,112)='".$tgl."'
								and idpetugas=a.idpetugas
								and tgl_verifikasi is not null
								and tipe='TS_TITIP'
								group by idpetugas
							) as verifikasi,
							(
								select count(idpetugas) from realisasi_info 
								where convert(varchar(8),tgl_Realisasi,112)='".$tgl."'
								and idpetugas=a.idpetugas
								and tgl_verifikasi is null
								and tipe='TS_TITIP'
								group by idpetugas
							) as blm_verifikasi,
							(
								select top 1 convert(varchar(10),tgl_verifikasi,105) from 
								realisasi_info 
								where convert(varchar(8),tgl_realisasi,112)='".$tgl."'
								and idpetugas=a.idpetugas
								and tgl_verifikasi is not null
								order by tgl_verifikasi desc
							) as tgl_verifikasi,
							(
								select top 1 user_verifikasi from 
								realisasi_info 
								where convert(varchar(8),tgl_realisasi,112)='".$tgl."'
								and idpetugas=a.idpetugas
								and tgl_verifikasi is not null
								order by tgl_verifikasi desc
							) as user_verifikasi
						from realisasi_info a
						inner join petugas c on a.idpetugas=c.kode
						where convert(varchar(8),a.tgl_realisasi,112)='".$tgl."'
						and tipe='TS_TITIP' and nomor_re is not null
						group by a.idpetugas,c.keterangan
					)z 
					left join hrd.dbo.v_employee_all y
					on z.user_verifikasi=y.nip
			";
		$query=$this->db->query($str);	
		
		$this->load->library('mpdf/mPdf');
		$mpdf = new mPDF('c','Legal-L');
		$html = '
		<htmlpagefooter name="MyFooter1">
			<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #000000; font-weight: bold; font-style: italic;">
				<tr>
					<td width="33%" align="center" style="font-weight: bold; font-style: italic;">PDAM Malang - , PAGE {PAGENO} dari {nbpg}</td>
				</tr>
			</table>
		</htmlpagefooter>
		<sethtmlpagefooter name="MyFooter1" value="on" />
		<div style="font-size:20px; font-weight:bold">PDAM KOTA MALANG</div>
		<div style="font-weight:bold;">Jl. Terusan Danau Sentani No.100 - Malang</div>';
		$html.="
		<div style='font-size:20px; font-weight:bold; text-align:center;margin:10px'>Laporan Rekap Pembayaran Di Tempat<br/> Periode(".(str_replace("~","-",$tgl_bayar)).")</div>";
 		
		$html .='
		
		<table width="100%" border="1" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="5%" align="center"><strong>NO</strong></td>
			<td width="8%" align="center"><strong>ID PETUGAS</strong></td>
			<td width="20%" align="center"><strong>PETUGAS</strong></td>
			<td width="8%" align="center"><strong>REKENING</strong></td>
			<td width="8%" align="center"><strong>NOSAL</strong></td>
			<td width="10%" align="center"><strong>AIR</strong></td>
			<td width="8%" align="center"><strong>NON AIR</strong></td>
			<td width="8%" align="center"><strong>TOTAL</strong></td>
			<td width="8%" align="center"><strong>BLM VERIFIKASI</strong></td>
			<td width="8%" align="center"><strong>VERIFIKASI</strong></td>
			<td width="8%" align="center"><strong>TGL VERIFIKASI</strong></td>
			<td width="8%" align="center"><strong>VERIFIKATOR</strong></td>
		  </tr>';

		$no=1;
		$air=0;
		$non_air=0;
		$total=0;
		$rek=0;
		$nosal=0;
		
		$data = $this->db->query($str)->result();
		foreach($data as $row){
		$html .='  
		  <tr>
			<td align="center">'.$no.'</td>
			<td>'.$row->id_petugas.'</td>
			<td>'.$row->petugas.'</td>
			<td align="center">'.$row->jml_rek.'</td>
			<td align="center">'.$row->jml_nosal.'</td>
			<td align="right">'.number_format( $row->air , 2 , ',' , '.' ).'</td>
			<td align="right">'.number_format( $row->non_air , 2 , ',' , '.' ).'</td>
			<td align="right">'.number_format( $row->total , 2 , ',' , '.' ).'</td>
			<td align="center">'.$row->blm_verifikasi.'</td>
			<td align="center">'.$row->verifikasi.'</td>
			<td align="center">'.$row->tgl_verifikasi.'</td>
			<td>'.$row->verifikator.'</td>
		</tr>';
		$no++;
		$air+=$row->air;
		$non_air+=$row->non_air;
		$total+=$row->total;
		$rek+=$row->jml_rek;
		$nosal+=$row->jml_nosal;
		
		}
		$html.='
		  <tr>
			<td colspan="3" align="center">TOTAL</td>
			<td align="center">'.$rek.'</td>
			<td align="center">'.$nosal.'</td>
			<td align="right">'.number_format( $air , 2 , ',' , '.' ).'</td>
			<td align="right">'.number_format( $non_air , 2 , ',' , '.' ).'</td>
			<td align="right">'.number_format( $total , 2 , ',' , '.' ).'</td>
			<td align="center"></td>
			<td align="center"></td>
			<td align="center"></td>
			<td></td>
		</tr>';
		
		
		$ttd=$this->db->query("select * from hrd.dbo.v_employee_all where position_code='3.03.02.00.00'")->row_array();
		
		$html .= '</table>';
		$html .= '<div style="margin-top: 20px; right:0px; position:absolute; font-weight:bold; width:300px; text-align:center">Malang, '.date('d M Y').'</div>';
		$html .= '<div style="padding-top: 40px; right:0px; position:absolute; font-weight:bold; width:300px; text-align:center">Mengetahui</div>';
		$html .= '<div style="padding-top: 100px; right:0px; position:absolute; font-weight:bold; width:300px; text-align:center">'.$ttd['full_name'].'</div>';
		$html .= '<div style="padding-top: 120px; right:0px; position:absolute; font-weight:bold; width:300px; text-align:center">'.$ttd['position_code_desc'].'</div>';
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		
		
	}
	
	
	function daftarTitipBayarTS(){
		$filterPeriode = isset($_POST['periode']) ? $_POST['periode'] : date("Ym");
		
		$namaTabel = $filterPeriode == date('Ym') ? "TUTUPAN" : "TUTUPAN_".$filterPeriode ;

		$this->db->select("t.*, ri.*, convert(varchar(20),ri.tgl_realisasi,106) TGLREALISASI,pt.keterangan PETUGAS,ri.KETERANGAN KETR,
							(CASE PTS WHEN 0 THEN '<font color=red>TIDAK</font>' WHEN 1 THEN '<font color=green>YA</font>' END) PTSX,
							(CASE ATS WHEN 0 THEN '<font color=red>TIDAK</font>' WHEN 1 THEN '<font color=green>YA</font>' END) ATSX,
							(CASE ATM WHEN 0 THEN '<font color=red>TIDAK</font>' WHEN 1 THEN '<font color=green>YA</font>' END) ATMX,
							(CASE PTB WHEN 0 THEN '<font color=red>TIDAK</font>' WHEN 1 THEN '<font color=green>YA</font>' END) PTBX

		");
		$this->db->from('realisasi_info ri');
		$this->db->join($namaTabel.' t','t.no_spk=ri.no_spk','left');
		$this->db->join('petugas pt','pt.kode=t.petugas','left');
		$this->db->where('ri.tipe','TS_TITIP');
		$this->db->where('ri.PERIODE',$filterPeriode);
		$query =  $this->db->get();
	
		echo json_encode($query->result());
		
	}
	
	function cek_tabel($nama,$periode){
		$s_tbl="select * from sys.tables where name like '".$nama."_".$periode."'";
		$q_tbl=$this->db->query($s_tbl)->result_array();
		if(count($q_tbl)>0){
			return "_".$periode;
		}else{
			return '';
		}
	}
}