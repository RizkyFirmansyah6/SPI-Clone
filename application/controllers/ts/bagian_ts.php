<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bagian_ts extends CI_Controller {
function __construct(){
    parent::__construct();
		// $this->load->model('ts/md_orderTS');
		$this->load->model('master_data/md_bagian');
    }
	public function index(){
		$bag 	= array("1.01", "3.03");
		$kodJ	= substr($this->session->userdata('kode_jabatan'),0,4);
		if (in_array($kodJ,$bag)) {
			$this->viewBagianTS();
		} else {
			echo '<div style="padding:20px;color:red"> 
				  Maaf, Anda tidak memiliki hak akses pada menu ini.
				  </div>';
		}
	}
	function viewBagianTS(){
		$view = $this->load->view('ts/bagian_general',null,true);
		echo $view;
	}

	public function daftarBagian(){
		$result["total"] = 0;
		
		$query = $this->md_bagian->ambilBagian();
		// $result["rows"] = $query;
		//echo json_encode($result);
		echo '{"total":1,"rows":'.json_encode($query->result()).',"footer":[]}';
	}
	
	public function formTambahBagian(){
		$view = $this->load->view('ts/formBagian',null,true);
		echo $view;
	}

	public function tambahBagian(){
		
		if($_POST){
			$bagian = $_POST['bagian'];
			$this->md_bagian->tambahBagian($bagian);
			
			echo '1';
		}else{
			echo "Data tidak valid.";
		}
		
	}

	public function ubahBagian(){
		
		if($_POST){
			$kd = $_POST['kd'];
			$nama = $_POST['nama'];
			$this->md_bagian->ubahBagian($kd,$nama);
			
			echo 'Data Berhasil Diubah';
		}else{
			echo "Data tidak valid.";
		}
		
	}

	public function hapusBagian(){
		
		if($_POST){
			$kd = $_POST['kd'];
			$this->md_bagian->hapusBagian($kd);
			
			echo 'Data Berhasil Dihapus';
		}else{
			echo "Data tidak valid.";
		}
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */