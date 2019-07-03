<html>
<head><title>QZ Print Plugin</title>
<script type="text/javascript" src="js/deployJava.js"></script>
<script type="text/javascript">
deployQZ();
	function deployQZ() {
		var attributes = {id: "qz", code:'dist/qz.PrintApplet.class', 
			archive:'dist/qz-print.jar', width:1, height:1};
		var parameters = {jnlp_href: 'dist/qz-print_jnlp.jnlp', 
			cache_option:'plugin', disable_logging:'false', 
			initial_focus:'false'};
		if (deployJava.versionCheck("1.7+") == true) {}
		else if (deployJava.versionCheck("1.6+") == true) {
			delete parameters['jnlp_href'];
		}
		deployJava.runApplet(attributes, parameters, '1.5');
	}
	
	function qzReady() {
		// Setup our global qz object
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
	
	/**
	* Returns whether or not the applet is not ready to print.
	* Displays an alert if not ready.
	*/
	function notReady() {
		// If applet is not loaded, display an error
		if (!isLoaded()) {
			return true;
		}
		// If a printer hasn't been selected, display a message.
		else if (!qz.getPrinter()) {
			alert('Please select a printer first by using the "Detect Printer" button.');
			return true;
		}
		return false;
	}
	
	/**
	* Returns is the applet is not loaded properly
	*/
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
	
	/**
	* Automatically gets called when "qz.print()" is finished.
	*/
	function qzDonePrinting() {
		// Alert error, if any
		if (qz.getException()) {
			alert('Error printing:\n\n\t' + qz.getException().getLocalizedMessage());
			qz.clearException();
			return; 
		}
		
		// Alert success message
		// alert('Successfully sent print data to "' + qz.getPrinter() + '" queue.');
	}
	
	function findPrinters() {
		if (isLoaded()) {
			// Searches for a locally installed printer with a bogus name
			qz.findPrinter('\\{bogus_printer\\}');
			
			// Automatically gets called when "qz.findPrinter()" is finished.
			window['qzDoneFinding'] = function() {
				// Get the CSV listing of attached printers
				var printers = qz.getPrinters().split(',');
				for (i in printers) {
					alert(printers[i] ? printers[i] : 'Unknown');      
				}
				
				// Remove reference to this function
				window['qzDoneFinding'] = null;
			};
		}
	}
	function printEPL() {
		qz.findPrinter();
		qz.append('\nPerusahaan Daerah Air Minum Kota Malang\n');
		qz.append('  Jalan Terusan Danau Sentani No.100\n');
		qz.append(' Telp.(0341)715103, Fax.(0341).715107\n');
		qz.append('---------------------------------------\n');
		qz.append('Perusahaan Daerah Air Minum Kota Malang\n');
		qz.append('  Jalan Terusan Danau Sentani No.100\n');
		qz.append(' Telp.(0341)715103, Fax.(0341).715107\n');
		qz.append('---------------------------------------\n');
		qz.append('Perusahaan Daerah Air Minum Kota Malang\n');
		qz.append('  Jalan Terusan Danau Sentani No.100\n');
		qz.append(' Telp.(0341)715103, Fax.(0341).715107\n');
		qz.append('---------------------------------------\n');          
		qz.print();
	 }
</script>
	<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="js/html2canvas.js"></script>
	<script type="text/javascript" src="js/jquery.plugin.html2canvas.js"></script>
	</head>
	<body id="content" bgcolor="#FFF380">
	<div style="position:absolute;top:0;left:5;"><h1 id="title">QZ Print Plugin</h1></div><br /><br /><br />
    <input type="button" onClick="useDefaultPrinter()" value="Use Default Printer"></br>
    <input type="button" onClick="printEPL()" value="Print EPL" />
    </body>
</html>