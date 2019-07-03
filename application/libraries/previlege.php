<?php
class Previlege{
    protected $_ci;
    function __construct(){
        $this->_ci=&get_instance();
    }
	function check_access($allowed){
		if(!$this->_ci->session->userdata('login')){
			die("Sesi login berakhir. Mohon login kembali.");
		}else{
			$login = $this->_ci->session->userdata('login');
			$status = false;
			if($login['nip'] != "admin"){
				$query = $this->_ci->db->query("select u.nip, g.akses
												from ABT_USER u
												left join ABT_USER_GROUP g on g.id = u.id_user_group
												where u.nip = '".$login['nip']."' ;");
				
				if(($query->num_rows() > 0) && ($query->num_rows() < 2)){
					foreach($query->result() as $row){
						$akses = unserialize($row->akses);
						#print_r($akses);
						$tipeMenu = 0;
						switch($allowed['tipe']){
							case 'view' 	: {$tipeMenu = 0; break;}
							case 'insert' 	: {$tipeMenu = 1; break;}
							case 'update' 	: {$tipeMenu = 2; break;}
							case 'delete' 	: {$tipeMenu = 3; break;}
						}
						if(isset($akses[$allowed['id_menu']][$tipeMenu])){
							
							$status = true;
						}
						#echo "akses[".$allowed['id_menu']."][$tipeMenu]";
					}
				}
			}else{
				$status = true;
			}
			if(!$status){
				die('[HAK AKSES] : Anda tidak mempunyai ijin untuk mengakses fitur ini.');
			}
		}
    }
}
?>