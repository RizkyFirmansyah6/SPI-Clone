<div class="easyui-layout" style="width:100%; height:100%; margin-bottom:5px;">
	<form id="formAuditor" class="easyui-form" method="post" data-options="novalidate:true">
		<div data-options="region:'north'">
			<table id="dgTambahAuditor" style="width:100%;height:100%;">
				<tr>
					<td>Nomor PKPT:</td>
                	<td><input name="txtPKPT" id="txtPKPT" class="f1 easyui-textbox"></input></td>
            	</tr>
            	<tr>
            		<td>Nama Karyawan:</td>
                	<td><input id="cbKaryawan" class="easyui-combobox" name="cbKaryawan" data-options="valueField:'NIP',textField:'Nama',url:'<?php echo base_url("index.php/ts/auditor_ts/daftarKaryawan");?>'"></input></td>
            	</tr>
			</table>
		</div>
		<div data-options="region:'south'" style="padding:4px; height:35px;">
			<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="simpanAuditor()">SIMPAN</a>
			<a href="#" class="easyui-linkbutton c5" iconCls="icon-cancel" onclick="$('#jendelaTambahAuditor').window('close')">BATAL</a>
		</div>
	</form>
</div>
<script>
	function simpanAuditor(){
		var statusForm = false;
		$('#formAuditor').form('submit',{
			onSubmit:function(){
				statusForm = $(this).form('enableValidation').form('validate');
				return false;
			}
		});
		if(statusForm){
			var no_pkpt = $('#txtPKPT').val();
			var nip = $('#cbKaryawan').combobox('getValue');
			var target = "#jendelaTambahAuditor";
			$.ajax({
				url			: "<?php echo base_url(); ?>"+"index.php/ts/auditor_ts/tambahAuditor", 
				type		: "POST", 
				dataType	: "html",
				data		: {no_pkpt:no_pkpt,nip:nip},
				beforeSend	: function(){
					var win = $.messager.progress({
							title:'Mohon tunggu',
							msg:'Menambahkan Auditor'
						});
				},
				success: function(response){
					if(response){
						$('#dgAuditor').datagrid('reload');
						$.messager.progress('close'); 
						$('#jendelaTambahAuditor').window('close');
					}else{
						alert("error ketika menyimpan");
					}
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