<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
set_time_limit(0);
ini_set('memory_limit', '200M');

class Download_csv extends CI_Controller {
	
	var $forbiddenMsg	= '<div align="center"><font color="red">Maaf, Anda tidak mempunyai hak akses untuk membuka menu ini.</div></font>';
	
	public function index() {}
	
	public function rekap_per_petugas()
	{
		$this->load->model('ts/Md_laporanTS');
				
		$filterPeriode = isset($_POST['periode']) ? $_POST['periode'] : date("Ym");
		$namaTabel = "tutupan";
		$queryCekTabel=$this->db->query("select * from INFORMATION_SCHEMA.TABLES where TABLE_NAME like 'tutupan_$filterPeriode%';");
		if($queryCekTabel->num_rows() > 0){$namaTabel = $namaTabel."_".$filterPeriode;}
		
		$query = $this->Md_laporanTS->getRekapPerPetugas($namaTabel,$filterPeriode);
			
		$data = array(
			'nama_file' => 'Laporan Rekap Per Petugas', 
			'content' 	=> 'LAPORAN REKAP PER PETUGAS

#;KODE PETUGAS;NAMA;PERIODE;SPK;TERBAYAR;R. KOPLING;R. LEPAS METER;R. DOP;TEMPO;SISA
'
		);

				
		if ($query->num_rows() > 0)
		{
			$i=0;
			foreach ($query->result_array() as $row )
			{
				$i++;
				$data['content']	.= $i.';';
				foreach ($row as $val) {
					$data['content']	.= $val.';';
				}
				$data['content']	.= '
';
			}
		}
		
		$this->load->view('download_csv_view', $data);
	}
	
	
}