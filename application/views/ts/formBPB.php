<div class="easyui-layout" style="width:100%; height:100%; margin-bottom:5px;">
	<form id="formBPB" class="easyui-form" method="post" data-options="">
		<div data-options="region:'north'" style="padding:4px; height:100px; max-height:100px; min-height:100px;">
			<div id="results"></div>
			<table width="100%">
				<tr align="right">
					<td>Nomor Bon Barang</td>
					<td><input class="easyui-textbox" type="text" name="noBPB" id="noBPB" data-options="readonly:true" value="<?php echo $dataTabel[0]['NO_BPB']; ?>" style="height:26px; width:100%;"></td>
					<td colspan="4"></td>
				</tr>
				<tr align="right">
					<td>Nomor</td>
					<td width="20%"><input class="easyui-textbox" type="text" data-options="disabled:true" value="[otomatis]" style="height:26px; width:100%;"></td>
					<td>No. Reg</td>
					<td width="20%"><input class="easyui-textbox" type="text" name="nomorBS" id="nomorBS" data-options="readonly:true" value="<?php echo $dataTabel[0]['NOMOR']; ?>" style="height:26px; width:100%;"></td>
					<td>Vendor</td>
					<td width="20%"><input class="easyui-textbox" type="text" id="comboPilihVendor" name="vendor" data-options="readonly:true" style="width:100%; height:26px;" value="132"></input><!--<input id="comboPilihVendor" name="vendor" data-options="required:true" style="width:100%; height:26px;"></input>--></td>
				</tr>
				<tr align="right">
					<td>Tanggal</td>
					<td width="20%"><input class="easyui-textbox" type="text" data-options="readonly:true" value="<?php echo date('d/m/Y');?>" style="height:26px; width:100%;"></td>
					<td>No. Saluran</td>
					<td width="20%"><input class="easyui-textbox" type="text" id="nosal" name="nosal" data-options="readonly:true" value="<?php echo $dataTabel[0]['NOSAL']; ?>" style="height:26px; width:100%;"></td>
					<td>No. Form</td>
					<td width="20%"><input class="easyui-textbox" type="text" id="noForm" name="noForm" data-options="width:'100%'" style="height:26px;" /></td>
				</tr>
			</table>
		</div>
		<div data-options="region:'center'" style="background-color:#fff;">
			<table id="dgFormBPB" style="width:100%;height:100%;" class="easyui-datagrid" rownumbers="true" data-options="toolbar:'#tbTambahBarangBPB',singleSelect:true">
				<thead>
					<tr>
						<th data-options="field:'KODE',width:80">KODE</th>
						<th data-options="field:'URAIAN',width:350">URAIAN</th>
						<th data-options="field:'UKURAN',width:80">UKURAN</th>
						<th data-options="field:'QTY',width:40">QTY</th>
						<th data-options="field:'SATUAN',width:80">SATUAN</th>
						<th data-options="field:'GUD',width:60">GUD</th>
					</tr>
				</thead>
			</table>
		 
			<div id="tbTambahBarangBPB" style="height:auto; padding:3px;">
				<a href="javascript:void(0)" class="easyui-linkbutton" onclick="tampilFormBarang()"><i class="fa fa-check" style="color:#27ae60"></i> Tambah Barang </a>
				<a href="javascript:void(0)" class="easyui-linkbutton" onclick="hapusBarisDPB()"><i class="fa fa-close" style="color:#e74c3c"></i> Hapus Barang </a>
			</div>
		</div>
		<div data-options="region:'south'" style="padding:4px; height:110px;">
			<div>
				<table width="100%">
					<tr>
						<td width="30%" valign="top">
							<div>Petugas</div>
							<input id="comboPilihPetugas2" name="petugas2" data-options="required:true" style="width:100%; height:26px;"></input>
						</td>
						<td valign="top"><div>Keterangan</div><textarea style="max-width:100%; width:100%;" id="keteranganBPB" name="keteranganBPB"></textarea></td>
					</tr>
				</table>
			</div>
			<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="simpanBPB()">SIMPAN</a>
			<a href="#" class="easyui-linkbutton c5" iconCls="icon-cancel" onclick="$('#jendelaBuatBPB').window('close');$('#jendelaBuatBPB').html('');">BATAL</a>
		</div>
	</form>
</div>
<div id="piihBPB"></div>
<script type="text/javascript">
$(function(){
	/* $('#comboPilihVendor').combogrid({
		panelWidth:270,
		url: "<?php echo base_url("index.php/bs/realisasi_bs/daftarVendor")?>",
		idField:'KODE',
		textField:'KODE',
		mode:'remote',
		fitColumns:true,
		columns:[[
			{field:'KODE',title:'KODE',width:70},
			{field:'KETERANGAN',title:'Nama',width:200}
		]]	
	}); */
	$('#comboPilihPetugas2').combogrid({
		panelWidth:270,
		url: "<?php echo base_url("index.php/bs/order_bs/daftarPetugas")?>",
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
	$("input[name='mode']").change(function(){
		var mode = $(this).val();
		$('#cg').combogrid({
			mode: mode
		});
	});	
});
function tampilFormBarang(){
	$('#piihBPB').html();
	$('#piihBPB').dialog({
		title: 'Pilih Barang',
		width: 400,
		height: 220,
		method:'post',
		href: '<?php echo base_url("index.php/bs/realisasi_bs/formPilihBarang");?>',
		modal: true,
		onLoad:function(){
			$.parser.parse('#piihBPB');
		}
	});
}	
function hapusBarisDPB(){
	var rows = $('#dgFormBPB').datagrid('getSelections');  // get all selected rows
	for(var i=0; i<rows.length; i++){
		var index = $('#dgFormBPB').datagrid('getRowIndex',rows[i].id);  // get the row index
		$('#dgFormBPB').datagrid('deleteRow',index);
	}
}










	function simpanBPB(){
		var statusForm = true;
		$('#formBPB').form('submit',{
			onSubmit:function(){
				statusForm = $(this).form('enableValidation').form('validate');
				return false;
			}
		});
		if(statusForm){
			$('#dgFormBPB').datagrid('checkAll');
			var rows = $('#dgFormBPB').datagrid('getChecked');
			
			var nomorBS = $("#formBPB #nomorBS").textbox('getValue');
			var nosal = $("#formBPB #nosal").textbox('getValue');
			var noBPB = $("#formBPB #noBPB").textbox('getValue');
			var vendor = $("#formBPB #comboPilihVendor").textbox('getValue');
			var noForm = $("#formBPB #noForm").textbox('getValue');
			var petugas2 = $("#formBPB #comboPilihPetugas2").combogrid('getValue');
			var keteranganBPB = $("#formBPB #keteranganBPB").val();
			
			$.ajax({
				url			: "<?php echo base_url(); ?>"+"index.php/bs/realisasi_bs/buatBON", 
				type		: "POST", 
				dataType	: "html",
				data		: {noBS:nomorBS,nosalBS:nosal,noBPB:noBPB,vendorBS:vendor,noFormBS:noForm,petugas2BS:petugas2,ketBPB:keteranganBPB,selected:rows},
				beforeSend	: function(){
					var win = $.messager.progress({
						title:'Mohon tunggu',
						msg:'Menyimpan BPB'
					});
				},
				success: function(response){
					 if(response != '1'){
						listBON();
						$('#jendelaBuatBPB').window('close');
						$.messager.progress('close'); 
						alert(response);
						
					}else{
						alert("error ketika menyimpan");
						alert(response);
					} 
					//$( "#results" ).text( response );
				},
				error: function(){
					alert('error');
				},
			});
		}else{
			alert("Pastikan semua field isian di isi terlebih dahulu.");
		}	
	}
</script>

