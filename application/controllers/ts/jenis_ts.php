<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_ts extends CI_Controller {
function __construct(){
    parent::__construct();
		// $this->load->model('ts/md_orderTS');
		$this->load->model('master_data/md_jenis');
    }
	public function index(){
		$bag 	= array("1.01", "3.03");
		$kodJ	= substr($this->session->userdata('kode_jabatan'),0,4);
		if (in_array($kodJ,$bag)) {
			$this->viewJenisTS();
		} else {
			echo '<div style="padding:20px;color:red"> 
				  Maaf, Anda tidak memiliki hak akses pada menu ini.
				  </div>';
		}
	}
	function viewJenisTS(){
		$view = $this->load->view('ts/jenis_general',null,true);
		echo $view;
	}

	public function daftarJenis(){
		$result["total"] = 0;
		
		$query = $this->md_jenis->ambilJenis();
		// $result["rows"] = $query;
		//echo json_encode($result);
		echo '{"total":1,"rows":'.json_encode($query->result()).',"footer":[]}';
	}
	
	public function formTambahJenis(){
		$view = $this->load->view('ts/formJenis',null,true);
		echo $view;
	}

	public function tambahJenis(){
		
		if($_POST){
			$jenis = $_POST['jenis'];
			$this->md_jenis->tambahJenis($jenis);
			
			echo '1';
		}else{
			echo "Data tidak valid.";
		}
		
	}

	public function ubahJenis(){
		
		if($_POST){
			$kd = $_POST['kd'];
			$nama = $_POST['nama'];
			$this->md_jenis->ubahJenis($kd,$nama);
			
			echo 'Data Berhasil Diubah';
		}else{
			echo "Data tidak valid.";
		}
		
	}

	public function hapusJenis(){
		
		if($_POST){
			$kd = $_POST['kd'];
			$this->md_jenis->hapusJenis($kd);
			
			echo 'Data Berhasil Dihapus';
		}else{
			echo "Data tidak valid.";
		}
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
