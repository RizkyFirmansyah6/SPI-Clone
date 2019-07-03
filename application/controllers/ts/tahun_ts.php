<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tahun_ts extends CI_Controller {
function __construct(){
    parent::__construct();
		// $this->load->model('ts/md_orderTS');
		$this->load->model('master_data/md_tahun');
    }
	public function index(){
		$bag 	= array("1.01", "3.03");
		$kodJ	= substr($this->session->userdata('kode_jabatan'),0,4);
		if (in_array($kodJ,$bag)) {
			$this->viewTahunTS();
		} else {
			echo '<div style="padding:20px;color:red"> 
				  Maaf, Anda tidak memiliki hak akses pada menu ini.
				  </div>';
		}
	}
	function viewTahunTS(){
		$view = $this->load->view('ts/tahun_general',null,true);
		echo $view;
	}
	public function daftarTahun(){
		$result["total"] = 0;
		
		$query = $this->md_tahun->ambilTahun();
		// $result["rows"] = $query;
		//echo json_encode($result);
		echo '{"total":1,"rows":'.json_encode($query->result()).',"footer":[]}';
	}
	
	public function formTambahTahun(){
		$view = $this->load->view('ts/formTahun',null,true);
		echo $view;
	}
	public function tambahTahun(){
		
		if($_POST){
			$tahun = $_POST['tahun'];
			$this->md_tahun->tambahTahun($tahun);
			
			echo '1';
		}else{
			echo "Data tidak valid.";
		}
		
	}
	public function ubahTahun(){
		
		if($_POST){
			$kd = $_POST['kd'];
			$tahun = $_POST['tahun'];
			$this->md_tahun->ubahTahun($kd,$tahun);
			
			echo 'Data Berhasil Diubah';
		}else{
			echo "Data tidak valid.";
		}
		
	}
	public function hapusTahun(){
		
		if($_POST){
			$kd = $_POST['kd'];
			$this->md_tahun->hapusTahun($kd);
			
			echo 'Data Berhasil Dihapus';
		}else{
			echo "Data tidak valid.";
		}
		
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */