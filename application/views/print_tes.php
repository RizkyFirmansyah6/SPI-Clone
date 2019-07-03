<?php
		$pejabat_spk['jab_manajer'] = "bapak /ibu manager";
		$pejabat_spk['nama_manajer'] = "Drs. Manajer terhormat";
		$pejabat_spk['jab_asman'] = "ass istand manager";
		$pejabat_spk['nama_asman'] = "Assistant Manager,S.kom";
		
		$detail_spk = array(
							"nama"=>"nama pelanggan",
							"nama_p"=>"nama pelanggan pelapor",
							"alamat"=>"alamat pel",
							"alamat_p"=>"alamat pel pelapor",
							"spk"=>"SP\04\1506\0003",
							"time_input"=>"04/05/2015 08:31:06",
							"nomor"=>"BS\04\1505\0010",
							"nosal"=>"142122",
							"petugas_1"=>"10231",
							"petugas_2"=>"",
							"petugas_3"=>"",
							"desa"=>"503",
							"no_buku"=>"024",
							"jenis"=>"--",
							"ket_order"=>"keterangan order spk",
							"tgl_order"=>"2015-05-04 00:00:00",
							"isi_order"=>"ini isi order spk",
							"respon"=>"ini respon spk",
							"telp_p"=>"087654345678943"
							);
		
		$arr_manager=explode(" ",$pejabat_spk['jab_manajer']);
		$arr_asman=explode(" ",$pejabat_spk['jab_asman']);
		
		$manajer1=$arr_manager[0];
		$manajer2='';
		for($i=1;$i<count($arr_manager);$i++){
			$manajer2.=$arr_manager[$i]." ";
		}
		
		$asman1=$arr_asman[0]." ".$arr_asman[1];
		$asman2='';
		for($i=2;$i<count($arr_asman);$i++){
			$asman2.=$arr_asman[$i]." ";
		}
		
		
		$nama='';
		$alamat='';
		if($detail_spk['nama']<>''){
		$nama=$detail_spk['nama'];
		$alamat=$detail_spk['alamat'];
		}else{
		$nama=$detail_spk['nama_p'];
		$alamat=$detail_spk['alamat_p'];
		}
		
		
		
		$Data='';
		/*1*/$Data.= "\n"; 
		/*2*/$Data.= "                                             ".str_pad($detail_spk['spk'],26," ",STR_PAD_LEFT)."\n"; 
		/*3*/$Data.= "\n"; 
		/*4*/$Data.= "       ".str_pad($detail_spk['time_input'],19," ",STR_PAD_LEFT)."\n"; 
		/*5*/$Data.= "\n"; 
		/*6*/$Data.= "\n"; 
		/*7*/$Data.= "       ".str_pad($detail_spk['nomor'],20," ",STR_PAD_LEFT)."        ".str_pad($detail_spk['nosal'],12," ",STR_PAD_RIGHT)." ".$detail_spk['petugas_1']."\n";  
		/*8*/$Data.= "                ".str_pad($nama,30," ",STR_PAD_RIGHT)."  ".str_pad($detail_spk['petugas_2'],23," ",STR_PAD_RIGHT)."\n";  
		/*9*/$Data.= "                                                ".$detail_spk['petugas_3']."\n";  
		
		$almt=trim($alamat);
		$baris=ceil(strlen($almt)/30);
		
		$offset=0;
		for($i=1;$i<=$baris;$i++){
			
			if($i==1){
				/*10*/$Data.= "               ".str_pad(substr($almt,0,30),30," ",STR_PAD_RIGHT)."\n";  
		
			}else{
				/*11*/$Data.= "               ".str_pad(substr($almt,$offset,30),30," ",STR_PAD_RIGHT)."\n";  
			}
			$offset+=30;
		}
		
		if($baris==1){
			/*11*/$Data.= "\n"; 	
		}
		
		/*12*/$Data.= "               ".str_pad($detail_spk['desa'].'-'.$detail_spk['no_buku'].' TELP: '.$detail_spk['telp_p'],30," ",STR_PAD_RIGHT)."   ".str_pad('SEGEL ID :',23," ",STR_PAD_RIGHT)."\n";  
		/*13*/$Data.= "               ".str_pad($detail_spk['jenis'].'-'.$detail_spk['ket_order'],30," ",STR_PAD_RIGHT)."   ".str_pad('TEKANAN :',23," ",STR_PAD_RIGHT)."\n";  
		/*14*/$Data.= "               ".str_pad(" ",30," ",STR_PAD_RIGHT)."   ".str_pad('REKONDISI :',23," ",STR_PAD_RIGHT)."\n";  
		 
		/*15*/$Data.= "PELAPOR        ".str_pad($detail_spk['nama_p'],30," ",STR_PAD_RIGHT)."\n";  
		/*16*/$Data.= "\n";  
		/*17*/$Data.= str_pad($detail_spk['tgl_order'],24," ",STR_PAD_BOTH).str_pad(" ",24," ",STR_PAD_RIGHT).str_pad(" ",24," ",STR_PAD_RIGHT)."\n";  
		/*18*/$Data.= "\n";  
		
		$keluhan=substr(trim($detail_spk['isi_order']),0,200);
		$baris=ceil(strlen($keluhan)/50);
		
		$offset=0;
		for($i=1;$i<=$baris;$i++){
			
			if($i==1){
				/*10*/$Data.= str_pad(substr($keluhan,0,50),50," ",STR_PAD_RIGHT)."\n";  
		
			}else{
				/*10*/$Data.= str_pad(substr($keluhan,$offset,50),50," ",STR_PAD_RIGHT)."\n";  
			}
			$offset+=50;
		}
		
		if($baris<=3){
			for($j=0;$j<3-$baris;$j++){
			$Data.="\n";
			}
		}
		
		$respon=substr(trim($detail_spk['respon']),0,80);
		$Data.= str_pad((trim($respon)),80," ",STR_PAD_RIGHT)."\n";
		
		/*23*/$Data.=str_pad(date('d-m-Y H:i:s'),72," ",STR_PAD_LEFT)."\n"; 
		/*24*/$Data.= "\n"; 
		/*25*/$Data.="                 ".str_pad(trim($manajer1),20," ",STR_PAD_BOTH).str_pad(trim($asman1),20," ",STR_PAD_BOTH)."\n";  
		/*26*/$Data.="                 ".str_pad(trim($manajer2),20," ",STR_PAD_BOTH).str_pad(trim($asman2),20," ",STR_PAD_BOTH)."\n";  
		/*27*/$Data.= "\n";  
		/*28*/$Data.= "\n";  
		/*29*/$Data.= "\n"; 
		/*30*/$Data.="                 ".str_pad(trim($pejabat_spk['nama_manajer']),20," ",STR_PAD_BOTH).str_pad(trim($pejabat_spk['nama_asman']),20," ",STR_PAD_BOTH)."\n";  
		/*31*/$Data.= "\n"; 
		/*32*/$Data.= "\n"; 
		/*33*/$Data.= "\n"; 
		
		
		echo "<div class='isi_cetak' style='display:none'>".$Data."</div>";	
		echo "<div align='center' style='margin-top:45px'><img src='".base_url()."/asset/img/printer.gif"."'/></div>";
?>
<div id="tempat_text" style="width:1px; height:1px; overflow:hidden"><?php echo $Data?></div>
<script type="text/javascript" src="<?php echo base_url("dist/qz/js/deployJava.js")?>"></script>
<script type="text/javascript" src="<?php echo base_url("dist/qz/js/jquery-1.10.2.js")?>"></script>
<script type="text/javascript" src="<?php echo base_url("dist/qz/js/html2canvas.js")?>"></script>
<script type="text/javascript" src="<?php echo base_url("dist/qz/js/jquery.plugin.html2canvas.js")?>"></script>
<script type="text/javascript">
deployQZ();
printEPL();

	function deployQZ() {
		var attributes = {id: "qz", code:'<?php echo base_url("dist/qz/dist/qz.PrintApplet.class")?>', archive:'<?php echo base_url("dist/qz/dist/qz-print.jar")?>', width:1, height:1};
		var parameters = {jnlp_href: '<?php echo base_url("dist/qz/dist/qz-print_jnlp.jnlp")?>', cache_option:'plugin', disable_logging:'false', 
			initial_focus:'false'};
		if (deployJava.versionCheck("1.7+") == true) {}
		else if (deployJava.versionCheck("1.6+") == true) {
			delete parameters['jnlp_href'];
		}
		deployJava.runApplet(attributes, parameters, '1.5');
	}
	
	function qzReady() {
		window["qz"] = document.getElementById('qz');
		var title = document.getElementById("title");
		if (qz) {
			try {
				title.innerHTML = title.innerHTML + " " + qz.getVersion();
				document.getElementById("content").style.background = "#F0F0F0";
			} catch(err) { // LiveConnect error, display a detailed meesage
				document.getElementById("content").style.background = "#F5A9A9";
				alert("ERROR:  \nThe applet did not load correctly.  Communication to the " + 
					"applet has failed, likely caused by Java Security Settings.  \n\n" + 
					"CAUSE:  \nJava 7 update 25 and higher block LiveConnect calls " + 
					"once Oracle has marked that version as outdated, which " + 
					"is likely the cause.  \n\nSOLUTION:  \n  1. Update Java to the latest " + 
					"Java version \n          (or)\n  2. Lower the security " + 
					"settings from the Java Control Panel.");
		  }
	  }
	}
	function notReady() {
		if (!isLoaded()) {
			return true;
		}
		else if (!qz.getPrinter()) {
			alert('Please select a printer first by using the "Detect Printer" button.');
			return true;
		}
		return false;
	}
	
	function isLoaded() {
		if (!qz) {
			alert('Error:\n\n\tPrint plugin is NOT loaded!');
			return false;
		} else {
			try {
				if (!qz.isActive()) {
					alert('Error:\n\n\tPrint plugin is loaded but NOT active!');
					return false;
				}
			} catch (err) {
				alert('Error:\n\n\tPrint plugin is NOT loaded properly!');
				return false;
			}
		}
		return true;
	}
	
	function qzDonePrinting() {
		if (qz.getException()) {
			alert('Error printing:\n\n\t' + qz.getException().getLocalizedMessage());
			qz.clearException();
			return; 
		}
	}
	
	function findPrinters() {
		if (isLoaded()) {
			qz.findPrinter('\\{bogus_printer\\}');
			window['qzDoneFinding'] = function() {
				var printers = qz.getPrinters().split(',');
				for (i in printers) {
					alert(printers[i] ? printers[i] : 'Unknown');      
				}
				window['qzDoneFinding'] = null;
			};
		}
	}
	function printEPL() {
		qz.findPrinter();
		qz.append('\n');
		qz.append($("#tempat_text").html());       
		qz.print();
	 }
</script>