<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_ts extends CI_Controller {
function __construct(){
    parent::__construct();
		$this->load->model('ts/md_orderTS');
		$this->load->model('master_data/md_desa');
		$this->load->model('master_data/md_buku');
		$this->load->model('master_data/md_petugas');
    }
	public function index(){
		$bag 	= array("1.03", "3.03");
		$kodJ	= substr($this->session->userdata('kode_jabatan'),0,4);
		if (in_array($kodJ,$bag)) {
			$this->viewOrderTS();
		} else {
			echo '<div style="padding:20px;color:red"> 
				  Maaf, Anda tidak memiliki hak akses pada menu ini.
				  </div>';
		}
	}
	function viewOrderTS(){
		$view = $this->load->view('ts/order_general',null,true);
		echo $view;
	}
	public function daftarOrderTS(){
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
		$filterDesa = isset($_POST['desa']) ? $_POST['desa'] : null;
		$filterBuku = isset($_POST['buku']) ? $_POST['buku'] : null;
		$filterPetugas = isset($_POST['petugas']) ? $_POST['petugas'] : null;
		$filterField = isset($_POST['field']) ? $_POST['field'] : null;
		$filterJadwal = isset($_POST['jadwal']) ? $_POST['jadwal'] : null;
		
		$rs = $this->md_orderTS->ambilDaftarOrderTS(null,null,"total",$filterDesa,$filterBuku,$filterPetugas,$filterJadwal,$filterField);
		$result["total"] = $rs;
		
		$query = $this->md_orderTS->ambilDaftarOrderTS($page,$rows,null,$filterDesa,$filterBuku,$filterPetugas,$filterJadwal,$filterField);
		$result["rows"] = $query;
		
		echo json_encode($result);
	}
	
	public function rekapPerDesaOrderTS(){
		$result["total"] = 0;
		
		$query = $this->md_orderTS->getRekapPerDesaOrderTS();
		// $result["rows"] = $query;
		
		$totOrd = 0;
		$totSpk = 0;
		$totByr = 0;
		$totTem = 0;
		$totSis = 0;
		foreach ($query->result() as $row) {
			$totOrd += $row->ORDERS;
			$totSpk += $row->SPK;
			$totByr += $row->BAYAR;
			$totTem += $row->TEMPO;
			$totSis += $row->SISA;
		}
		//echo json_encode($result);
		echo '{"total":1,"rows":'.json_encode($query->result()).',"footer":[
		{"KODE":"TOTAL","DESA":"","ORDERS":'.$totOrd.',"SPK":'.$totSpk.',"BAYAR":'.$totByr.',"TEMPO":'.$totTem.',"SISA":'.$totSis.'}
		]}';
	}
	
	public function rekapPerBukuOrderTS(){
		$desa = isset($_POST['desa']) ? intval($_POST['desa']) : '';
		$result["total"] = 0;
		
		$query = $this->md_orderTS->getRekapPerBukuOrderTS($desa);
		//$result["rows"] = $query;
		
		//echo json_encode($result);
		
		$totOrd = 0;
		$totSpk = 0;
		$totByr = 0;
		$totTem = 0;
		$totSis = 0;
		foreach ($query->result() as $row) {
			$totOrd += $row->ORDERS;
			$totSpk += $row->SPK;
			$totByr += $row->BAYAR;
			$totTem += $row->TEMPO;
			$totSis += $row->SISA;
		}
		//echo json_encode($result);
		echo '{"total":1,"rows":'.json_encode($query->result()).',"footer":[
		{"DESA":"TOTAL","NO_BUKU":"","PETUGAS":"","ORDERS":'.$totOrd.',"SPK":'.$totSpk.',"BAYAR":'.$totByr.',"TEMPO":'.$totTem.',"SISA":'.$totSis.',"JMLSPK":0,"SET":""}
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
				
				$qry = $this->db->query("update");
				
			}
			echo '1';
		}else{
			echo "Data tidak valid.";
		}
		
	}
	public function tesSP(){
		if($this->db->query("EXEC updateSPKBuka")){
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
				if($key['JMLSPK']>0 && trim($key['PETUGAS']) !='') { //tgl_tempo is null and 
					$query = $this->db->query("select top ".$key['JMLSPK']." nomor,desa,no_buku,nosal from tutupan where tgl_bayar is null and tgl_spk is null and tgl_realisasi is null
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
							
							$qry = $this->db->query("update ");
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
		
		$qry = $this->db->query("update  ");
		
		//echo $ptg.$desa.'~'.$buku;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
