<html>
<body>
<div id='title' > </div>
<div id='content' > </div>
<?php

?>
<div class='isi_cetak' style='display:none'><?php echo $text; ?></div>
<div align='center' style='margin-top:45px'>please wait</div>

<script type="text/javascript" src="<?php echo base_url("dist/js/qz/deployJava.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("dist/js/qz/jquery-1.10.2.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("dist/js/qz/html2canvas.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("dist/js/qz/jquery.plugin.html2canvas.js"); ?>"></script>

<script type="text/javascript">
deployQZ();
printEPL();
	function deployQZ() {
		var attributes = {id: "qz", code:'<?php echo base_url("dist/js/qz/dist/qz.PrintApplet.class"); ?>', archive:'<?php echo base_url("dist/js/qz/dist/qz-print.jar"); ?>', width:1, height:1};
		var parameters = {jnlp_href: '<?php echo base_url("dist/js/qz/dist/qz-print_jnlp.jnlp"); ?>', cache_option:'plugin', disable_logging:'false', initial_focus:'false'};
		if (deployJava.versionCheck("1.7+") == true) {}
		else if (deployJava.versionCheck("1.6+") == true) {
			delete parameters['jnlp_href'];
		}
		deployJava.runApplet(attributes, parameters, '1.5');
	}
	
	function qzReady() {
		window["qz"] = document.getElementById('qz');
		// var title = document.getElementById("title");
		if (qz) {
			try {
				// title.innerHTML = title.innerHTML + " " + qz.getVersion();
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
		}else{
			//alert("berhasil");
			//close();
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
	
	function chr(i) {
		return String.fromCharCode(i);
	} 
	
	function printEPL() {
		qz.findPrinter();
		qz.append(chr(27) + chr(69)+"\r");
		qz.append($(".isi_cetak").html());     
		qz.print();
		
		//window.close();
	}
	
	
	
</script>
</body>
</html>
