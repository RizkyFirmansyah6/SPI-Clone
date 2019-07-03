<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekap_petugas_ts extends CI_Controller {
function __construct(){
    parent::__construct();
		$this->load->model('ts/Md_rekapPetugasTS');
		$this->load->model('master_data/md_desa');
		$this->load->model('master_data/md_buku');
		$this->load->model('master_data/md_petugas');
    }
	public function index(){
		$this->viewOrderTS();
	}
	function viewOrderTS(){
		$view = $this->load->view('ts/rekap_petugas',null,true);
		echo $view;
	}
	public function daftarOrderTS(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) :1000;
		$filterField = isset($_POST['field']) ? $_POST['field'] : null;
		$filterField2 = isset($_POST['field2']) ? $_POST['field2'] : null;
		$filterPetugas = isset($_POST['petugas']) ? $_POST['petugas'] : null;
		$filterTgl = isset($_POST['tgl']) ? $_POST['tgl'] : null;
		
		$rs = $this->Md_rekapPetugasTS->ambilDaftarOrderTS(null,null,"total",$filterPetugas,$filterTgl,$filterField,$filterField2);
		$result["total"] = $rs;
		
		$query = $this->Md_rekapPetugasTS->ambilDaftarOrderTS($page,$rows,null,$filterPetugas,$filterTgl,$filterField,$filterField2);
		$result["rows"] = $query;
		
		echo json_encode($result);
	}
	
	public function rekapPerPtgsTS(){
		$result["total"] = 0;
		
		$filterTglJdw = isset($_POST['tglJadwal']) ? $_POST['tglJadwal'] : null;
		$filterTglJdw = $filterTglJdw == null ? null : substr($filterTglJdw,6,4).'-'.substr($filterTglJdw,3,2).'-'.substr($filterTglJdw,0,2);	//27-04-2017
		$query = $this->Md_rekapPetugasTS->getRekapPerPtgsTS($filterTglJdw);
		// $result["rows"] = $query;
		
		$totSpk = 0;
		$totBhs = 0;
		$totGgl = 0;
		$totByr = 0;
		$totTem = 0;
		$totSis = 0;
		foreach ($query->result() as $row) {
			$totSpk += $row->SPK;
			$totBhs += $row->BERHASIL;
			$totGgl += $row->GAGAL;
			$totByr += $row->BAYAR;
			$totTem += $row->TEMPO;
			$totSis += $row->SISA;
		}
		//echo json_encode($result);
		echo '{"total":1,"rows":'.json_encode($query->result()).',"footer":[
		{"KODE":"KDPETUGAS","NMPETUGAS":"","SPK":'.$totSpk.',"BERHASIL":'.$totBhs.',"GAGAL":'.$totGgl.',"BAYAR":'.$totByr.',"TEMPO":'.$totTem.',"SISA":'.$totSis.'}
		]}';
	}
	
	public function rekapPerTglPtgsTS(){
		$petugas = isset($_POST['petugas']) ? $_POST['petugas'] : '';
		$field = isset($_POST['field']) ? $_POST['field'] : '';
		$filterTglJdw = isset($_POST['tglJadwal']) ? $_POST['tglJadwal'] : null;
		$filterTglJdw = $filterTglJdw == null ? null : substr($filterTglJdw,6,4).'-'.substr($filterTglJdw,3,2).'-'.substr($filterTglJdw,0,2);	//27-04-2017
		$result["total"] = 0;
		
		$query = $this->Md_rekapPetugasTS->getRekapPerBukuOrderTS($petugas,$field,$filterTglJdw);
		//$result["rows"] = $query;
		
		$totSpk = 0;
		$totBhs = 0;
		$totGgl = 0;
		$totByr = 0;
		$totTem = 0;
		$totSis = 0;
		foreach ($query->result() as $row) {
			$totSpk += $row->SPK;
			$totBhs += $row->BERHASIL;
			$totGgl += $row->GAGAL;
			$totByr += $row->BAYAR;
			$totTem += $row->TEMPO;
			$totSis += $row->SISA;
		}
		//echo json_encode($result);
		echo '{"total":1,"rows":'.json_encode($query->result()).',"footer":[
		{"KODE":"KDPETUGAS","NMPETUGAS":"","TGLSPK":"","SPK":'.$totSpk.',"BERHASIL":'.$totBhs.',"GAGAL":'.$totGgl.',"BAYAR":'.$totByr.',"TEMPO":'.$totTem.',"SISA":'.$totSis.'}
		]}';
	}
	
	public function daftarDesa(){
		$query = $this->md_desa->ambilDesaAll();
		echo json_encode($query->result());
	}
	public function daftarDesaByJdw($idJdw){
		$query = $this->md_desa->ambilDesaAllByJdw($idJdw);
		echo json_encode($query->result());
	}
	public function daftarBuku(){
		$query = $this->md_buku->ambilBukuAll();
		echo json_encode($query->result());
	}
	public function daftarPetugas(){
		$query = $this->md_petugas->ambilPetugas();
		echo json_encode($query->result());
	}
	public function daftarJadwalDesa(){
		$query = $this->md_desa->ambilJadwal();
		echo json_encode($query->result());
	}
	public function formBuatSPK(){
		if($_POST){
			
			$data = array();
			$data['dataTabel'] = $_POST['selected'];
			
			$view = $this->load->view('ts/formSPK',$data,true);
			echo $view;
		}else{
			echo "Pilih daftar TS yang akan di buatkan spk terlebih dahulu.";
		}
		
	}
	public function simpanSPK(){
		
		if($_POST){
			$date = $_POST['tgl'];
			$date = substr($date,6,4).'-'.substr($date,3,2).'-'.substr($date,0,2).' 00:00:00'; //04/03/2016
			$your_date = date("Y-m-d", strtotime($date)).date(" H:i:s");
			
			foreach($_POST['selected'] as $row){
				//if($this->db->query("EXEC updateSPKBukaSementara @nosal = N'".$row['NOSAL']."', @tglSPK = N'".$your_date."', @kdPetugas = N'".$_POST['pet']."';")){
				//	echo "1";
				//}else{
				//	echo "0";
				//}
				
				//var_dump($row); //SP\04\1512\RT0010035
				
				$qryLast	= $this->db->query("select top 1 no_spk from tutupan where left(no_spk,11) = 'SP\\04\\".date("ym")."\\' order by no_spk desc");
				$lastSP		= 0;
				if ($qryLast->num_rows() > 0)
				{
					$row1 	= $qryLast->row(); 
					$lastSP	= $row1->no_spk;
					$lastSP	= substr($lastSP,13,7);
				}
				$lastSP = $lastSP+1;
				
				if (strlen($lastSP)==1){
					$lastSP = '000000'.$lastSP;
				} else if (strlen($lastSP)==2){
					$lastSP = '00000'.$lastSP;
				} else if (strlen($lastSP)==3){
					$lastSP = '0000'.$lastSP;
				} else if (strlen($lastSP)==4){
					$lastSP = '000'.$lastSP;
				} else if (strlen($lastSP)==5){
					$lastSP = '00'.$lastSP;
				} else if (strlen($lastSP)==6){
					$lastSP = '0'.$lastSP;
				}
				$noSPK	= 'SP\\04\\'.date('ym').'\\RT'.$lastSP;
				
				$qry = $this->db->query("update tutupan set no_spk = '".$noSPK."', tgl_spk='".$date."', petugas='".$_POST['pet']."' where nosal='".$row['NOSAL']."' ");
				
			}
			echo '1';
		}else{
			echo "Data tidak valid.";
		}
		
	}
	public function tesSP(){
		if($this->db->query("EXEC updateSPKBukaSementara @nosal = N'133199', @tglSPK = N'2015-06-30 11:44:13', @kdPetugas = N'101010';")){
			echo "1";
		}else{
			echo "0";
		}
	}
	
	public function simpanPenjadwalan(){
		if($_POST){
			
			if (!isset($_POST['datebox']) || $_POST['datebox'] == '') {
				die('Mohon isi tanggal!');
			}
			
			$data = array();
			$data['dataTabel'] = $_POST['selected'];
			$ptg = '';
			$nosal = ''; $a='';
			//30-08-2016
			$tglSPK = $_POST['datebox'];
			$tglSPK = substr($tglSPK,6,4).'-'.substr($tglSPK,3,2).'-'.substr($tglSPK,0,2).' 00:00:00';
			foreach($data['dataTabel']['rows'] as $key){
				if($key['JMLSPK']>0 && trim($key['PETUGAS']) !='') {
					$query = $this->db->query("select top ".$key['JMLSPK']." nomor,desa,no_buku,nosal from tutupan where tgl_tempo is null and tgl_bayar is null and tgl_spk is null 
					and desa='".$key['DESA']."' and no_buku='".$key['NO_BUKU']."' ");
					if ($query->num_rows() > 0)
					{
						foreach ($query->result() as $row) {
							$qryLast	= $this->db->query("select top 1 no_spk from tutupan where left(no_spk,11) = 'SP\\04\\".date("ym")."\\' order by no_spk desc");
							$lastSP		= 0;
							if ($qryLast->num_rows() > 0)
							{
								$row1 	= $qryLast->row(); 
								$lastSP	= $row1->no_spk;
								$lastSP	= substr($lastSP,13,7);
							}
							$lastSP = $lastSP+1;
							
							if (strlen($lastSP)==1){
								$lastSP = '000000'.$lastSP;
							} else if (strlen($lastSP)==2){
								$lastSP = '00000'.$lastSP;
							} else if (strlen($lastSP)==3){
								$lastSP = '0000'.$lastSP;
							} else if (strlen($lastSP)==4){
								$lastSP = '000'.$lastSP;
							} else if (strlen($lastSP)==5){
								$lastSP = '00'.$lastSP;
							} else if (strlen($lastSP)==6){
								$lastSP = '0'.$lastSP;
							}
							$noSPK	= 'SP\\04\\'.date('ym').'\\RT'.$lastSP;
							
							$qry = $this->db->query("update tutupan set no_spk = '".$noSPK."', tgl_spk='".$tglSPK."', petugas='".$key['PETUGAS']."' where nosal='".$row->nosal."' ");
						}
					}					
				}
			}
			echo "Penjadwalan Berhasil";
		}else{
			echo "Penjadwalan GAGAL!";
		}
	}
	
	public function resetPenjadwalan(){
		$ptg 	= $_POST['ptg'];
		$desa 	= $_POST['desa'];
		$buku 	= $_POST['buku'];
		
		$qry = $this->db->query("update tutupan set no_spk = '', tgl_spk=null, petugas='' where petugas='".$ptg."' and desa='".$desa."' and no_buku='".$buku."' ");
		
		//echo $ptg.$desa.'~'.$buku;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
