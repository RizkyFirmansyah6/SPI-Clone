<div class="easyui-layout" style="width:100%; height:100%; margin-bottom:5px;">
	<form id="formTahun" class="easyui-form" method="post" data-options="novalidate:true">
		<div data-options="region:'north'">
			<table id="dgTambahTahun" style="width:100%;height:100%;">
				<tr>
                	<td>Tahun:</td>
                	<td><input name="txtTahun" id="txtTahun" class="f1 easyui-textbox"></input></td>
            	</tr>
			</table>
		</div>
		<div data-options="region:'south'" style="padding:4px; height:35px;">
			<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="simpanTahun()">SIMPAN</a>
			<a href="#" class="easyui-linkbutton c5" iconCls="icon-cancel" onclick="$('#jendelaTambahTahun').window('close')">BATAL</a>
		</div>
	</form>
</div>
<script>
	function simpanTahun(){
		var statusForm = false;
		$('#formTahun').form('submit',{
			onSubmit:function(){
				statusForm = $(this).form('enableValidation').form('validate');
				return false;
			}
		});
		if(statusForm){
			var tahun = $('#txtTahun').val();
			var target = "#jendelaTambahTahun";
			$.ajax({
				url			: "<?php echo base_url(); ?>"+"index.php/ts/tahun_ts/tambahTahun", 
				type		: "POST", 
				dataType	: "html",
				data		: {tahun:tahun},
				beforeSend	: function(){
					var win = $.messager.progress({
							title:'Mohon tunggu',
							msg:'Menambahkan Tahun'
						});
				},
				success: function(response){
					if(response){
						$('#dgTahun').datagrid('reload');
						$.messager.progress('close'); 
						$('#jendelaTambahTahun').window('close');
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