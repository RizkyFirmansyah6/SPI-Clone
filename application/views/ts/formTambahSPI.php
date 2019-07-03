<div class="easyui-layout" style="width:100%; min-height:100%; margin-bottom:5px;">
	<form id="formTambahSPI" class="easyui-form" method="post" data-options="">
		
		<div data-options="region:'north'" style="padding:4px;height:560px">
			<table width="100%" border="0" style="margin:10px">
				<tr>
					<td width="7%">Tahun : </td>
					<td width="5%"><input style="width: 80px" id="cbTahun" class="easyui-combobox" name="cbTahun" data-options="valueField:'Kd_Tahun',textField:'Tahun',url:'<?php echo base_url("index.php/ts/kelola_spi_ts/daftarTahun");?>'"></input></td>
					<td width="7%">Program : </td>
					<td width="5%"><input id="cbProgram" class="easyui-combobox" name="cbProgram" data-options="valueField:'Kd_Program',textField:'Nama_Program',url:'<?php echo base_url("index.php/ts/kelola_spi_ts/daftarProgram");?>'"></input></td>
					<td width="6%">Jenis : </td>
					<td width="5%"><input id="cbJenis" class="easyui-combobox" name="cbJenis" data-options="valueField:'Kd_Jenis',textField:'Nama_Jenis',url:'<?php echo base_url("index.php/ts/kelola_spi_ts/daftarJenis");?>'"></input></td>
					<td width="7%">Nomor : </td>
					<td><input style="width: 230px" class="easyui-textbox" id="txtNomor" readonly="true"></td>
				</tr>
			</table>
			<div class="easyui-tabs" style="width:100%;">
				<div title="RUANG LINGKUP" style="padding:10px">
					<table width="100%" border="0" cellpadding="2">
						<tr>
							<td width="20%">Obyek</td>
							<td><textarea style="max-width:100%; width:100%;" id="obyek" name="obyek"></textarea></td>
						</tr>
						<tr>
							<td>Ruang Lingkup</td>
							<td><textarea style="max-width:100%; width:100%;" id="ruang_lingkup" name="ruang_lingkup"></textarea></td>
						</tr>
						<tr>
							<td>Dasar Audit / Monev</td>
							<td><textarea style="max-width:100%; width:100%;" id="dasar" name="dasar"></textarea></td>
						</tr>
					</table>
					
					<!-- <hr style="width:100%;margin-top:40px;margin-bottom:40px;background-color:#79afe6;color:#79afe6" />
					
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
					</table>
					
					<input type="hidden" id="no_segel_lama" value="<?php echo $dataTabel[0]['NO_SEGEL']; ?>">
					<input type="hidden" id="validation" value="notOK"> -->
					
				</div>
				
				<div title="BAGIAN" style="padding:10px;" id="bagianTab">
					Bagian :
					<table>
						<tr>
							<td><input class="easyui-radiobutton" type="radio" name="select" value="select"> Select All</td>
							<td><input class="easyui-radiobutton" type="radio" name="select" value="diselect">Disellect All</td>
						</tr>
					</table>
					<?php $dataChk=$this->md_bagian->ambilBagian(); 
					$i=0;?>
					<table border="0">
						<tbody>
							<tr>
						<?php foreach ($dataChk->result() as $value){ ?>
							<?php $i++; ?>
								<td><input class="easyui-checkbox" type="checkbox" name="chkBag" value="<?php echo $value->Kd_Bag; ?>"><?php echo $value->Nama_Bag;?></td>
							<?php if($i == 2) {
								echo '</tr><tr>';
								$i = 0;
    						} ?>
						<?php } ?>
						</tr>
						</tbody>
					</table>
				</div>
				
				<div title="AUDITOR" style="padding:10px;" id="petaTab">
					<table border="0" width="60%">
						<tr>
							<td>Pengawas</td>
							<td>:</td>
							<td><input id="cbPengawas" style="width: 300px" class="easyui-combobox" name="cbPengawas" data-options="valueField:'No_PKPT',textField:'Nama',url:'<?php echo base_url("index.php/ts/kelola_spi_ts/daftarSemuaAuditor");?>'"></input></td>
							<td><input style="width: 60px" class="easyui-textbox" id="txtPengawas" readonly="true"></td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td><span id="nipPengawas"></span></td>
						</tr>
						<tr>
							<td>Ketua</td>
							<td>:</td>
							<td><input id="cbKetua" style="width: 300px" class="easyui-combobox" name="cbKetua" data-options="valueField:'No_PKPT',textField:'Nama',url:'<?php echo base_url("index.php/ts/kelola_spi_ts/daftarSemuaAuditor");?>'"></input></td>
							<td><input style="width: 60px" class="easyui-textbox" id="txtKetua" readonly="true"></td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td><span id="nipKetua"></span></td>
						</tr>
						<?php $anggota=1; ?>
					</table>
				</div>
			</div>
			<div style="text-align:center;margin-top:20px;">
				<a href="#" class="easyui-linkbutton" id="simpanBtn" iconCls="icon-ok" onclick="checkSimpanRealisasiSPK()">SIMPAN</a>
				<a href="#" class="easyui-linkbutton c5" iconCls="icon-cancel" onclick="$('#jendelaBuatProgramTahunan').window('close')">BATAL</a>
			</div>
		</div>
	</form>
</div>
<div id="piihBPB"></div>
<script type="text/javascript">
var nomor = "";
$(function(){
	$("#cbTahun").combobox({
    	onChange:function(){
    		nomor += $("#cbTahun").combobox('getText');
    		nomor += '/00/';
        	$("#txtNomor").textbox('setValue',nomor);
    	}
	});
	$("#cbProgram").combobox({
    	onChange:function(){
        	nomor += $("#cbProgram").combobox('getText');
    		nomor += '/';
        	$("#txtNomor").textbox('setValue',nomor);
    	}
	});
	$("#cbJenis").combobox({
    	onChange:function(){
    		nomor += $("#cbJenis").combobox('getText');
    		nomor += '/00';
        	$("#txtNomor").textbox('setValue',nomor);
    	}
	});
	$("input:radio[name='select']").change(function(){
        var flag = $(this).val();
        if(flag == 'select'){
        	$('input:checkbox').prop('checked',true);
        }
        else{
        	$('input:checkbox').removeAttr('checked');
        }
    });
    $("#cbPengawas").combobox({
    	onChange:function(){
    		No_PKPT = $("#cbPengawas").combobox('getValue');
    		$.ajax({
				url			: "<?php echo base_url(); ?>"+"index.php/ts/kelola_spi_ts/ambilAuditorBy", 
				type		: "POST", 
				dataType	: "html",
				data		: {pkpt:No_PKPT},
				success: function(response){
					var auditor = JSON.parse(response);
					$("#txtPengawas").textbox('setValue',auditor[0].Index_Karyawan);
					$('#nipPengawas').html(auditor[0].NIP);
				},
				error: function(){
					alert('error');
				},
			});
    	}
	});
	$("#cbKetua").combobox({
    	onChange:function(){
    		No_PKPT = $("#cbKetua").combobox('getValue');
    		$.ajax({
				url			: "<?php echo base_url(); ?>"+"index.php/ts/kelola_spi_ts/ambilAuditorBy", 
				type		: "POST", 
				dataType	: "html",
				data		: {pkpt:No_PKPT},
				success: function(response){
					var auditor = JSON.parse(response);
					$("#txtKetua").textbox('setValue',auditor[0].Index_Karyawan);
					$('#nipKetua').html(auditor[0].NIP);
				},
				error: function(){
					alert('error');
				},
			});
    	}
	});
});

$(function(){
	
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
	
});
	// function simpanRealisasiBahan(kode,nama,pakai) {
	// 	var person = prompt("Pemakaian Bahan\n["+kode+"] "+nama, pakai);
		
	// 	if (person != "") {
	// 		alert(person);
	// 	}else{
	// 		alert("Tidak boleh kosong");
	// 	}
	// }
	// function checkSimpanRealisasiSPK(){
	// 	$("#validation").val("notOK");
		
	// 	var petugas3 			= $("#formRealisasiSPK #comboPilihPetugas3").combogrid('getValue').trim();
	// 	var keteranganRealisasi = $("#formRealisasiSPK #keteranganRealisasi").val().trim();
	// 	var jenisRea 			= $("#formRealisasiSPK #jenisRealisasi").val().trim();
	// 	var pasang 				= $("#formRealisasiSPK #pasang_RSPK").val().trim();
	// 	var tanggal				= $("#formRealisasiSPK #tgl_RSPK").datebox('getValue').trim();
	// 	var stand				= $("#formRealisasiSPK #stand").textbox('getValue').trim();
	// 	var noSlag 				= $("#formRealisasiSPK #slag").textbox('getValue').trim();
	// 	var dim					= $("#formRealisasiSPK #diameter_RSPK").combogrid('getValue').trim();
	// 	var jenisMTR			= $("#formRealisasiSPK #jenisMeter").combogrid('getValue').trim();
	// 	var tglTempo			= $("#formRealisasiSPK #tglTempo").textbox('getValue').trim();
		
	// 	if (tanggal == "") {
	// 		alert("Tanggal Realisasi harus diisi!!");
	// 	} else {
	// 		if (pasang=="1") {
	// 			if (stand == "") {
	// 				alert("Stand Cabut harus diisi!!");
	// 			} else if (noSlag == "") {
	// 				alert("No Slag harus diisi!!");
	// 			} else if (dim == "") {
	// 				alert("Diameter harus diisi!!");
	// 			} else if (jenisMTR == "") {
	// 				alert("Jenis Meter harus diisi!!");
	// 			} else {
	// 				$("#validation").val("OK");
	// 			}
	// 		} else {
	// 			$("#validation").val("OK");
	// 		}
	// 	}
	// 	simpanRealisasiSPK();
	// }
	// function simpanRealisasiSPK(){
	// 	// var statusForm = true;
	// 	// $('#formRealisasiSPK').form('submit',{
	// 		// onSubmit:function(){
	// 			// statusForm = $(this).form('enableValidation').form('validate');
	// 			// return false;
				
	// 		// }
	// 	// });
	// 	// statusForm = true;
	// 	//if(statusForm){
	// 	var val = $("#validation").val();
	// 	if(val == "OK"){
	// 		// alert('bb');
	// 		var nomorTS 			= $("#formRealisasiSPK #nomorTS_RSPK").textbox('getValue');
	// 		var nosal 				= $("#formRealisasiSPK #nosal_RSPK").textbox('getValue');
	// 		var petugas3 			= $("#formRealisasiSPK #comboPilihPetugas3").combogrid('getValue');
	// 		var keteranganRealisasi = $("#formRealisasiSPK #keteranganRealisasi").val();
	// 		var jenisRea 			= $("#formRealisasiSPK #jenisRealisasi").combogrid('getValue');
	// 		var pasang 				= $("#formRealisasiSPK #pasang_RSPK").combogrid('getValue');
	// 		var tanggal				= $("#formRealisasiSPK #tgl_RSPK").datebox('getValue'); 
	// 		var stand				= $("#formRealisasiSPK #stand").textbox('getValue');
	// 		var noSlag 				= $("#formRealisasiSPK #slag").textbox('getValue');
	// 		var dim					= $("#formRealisasiSPK #diameter_RSPK").combogrid('getValue');
	// 		var jenisMTR			= $("#formRealisasiSPK #jenisMeter").combogrid('getValue');
	// 		// var noSeg				= $("#formRealisasiSPK #segel_RSPK").combogrid('getValue');
	// 		// var noSegLama			= $("#formRealisasiSPK #no_segel_lama").combogrid('getValue');
	// 		var tglTempo			= $("#formRealisasiSPK #tglTempo").textbox('getValue');
	// 		//alert(tglTempo);
			
	// 		$.ajax({
	// 			url			: "<?php echo base_url(); ?>"+"index.php/ts/realisasi_ts/realisasiSPK", 
	// 			type		: "POST", 
	// 			dataType	: "html",
	// 			data		: {noTS:nomorTS,nosalTS:nosal,petugas3TS:petugas3,ketRea:keteranganRealisasi,tglRealisasi:tanggal,stand:stand,noSlag:noSlag,diameter:dim,jenisMeter:jenisMTR,jenisRealisasi:jenisRea,pasang:pasang,tglTempo:tglTempo},
	// 			// data		: $("#formRealisasiSPK").serialize(),
	// 			beforeSend	: function(){
	// 				var win = $.messager.progress({
	// 					title:'Mohon tunggu',
	// 					msg:'Loading...'
	// 				});
	// 			},
	// 			success: function(response){
	// 				if(response==1){
	// 					$('#dgRealisasi').datagrid('reload');
	// 					$.messager.progress('close'); 
	// 					$('#jendelaRealisasiSPK').window('close');
	// 				}else{
	// 					alert("error ketika menyimpan realisasi");
	// 				}
	// 				// alert(response);
	// 				//$( "#results" ).text( response );
	// 				//alert(response);$.messager.progress('close');
	// 			},
	// 			error: function(){
	// 				alert('error');
	// 			},
	// 		});
	// 	}	
	// }
	
	// function changeOpt(val) {
	// 	$("#jenisRealisasi").empty();
	// 	if (val=="1") { 
	// 		var option = $("<option></option>").attr("value", "1. Melepas Meter").text("1. Melepas Meter");
	// 		$("#jenisRealisasi").append(option);
	// 		var option = $("<option></option>").attr("value", "2. Kopling").text("2. Kopling");
	// 		$("#jenisRealisasi").append(option);
	// 		var option = $("<option></option>").attr("value", "3. DOP").text("3. DOP");
	// 		$("#jenisRealisasi").append(option);
	// 	} else if (val=="0") {
	// 		var option = $("<option></option>").attr("value", "1. Alamat Tidak Ketemu").text("1. Alamat Tidak Ketemu");
	// 		$("#jenisRealisasi").append(option);
	// 		var option = $("<option></option>").attr("value", "2. Rumah Kosong").text("2. Rumah Kosong");
	// 		$("#jenisRealisasi").append(option);
	// 		var option = $("<option></option>").attr("value", "3. Tempo").text("3. Tempo");
	// 		$("#jenisRealisasi").append(option);
	// 		var option = $("<option></option>").attr("value", "4. Titip Bayar").text("4. Titip Bayar");
	// 		$("#jenisRealisasi").append(option);
	// 		var option = $("<option></option>").attr("value", "5. Lain-lain").text("5. Lain-lain");
	// 		$("#jenisRealisasi").append(option);
	// 	}
	// }
	
	// <?php
	// if (trim($dataTabel[0]['TGL_TEMPO']) != '') { 
	// 	echo  '$("#addingT").show();';
	// }
	// if (trim($dataTabel[0]['TGL_BAYAR']) != '') { 
	// 	echo  '
	// 		$("#addingB").show();
	// 		$("#simpanBtn").hide();
	// 	';
	// }
	// ?>
		
	// function show(val) {
	// 	$("#addingT").hide();
	// 	$("#addingB").hide();
	// 	if (val == "3. Tempo"){
	// 		$("#addingT").show();
	// 	} else if (val == "4. Titip Bayar") {
	// 		$("#addingB").show();
	// 	}
	// }
</script>