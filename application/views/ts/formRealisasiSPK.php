<div class="easyui-layout" style="width:100%; min-height:100%; margin-bottom:5px;">
	<form id="formRealisasiSPK" class="easyui-form" method="post" data-options="">
		
		<div data-options="region:'north'" style="padding:4px;height:560px">
			<div class="easyui-tabs" style="width:100%;">
				<div title="DATA REALISASI" style="padding:10px">
					<table width="100%" border="0" cellpadding="2">
						<tr>
							<td width="15%">No. Sal</td> <!--data-options="readonly:true"-->
							<td width="35%"><input class="easyui-textbox" type="text" id="nosal_RSPK" name="nosal_RSPK"  value="<?php echo $dataTabel[0]['NOSAL']; ?>" style="height:26px; width:100%;" onkeyup="alert('ok')"></td>
							<td width="15%">No. Reg</td>
							<td width="35%"><input class="easyui-textbox" type="text" name="nomorTS_RSPK" id="nomorTS_RSPK" data-options="readonly:true" value="<?php echo $dataTabel[0]['NOMOR']; ?>" style="height:26px; width:100%;"></td>
						</tr>
						<tr>
							<td>Tanggal Realisasi</td>
							<td><input class="easyui-datebox" style="width:100%; height:28px;" id="tgl_RSPK" value="<?php echo $dataTabel[0]['TGL_REALISASI']; ?>"></td>
							<td>Tanggal SPK</td>
							<td><input class="easyui-textbox" type="text" data-options="readonly:true" style="width:100%; height:28px;" id="tglJadwal" value="<?php echo $dataTabel[0]['TGL_SPK']; ?>"></td>
						</tr>
						<tr>
							<td>Berhasil?</td>
							<td colspan="3">
								<input id="pasang_RSPK" name="pasang_RSPK" style="width:100px; height:28px;">
								
							</td>
						</tr>
						<tr>
							<td>Realisasi</td>
							<td colspan="3">
								<input id="jenisRealisasi" name="jenisRealisasi" style="width:175px; height:28px;">
								
								<span id="addingT" style="display:none;">Tgl Tempo <input class="easyui-datebox" style="height:24px;width:100px; border:1px #79afe6 solid; border-radius:2px;" id="tglTempo" value="<?php echo $dataTabel[0]['TGL_TEMPO']; ?>"></span>
								<span id="addingB" style="display:none;">Tgl Bayar <input class="easyui-textbox" id="tglBayar" style="background-color: red; height:24px;width:100px; border:1px #79afe6 solid; border-radius:2px;" data-options="readonly:true" READONLY value="<?php echo $dataTabel[0]['TGL_BAYAR']; ?>"></span>
							</td>
						</tr>
						<tr>
							<td>Petugas</td>
							<td colspan="3"><input id="comboPilihPetugas3" name="petugas3" style="width:400px; height:28px;"></input></td>
						</tr>
						<tr>
							<td valign="top">Keterangan</td>
							<td colspan="3"><textarea style="max-width:100%; width:100%;" id="keteranganRealisasi" name="keteranganRealisasi"><?php echo $dataTabel[0]['KETERANGAN']; ?></textarea></td>
						</tr>
					</table>
					
					<hr style="width:100%;margin-top:40px;margin-bottom:40px;background-color:#79afe6;color:#79afe6" />
					
					<table width="100%" border="0" cellpadding="2">
						<tr>
							<td width="15%">Stand Cabut</td>
							<td width="35%"><input class="easyui-textbox" type="text" id="stand" name="stand" value="<?php echo $dataTabel[0]['STAND']; ?>" style="height:28px; width:100px;"></td>
							<td width="15%">Jenis Meter</td>
							<td width="35%"><input id="jenisMeter" name="jenisMeter" style="width:100px; height:28px;"></td>
						</tr>
						<tr>
							<td>No. Slag</td>
							<td><input class="easyui-textbox" type="text" id="slag" name="slag" value="<?php echo $dataTabel[0]['NO_SLAG']; ?>" style="height:28px; width:100px;"></td>
							<td>Diameter</td>
							<td><input id="diameter_RSPK" name="diameter_RSPK" style="width:100px; height:28px;"></td>
						</tr>
						<!--<tr>
							
							<td>No. Segel</td>
							<td><input class="easyui-textbox" type="text" id="segel_RSPK" name="segel_RSPK" style="height:28px; width:150px;">
								<input id="segel_RSPK" name="segel_RSPK" style="width:140px; height:28px;"></input>
								<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="cariSegel()"></a>
							</td>
						</tr>
						-->
					</table>
					
					<input type="hidden" id="no_segel_lama" value="<?php echo $dataTabel[0]['NO_SEGEL']; ?>">
					<input type="hidden" id="validation" value="notOK">
					
					<div style="text-align:center;margin-top:20px;">
						<a href="#" class="easyui-linkbutton" id="simpanBtn" iconCls="icon-ok" onclick="checkSimpanRealisasiSPK()">SIMPAN</a>
						<a href="#" class="easyui-linkbutton c5" iconCls="icon-cancel" onclick="$('#jendelaRealisasiSPK').window('close')">BATAL</a>
					</div>
				</div>
				
				<div title="FOTO REALISASI" style="padding:10px;text-align:center" id="fotoTab">
					<?php 
					if (count($dataFoto) == 0) { 
						echo '<i>-foto kosong-</i>';
					} else { 
						echo '<img width="470" src="http://10.10.30.2/api/assets/uploaded/'.$dataFoto[0]['path'].'">';
					}
					 ?>
				</div>
				
				<div title="PETA LOKASI" style="padding:10px;text-align:center" id="petaTab">
					<?php
					$convSPK = str_replace('\\','~',$dataTabel[0]['NO_SPK']);
					?>
					<iframe width="650" height="470" src="http://114.4.37.148/bukatutup/index.php/ts/laporan_ts/genMaps/<?php echo $convSPK; ?>"></iframe>
				</div>
			</div>
		</div>
	</form>
</div>
<div id="piihBPB"></div>
<script type="text/javascript">

$('#tglBayar').textbox().css('background-color:red');

$('#nosal_RSPK').textbox({
	icons: [{
		iconCls:'icon-search',
		handler: function(e){
			cari();
		}
	}]
})

function cari() {
	var response = 'aa';
	var nosal = $("#formRealisasiSPK #nosal_RSPK").textbox('getValue');
	$("#addingT").hide();
	$("#addingB").hide();
	$("#simpanBtn").show();
	
	$.ajax({
        type: "POST",
        url: "<?php echo base_url("index.php/ts/realisasi_ts/getDataNosal")?>",
        data: { nosal: nosal },
        success: function (response) {
			var str = response.split("~");
			var nomorTS	= $.trim(str[1]);
			var tglReal	= $.trim(str[2]);
			var tglJdw	= $.trim(str[3]);
			var status	= $.trim(str[4]);
			var jnsReal	= $.trim(str[5]);
			var petugas	= $.trim(str[6]);
			var ket		= $.trim(str[7]);
			var stand	= $.trim(str[8]);
			var jnsMtr	= $.trim(str[9]);
			var slag	= $.trim(str[10]);
			var diameter= $.trim(str[11]);
			var foto	= $.trim(str[12]);
			var lati	= $.trim(str[13]);
			var longi	= $.trim(str[14]);
			var tglTemp	= $.trim(str[15]);
			var tglByr	= $.trim(str[16]);
			var nospk	= $.trim(str[17]);
			
			if (nomorTS != '') {$("#formRealisasiSPK #nomorTS_RSPK").textbox('setValue',nomorTS);}	
			$("#formRealisasiSPK #tgl_RSPK").textbox('setValue',tglReal);
			if (tglJdw != '') {$("#formRealisasiSPK #tglJadwal").textbox('setValue',tglJdw);}		
			$('#formRealisasiSPK #pasang_RSPK').combobox('setValue', status);
			$('#formRealisasiSPK #jenisRealisasi').combobox('setValue', jnsReal);
			$('#formRealisasiSPK #comboPilihPetugas3').combogrid('setValue', petugas);
			$("#formRealisasiSPK #keteranganRealisasi").val(ket);
			$("#formRealisasiSPK #stand").textbox('setValue',stand);
			$("#formRealisasiSPK #jenisMeter").combobox('setValue',jnsMtr);
			$("#formRealisasiSPK #slag").textbox('setValue',slag);
			$("#formRealisasiSPK #diameter_RSPK").combobox('setValue',diameter);
			if (tglTemp != '') {$("#addingT").show();$("#formRealisasiSPK #tglTempo").textbox('setValue',tglTemp);}	
			if (tglByr != '') {$("#addingB").show();$("#formRealisasiSPK #tglbayar").textbox('setValue',tglByr);$("#simpanBtn").hide();}
			
			if (foto=='') {
				var dataF = '<i>-foto kosong-</i>';
			} else {
				var dataF = '<img width="470" src="http://10.10.30.2/api/assets/uploaded/'+foto+'">';
			}
			$("#fotoTab").html(dataF);
        },
        failure: function (response) {
			alert('Terjadi kesalahan!');
        }
    });
}

$(function(){

	// $('#segel_RSPK').combobox({
		// panelWidth:140,
		// url: "<?php echo base_url("index.php/ts/realisasi_ts/cariNoSegel/"); ?>",
		// valueField:'NO_URUT',
        // textField:'NO_URUT'
	// });
	
	// $("#segel_RSPK").append("<option value='<?php echo $dataTabel[0]['NO_SEGEL']; ?>'><?php echo $dataTabel[0]['NO_SEGEL']; ?></option>");
	
	$('#comboPilihPetugas3').combogrid({
		panelWidth:400,
		url: "<?php echo base_url("index.php/ts/realisasi_ts/daftarPetugas")?>",
		idField:'KODE',
		textField:'KETERANGAN',
		mode:'remote',
		fitColumns:true,
		columns: [[
			{field:'KODE',title:'KODE',width:80},
			{field:'GROUP_PETUGAS',title:'GROUP',width:80},
			{field:'KETERANGAN',title:'NAMA',width:150}
		]]
	});
	
	$('#pasang_RSPK').combobox({
		data: 	[{
					"id":0,
					"text":"Tidak"
				},{
					"id":1,
					"text":"Ya"
				}],
		valueField:'id',
		textField:'text',
		onChange:function(s){
			var status = $('#pasang_RSPK').combobox('getValue');
			if (status==1) {
				var arrData	= [{
							"text":"1. Melepas meter"
						},{
							"text":"2. Kopling"
						},{
							"text":"3. DOP"
						}];
			} else if (status==0) {
				var arrData	= [{
							"text":"1. Alamat Tidak Ketemu"
						},{
							"text":"2. Rumah Kosong"
						},{
							"text":"3. Tempo"
						},{
							"text":"4. Titip Bayar"
						},{
							"text":"5. Lain-lain"
						}];
			}
			$('#jenisRealisasi').combobox({
				data: arrData,
				valueField:'text',
				textField:'text'
			});
			var jnReal = $('#jenisRealisasi').combobox('getValue');
			if (jnReal == "3. Tempo") {
				$("#addingT").show();
			} else {
				$("#addingT").hide();
			}
		}
	});
	$('#pasang_RSPK').combobox('setValue', '<?php echo $dataTabel[0]['TUTUP']; ?>');
	
	$('#jenisRealisasi').combobox({
		data: [{
					"text":"1. Alamat Tidak Ketemu"
				},{
					"text":"2. Rumah Kosong"
				},{
					"text":"3. Tempo"
				},{
					"text":"4. Titip Bayar"
				},{
					"text":"5. Lain-lain"
				}],
		valueField:'text',
		textField:'text',
		onChange:function(s){
			var jnReal = $('#jenisRealisasi').combobox('getValue');
			if (jnReal == "3. Tempo") {
				$("#addingT").show();
			} else {
				$("#addingT").hide();
			}
		}
	});
	$('#jenisRealisasi').combobox('setValue', '<?php echo $dataTabel[0]['REALISASI']; ?>');
	
	$('#diameter_RSPK').combobox({
		url: "<?php echo base_url("index.php/ts/realisasi_ts/daftarDiameter")?>",
		valueField:'DIAMETER',
		textField:'DIAMETER'
	});
	$('#jenisMeter').combobox({
		url: "<?php echo base_url("index.php/ts/realisasi_ts/daftarJenisMTR")?>",
		valueField:'KODE',
		textField:'KODE'
	});
	$('.easyui-datebox').datebox({
		formatter : function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return (d<10?('0'+d):d)+'/'+(m<10?('0'+m):m)+'/'+y;
		},
		parser : function(s){

			if (!s) return new Date();
			var ss = s.split('/');
			var y = parseInt(ss[2],10);
			var m = parseInt(ss[1],10);
			var d = parseInt(ss[0],10);
			if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
				return new Date(y,m-1,d)
			} else {
				return new Date();
			}
		}
	});
	$('#comboPilihPetugas3').combogrid('setValue', '<?php echo $dataTabel[0]['PETUGAS']; ?>');
	$('#jenisMeter').combobox('setValue', '<?php echo $dataTabel[0]['JENIS_MTR']; ?>');
	$('#diameter_RSPK').combobox('setValue', '<?php echo $dataTabel[0]['DIAMETER']; ?>');
	//$('#segel_RSPK').combobox('setValue', '<?php echo $dataTabel[0]['NO_SEGEL']; ?>');
	
});
	
	function cariSegel(){
		/* var noSegel = $("#formRealisasiSPK #segel_RSPK").textbox('getValue');
		if(noSegel != ''){
			$.ajax({
				url			: "<?php echo base_url(); ?>"+"index.php/ts/realisasi_ts/cariNoSegel", 
				type		: "POST", 
				dataType	: "html",
				data		: {noseg:noSegel},
				beforeSend	: function(){
					var win = $.messager.progress({
						title:'Mohon tunggu',
						msg:'Mencari Nomor Segel'
					});
				},
				success: function(response){
					if(response){
						alert("Nomor segel valid.")
					}else{
						alert("Nomor segel tidak ditemukan.");
					}
					//$( "#results" ).text( response );
					$.messager.progress('close');
				},
				error: function(){
					alert('error');
				},
			});
		}else{
			alert('Isi kolom segel terlebih dahulu.')
		} */
		var kdPet = $('#comboPilihPetugas3').combogrid('getValue');
		//alert(kdPet);
		//$('#segel_RSPK').combogrid('reload', '<?php echo base_url("index.php/ts/order_ts/cariNoSegel/")?>'+kdPet);
		var g = $('#segel_RSPK').combogrid('grid');    // get the datagrid object
			g.datagrid('load', {
				q: $('#segel_RSPK').combogrid('getValue'),
				pet: kdPet
			});
		//alert("a");
	}
	function simpanRealisasiBahan(kode,nama,pakai) {
		var person = prompt("Pemakaian Bahan\n["+kode+"] "+nama, pakai);
		
		if (person != "") {
			alert(person);
		}else{
			alert("Tidak boleh kosong");
		}
	}
	function checkSimpanRealisasiSPK(){
		$("#validation").val("notOK");
		
		var petugas3 			= $("#formRealisasiSPK #comboPilihPetugas3").combogrid('getValue').trim();
		var keteranganRealisasi = $("#formRealisasiSPK #keteranganRealisasi").val().trim();
		var jenisRea 			= $("#formRealisasiSPK #jenisRealisasi").val().trim();
		var pasang 				= $("#formRealisasiSPK #pasang_RSPK").val().trim();
		var tanggal				= $("#formRealisasiSPK #tgl_RSPK").datebox('getValue').trim();
		var stand				= $("#formRealisasiSPK #stand").textbox('getValue').trim();
		var noSlag 				= $("#formRealisasiSPK #slag").textbox('getValue').trim();
		var dim					= $("#formRealisasiSPK #diameter_RSPK").combogrid('getValue').trim();
		var jenisMTR			= $("#formRealisasiSPK #jenisMeter").combogrid('getValue').trim();
		var tglTempo			= $("#formRealisasiSPK #tglTempo").textbox('getValue').trim();
		
		if (tanggal == "") {
			alert("Tanggal Realisasi harus diisi!!");
		} else {
			if (pasang=="1") {
				if (stand == "") {
					alert("Stand Cabut harus diisi!!");
				} else if (noSlag == "") {
					alert("No Slag harus diisi!!");
				} else if (dim == "") {
					alert("Diameter harus diisi!!");
				} else if (jenisMTR == "") {
					alert("Jenis Meter harus diisi!!");
				} else {
					$("#validation").val("OK");
				}
			} else {
				$("#validation").val("OK");
			}
		}
		simpanRealisasiSPK();
	}
	function simpanRealisasiSPK(){
		// var statusForm = true;
		// $('#formRealisasiSPK').form('submit',{
			// onSubmit:function(){
				// statusForm = $(this).form('enableValidation').form('validate');
				// return false;
				
			// }
		// });
		// statusForm = true;
		//if(statusForm){
		var val = $("#validation").val();
		if(val == "OK"){
			// alert('bb');
			var nomorTS 			= $("#formRealisasiSPK #nomorTS_RSPK").textbox('getValue');
			var nosal 				= $("#formRealisasiSPK #nosal_RSPK").textbox('getValue');
			var petugas3 			= $("#formRealisasiSPK #comboPilihPetugas3").combogrid('getValue');
			var keteranganRealisasi = $("#formRealisasiSPK #keteranganRealisasi").val();
			var jenisRea 			= $("#formRealisasiSPK #jenisRealisasi").combogrid('getValue');
			var pasang 				= $("#formRealisasiSPK #pasang_RSPK").combogrid('getValue');
			var tanggal				= $("#formRealisasiSPK #tgl_RSPK").datebox('getValue'); 
			var stand				= $("#formRealisasiSPK #stand").textbox('getValue');
			var noSlag 				= $("#formRealisasiSPK #slag").textbox('getValue');
			var dim					= $("#formRealisasiSPK #diameter_RSPK").combogrid('getValue');
			var jenisMTR			= $("#formRealisasiSPK #jenisMeter").combogrid('getValue');
			// var noSeg				= $("#formRealisasiSPK #segel_RSPK").combogrid('getValue');
			// var noSegLama			= $("#formRealisasiSPK #no_segel_lama").combogrid('getValue');
			var tglTempo			= $("#formRealisasiSPK #tglTempo").textbox('getValue');
			//alert(tglTempo);
			
			$.ajax({
				url			: "<?php echo base_url(); ?>"+"index.php/ts/realisasi_ts/realisasiSPK", 
				type		: "POST", 
				dataType	: "html",
				data		: {noTS:nomorTS,nosalTS:nosal,petugas3TS:petugas3,ketRea:keteranganRealisasi,tglRealisasi:tanggal,stand:stand,noSlag:noSlag,diameter:dim,jenisMeter:jenisMTR,jenisRealisasi:jenisRea,pasang:pasang,tglTempo:tglTempo},
				// data		: $("#formRealisasiSPK").serialize(),
				beforeSend	: function(){
					var win = $.messager.progress({
						title:'Mohon tunggu',
						msg:'Loading...'
					});
				},
				success: function(response){
					if(response==1){
						$('#dgRealisasi').datagrid('reload');
						$.messager.progress('close'); 
						$('#jendelaRealisasiSPK').window('close');
					}else{
						alert("error ketika menyimpan realisasi");
					}
					// alert(response);
					//$( "#results" ).text( response );
					//alert(response);$.messager.progress('close');
				},
				error: function(){
					alert('error');
				},
			});
		}	
	}
	
	function changeOpt(val) {
		$("#jenisRealisasi").empty();
		if (val=="1") { 
			var option = $("<option></option>").attr("value", "1. Melepas Meter").text("1. Melepas Meter");
			$("#jenisRealisasi").append(option);
			var option = $("<option></option>").attr("value", "2. Kopling").text("2. Kopling");
			$("#jenisRealisasi").append(option);
			var option = $("<option></option>").attr("value", "3. DOP").text("3. DOP");
			$("#jenisRealisasi").append(option);
		} else if (val=="0") {
			var option = $("<option></option>").attr("value", "1. Alamat Tidak Ketemu").text("1. Alamat Tidak Ketemu");
			$("#jenisRealisasi").append(option);
			var option = $("<option></option>").attr("value", "2. Rumah Kosong").text("2. Rumah Kosong");
			$("#jenisRealisasi").append(option);
			var option = $("<option></option>").attr("value", "3. Tempo").text("3. Tempo");
			$("#jenisRealisasi").append(option);
			var option = $("<option></option>").attr("value", "4. Titip Bayar").text("4. Titip Bayar");
			$("#jenisRealisasi").append(option);
			var option = $("<option></option>").attr("value", "5. Lain-lain").text("5. Lain-lain");
			$("#jenisRealisasi").append(option);
		}
	}
	
	<?php
	if (trim($dataTabel[0]['TGL_TEMPO']) != '') { 
		echo  '$("#addingT").show();';
	}
	if (trim($dataTabel[0]['TGL_BAYAR']) != '') { 
		echo  '
			$("#addingB").show();
			$("#simpanBtn").hide();
		';
	}
	?>
		
	function show(val) {
		$("#addingT").hide();
		$("#addingB").hide();
		if (val == "3. Tempo"){
			$("#addingT").show();
		} else if (val == "4. Titip Bayar") {
			$("#addingB").show();
		}
	}
</script>

