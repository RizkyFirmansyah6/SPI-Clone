<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auditor_ts extends CI_Controller {
function __construct(){
    parent::__construct();
		// $this->load->model('ts/md_orderTS');
		$this->load->model('master_data/md_auditor');
    }
	public function index(){
		$bag 	= array("1.01", "3.03");
		$kodJ	= substr($this->session->userdata('kode_jabatan'),0,4);
		if (in_array($kodJ,$bag)) {
			$this->viewAuditorTS();
		} else {
			echo '<div style="padding:20px;color:red"> 
				  Maaf, Anda tidak memiliki hak akses pada menu ini.
				  </div>';
		}
	}
	function viewAuditorTS(){
		$view = $this->load->view('ts/auditor_general',null,true);
		echo $view;
	}
	public function daftarKaryawan(){
		$query = $this->md_auditor->ambilKaryawan();
		echo json_encode($query->result());
	}
	public function daftarAuditor(){
		$result["total"] = 0;
		
		$query = $this->md_auditor->ambilAuditor();
		// $result["rows"] = $query;
		//echo json_encode($result);
		echo '{"total":1,"rows":'.json_encode($query->result()).',"footer":[]}';
	}
	
	public function formTambahAuditor(){
		$view = $this->load->view('ts/formAuditor',null,true);
		echo $view;
	}
	public function tambahAuditor(){
		if($_POST){
			$no_pkpt = $_POST['no_pkpt'];
			$nip = $_POST['nip'];
			$this->md_auditor->tambahAuditor($no_pkpt,$nip);
			
			echo '1';
		}else{
			echo "Data tidak valid.";
		}
		
	}
	public function hapusAuditor(){
		
		if($_POST){
			$nopkpt = $_POST['nopkpt'];
			$this->md_auditor->hapusAuditor($nopkpt);
			
			echo 'Data Berhasil Dihapus';
		}else{
			echo "Data tidak valid.";
		}
		
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */