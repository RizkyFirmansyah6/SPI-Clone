<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
set_time_limit(0);
ini_set('memory_limit', '2000M');


class Realisasi_ts extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('ts/md_realisasiTS');
		$this->load->model('master_data/md_desa');
		$this->load->model('master_data/md_buku');
		$this->load->model('master_data/md_petugas');
    }
	public function index(){
		$bag 	= array("1.03", "3.03");
		$kodJ	= substr($this->session->userdata('kode_jabatan'),0,4);
		if (in_array($kodJ,$bag)) {
			$this->viewDaftarRealisasi();
		} else {
			echo '<div style="padding:20px;color:red"> 
				  Maaf, Anda tidak memiliki hak akses pada menu ini.
				  </div>';
		}
	}
	function viewDaftarRealisasi(){
		$view = $this->load->view('ts/realisasi_general',null,true);
		echo $view;
	}
	function viewDaftarCetakSPK(){
		$view = $this->load->view('ts/daftarCetakSPK',null,true);
		echo $view;
	}
	
	public function rekapPerTgl(){
		$query = $this->md_realisasiTS->getRekapPerTgl();
		
		$totSpk = 0;
		$totBhs = 0;
		$totByr = 0;
		$totSis = 0;
		foreach ($query->result() as $row) {
			$totSpk += $row->SPK;
			$totBhs += $row->BERHASIL;
			$totByr += $row->BAYAR;
			$totSis += $row->SISA;
		}
		//echo json_encode($result);
		echo '{"total":1,"rows":'.json_encode($query->result()).',"footer":[
		{"TGL_SPK":"TOTAL","SPK":'.$totSpk.',"BERHASIL":'.$totBhs.',"BAYAR":'.$totByr.',"SISA":'.$totSis.'}
		]}';
	}
	
	public function daftarRealisasiTS(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
		$status = isset($_POST['status']) ? $_POST['status'] : '';
		$petugas = isset($_POST['petugas']) ? $_POST['petugas'] : null;
		$nosal = isset($_POST['nosal']) ? $_POST['nosal'] : null;
		$filterTglJadwal = isset($_POST['tglJdw']) ? $_POST['tglJdw'] : '';
		
		$rs = $this->md_realisasiTS->ambilDaftarRealisasiTS(null,null,"total",$status,$petugas,$nosal,$filterTglJadwal);
		$result["total"] = $rs;
		
		$query = $this->md_realisasiTS->ambilDaftarRealisasiTS($page,$rows,null,$status,$petugas,$nosal,$filterTglJadwal);
		$result["rows"] = $query;
		
		echo json_encode($result);
	}
	public function daftarRealisasiTSCetak(){
		if ($_POST) {
			$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
			$filterDesa = isset($_POST['desa']) ? $_POST['desa'] : null;
			// $filterJadwal = isset($_POST['jadwal']) ? $_POST['jadwal'] : null;
			$filterTglJadwal = isset($_POST['tglJdw']) ? $_POST['tglJdw'] : null;
			$filterPetugas = isset($_POST['petugas']) ? $_POST['petugas'] : null;
			$filterNosal = isset($_POST['nosal']) ? $_POST['nosal'] : null;
			$filterTempo = isset($_POST['tempo']) ? $_POST['tempo'] : null;
			
			$rs = $this->md_realisasiTS->ambilDaftarRealisasiTSCetak(null,null,"total",$filterDesa,$filterPetugas,$filterTglJadwal,$filterNosal,$filterTempo);
			$result["total"] = $rs;
			
			$query = $this->md_realisasiTS->ambilDaftarRealisasiTSCetak($page,$rows,null,$filterDesa,$filterPetugas,$filterTglJadwal,$filterNosal,$filterTempo);
			$result["rows"] = $query;
			
			echo json_encode($result);
		}
	}
	function test_printing(){
		$this->load->view('print_tes',null);
	}
	public function formBPB(){
		if($_POST){
			//$ambilDataRealtimeTS = "select * from BUKAAN_S where NOMOR = '".$_POST['selected'][0]['NOMOR']."';";
			$qSelectBPB = $this->db->query($ambilDataRealtimeTS);
			if($qSelectBPB->num_rows() > 0){
				foreach($qSelectBPB->result() as $row){
					if(preg_replace('/\s+/', '', $row->NO_BPB) != ''){
						$_POST['selected'][0]['NO_BPB'] = $row->NO_BPB;
					}
				}
			}
			
			
			$data['dataTabel'] = $_POST['selected'];
			#var_dump($data['dataTabel']);
			
			$view = $this->load->view('ts/formBPB',$data,true);
			echo $view;
		}else{
			echo "Pilih daftar TS yang akan di buatkan spk terlebih dahulu.";
		}
		
	}
	function daftarBON(){
		#print_r($_POST['selected'][0]['NO_BPB']);
		//$ambilDataRealtimeTS = "select * from BUKAAN_S where NOMOR = '".$_POST['selected'][0]['NOMOR']."';";
		$qSelectBPB = $this->db->query($ambilDataRealtimeTS);
		$data['dataBarang'] = null;
		if($qSelectBPB->num_rows() > 0){
			foreach($qSelectBPB->result() as $row){
				if(preg_replace('/\s+/', '', $row->NO_BPB) != ''){
				$data['dataBarang'] = $this->daftarRealisasiBahan($row->NO_BPB);
				}
			}
		$view = $this->load->view('ts/daftarBON',$data,true);
		echo $view;
		}else{
			echo "data TS tidak ditemukan oleh system";
		}
	}
	function formPilihBarang(){
		$view = $this->load->view('ts/formPilihBarang',null,true);
		echo $view;
	}
	public function daftarBarang(){
		$q = $this->input->post('q');
		$query = $this->md_realisasiTS->ambilBarang($q);
		echo json_encode($query->result());
	}
	public function daftarVendor(){
		$q = $this->input->post('q');
		$query = $this->md_realisasiTS->ambilVendor($q);
		echo json_encode($query->result());
	}
	public function daftarBuku(){
		$query = $this->md_buku->ambilBukuRealisasiTS();
		echo json_encode($query->result());
	}
	public function daftarDesa(){
		$query = $this->md_desa->ambilDesaRealisasiTS();
		echo json_encode($query->result());
	}
	function buatBON(){
		if($_POST){
			if(preg_replace('/\s+/', '', $_POST['noBPB']) == ''){
				$this->buatBPB();
			}else{
				$this->buatBPS();
			}
		}else{
			echo "NO DIRECT ACCESS ! GO AWAY !";
		}
	}
	function tesSP(){
		$queryInsertBPB = "exec tes";
		$insertbySP = $this->db->query($queryInsertBPB);
		foreach($insertbySP->result() as $row){
			
		}
		if($row->stat){echo "tr";}else{echo "fl";}
	}
	function buatBPB(){
		if($_POST){
			$your_date = date("Y-m-d H:i:s");
			$user_id = $this->session->userdata("login");
			$user_id = $user_id['nip'];
			$queryInsertBPB = "exec createBon";
				
				
				$insertbySP = $this->db->query($queryInsertBPB);
				foreach($insertbySP->result() as $rowX1){}
				
				# run procedure	
				if($rowX1->stat){
					# get nomor BPB from query below
					$querySelectBPB = "select * from TOTBPB where NO_REG = '".$_POST['noTS']."';";
					$qSelectBPB = $this->db->query($querySelectBPB);
					if($qSelectBPB->num_rows() > 0){
						$noBPB = null;
						foreach($qSelectBPB->result() as $row){
							$noBPB = $row->NOMOR;
						}
						
						if($this->db->query($queryUpdateBUKAAN_S)){
							# insert BPB as detail per row
							$i = 1;
							$insertQueryData = "";
							foreach($_POST['selected'] as $row){
								#print_r($row);
								$insertQueryData .= "SELECT '".$noBPB."', '".$your_date."', '".sprintf("%02d", $i)."', '".$row['KODE']."', '".$row['QTY']."', '".$row['SATUAN']."', '".$row['GUD']."' UNION ALL ";
								$i++;
							}
							$insertQueryData = rtrim($insertQueryData, " UNION ALL");
							$queryInsertDetailBPB = "INSERT INTO ";
							if($this->db->query($queryInsertDetailBPB)){
								echo 1;
							}else{
								echo 0;
							}
						}else{
							echo "gagal update data TS (3).";
						}
					}else{
						echo "Data BPB tidak di temukan (2).";
					}
				}else{
					echo "error saat menyimpan bon BPB (sp).";
				}
			 
		}else{
			echo "Data tidak valid.";
		}
	}
	function buatBPS(){
		if($_POST){
			$your_date = date("Y-m-d H:i:s");
			$user_id = $this->session->userdata("login");
			$user_id = $user_id['nip'];
			$queryInsertBPS = "exec
				createBon ";
				
				$insertbySP = $this->db->query($queryInsertBPS);
				foreach($insertbySP->result() as $rowX2){}
				
				# run procedure	
				if($rowX2->stat){
					# get nomor BPS from query below
					$querySelectBPS = "select * from TOTBPS where NO_REG = '".$_POST['noTS']."' and NO_BPB = '".$_POST['noBPB']."' and TGL = '".$your_date."';";
					$qSelectBPS = $this->db->query($querySelectBPS);
					if($qSelectBPS->num_rows() > 0){
						$noBPS = null;
						foreach($qSelectBPS->result() as $row){
							$noBPS = $row->NOMOR;
						}
							# insert BPB as detail per row
							$i = 1;
							$insertQueryData = "";
							foreach($_POST['selected'] as $row){
								#print_r($row);
								$insertQueryData .= "SELECT '".$noBPS."', '".$your_date."', '".sprintf("%02d", $i)."', '".$row['KODE']."', '".$row['QTY']."', '".$row['SATUAN']."', '".$row['GUD']."' UNION ALL ";
								$i++;
							}
							$insertQueryData = rtrim($insertQueryData, " UNION ALL");
							$queryInsertDetailBPB = "INSERT INTO  ";
							if($this->db->query($queryInsertDetailBPB)){
								echo 1;
							}else{
								echo 0;
							}
						#}else{
							#echo "gagal update data TS (3).";
						#}
					}else{
						echo "Data BPS tidak di temukan (2).";
					}
				}else{
					echo "error saat menyimpan bon BPS (sp).";
				}
		}else{
			echo "Data tidak valid.";
		}
	}
	function formRealisasiSPK(){
		if($_POST){
			$data['dataTabel'] = $_POST['selected'];
			#var_dump($data['dataTabel']);
			#print_r($_POST['selected'][0]['NO_BPB']);
			//$data['dataBarang'] = $this->daftarRealisasiBahan($_POST['selected'][0]['NO_BPB']);
			$data['dataFoto'] = $this->dataFotoRealisasi($_POST['selected'][0]['NO_SPK']);
			$data['selectedYa'] = '';
			$data['selectedTidak'] = '';
			if ($_POST['selected'][0]['TUTUP'] == 1) {
				$data['selectedYa'] = 'selected';
				$data['selectedTidak'] = '';
			} else if (($_POST['selected'][0]['TUTUP'] == '0' && $_POST['selected'][0]['TGL_REALISASI'] != '') || $_POST['selected'][0]['TUTUP'] == '0' && $_POST['selected'][0]['TGL_BAYAR'] != '' ) {
				$data['selectedYa'] = '';
				$data['selectedTidak'] = 'selected';
			}
			
			$data['selectedBlm'] = '';
			
			$data['selectedMel'] = '';
			$data['selectedKop'] = '';
			$data['selectedDop'] = '';
			
			$data['selectedATK'] = '';
			$data['selectedRKs'] = '';
			$data['selectedTem'] = '';
			$data['selectedTBy'] = '';
			$data['selectedLai'] = '';
			
			switch($_POST['selected'][0]['REALISASI']) {
				case '1. Melepas meterx' : 		$data['selectedMel'] = 'selected'; break;
				case '2. Kopling' : 			$data['selectedKop'] = 'selected'; break;
				case '3. DOP' : 				$data['selectedDop'] = 'selected'; break;
				
				case '1. Alamat Tidak Ketemu' : $data['selectedATK'] = 'selected'; break;
				case '2. Rumah Kosong' : 		$data['selectedRKs'] = 'selected'; break;
				case '3. Tempo' : 				$data['selectedTem'] = 'selected'; break;
				case '4. Titip Bayar' : 		$data['selectedTBy'] = 'selected'; break;
				case '5. Lain-lain' : 			$data['selectedLai'] = 'selected'; break;
			}
			
			$view = $this->load->view('ts/formRealisasiSPK',$data,true);
			echo $view;
		}else{
			echo "Pilih daftar SPK yang akan di realisasi terlebih dahulu.";
		}
	}
	function daftarDiameter(){
		$q = $this->input->post('q');
		$query = $this->md_realisasiTS->ambilDiameter($q);
		echo json_encode($query->result());
	}
	function daftarPetugas(){
		$this->load->model('master_data/md_petugas');
		$q = $this->input->post('q');
		$query = $this->md_petugas->ambilPetugas('spc',$q);
		echo json_encode($query->result());
	}
	function daftarJenisMTR(){
		$q = $this->input->post('q');
		$query = $this->md_realisasiTS->ambilJenisMTR($q);
		echo json_encode($query->result());
	}
	function realisasiSPK(){
		if($_POST){
			$user_id = $this->session->userdata("login");
			$user_id = $user_id['nip'];
			$date = str_replace('/', '-', $_POST['tglRealisasi']);
			$newDate = date('Y-m-d', strtotime($date));
			$dataUpdate = array( );
			
			if ($query) {
				echo '1';
			} else {
				echo 'err';
			}
		}else{
			echo "underpass";
		}
	}
	function updateSegel($noSegel,$noRef,$noSegLama){
		
		
	}
	function cariNoSegel($pet=''){
		 
	}
	
	function dataFotoRealisasi($noSPK){
		 
	}
	
	function daftarRealisasiBahan($noBPB){
		
	}
	function daftarRealisasiBahan_OLD($noBPB){
		
	}
	
	function cetakSPK() {
		
		$this->load->view('ts/cetak_spk', $data);
	}
	
	function cetakSPK2() {
		
		$this->load->view('ts/cetak_spk_2', $data);
	}
	
	function cetakSPK3() {
		
		$this->load->view('ts/cetak_spk_2', $data);
	}
	
	public function getDataNosal() {
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */