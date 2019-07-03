<div class="easyui-layout" style="width:100%; height:100%; margin-bottom:5px;">
	<form id="formJenis" class="easyui-form" method="post" data-options="novalidate:true">
		<div data-options="region:'north'">
			<table id="dgTambahJenis" style="width:100%;height:100%;">
				<tr>
                	<td>Jenis:</td>
                	<td><input name="txtJenis" id="txtJenis" class="f1 easyui-textbox"></input></td>
            	</tr>
			</table>
		</div>
		<div data-options="region:'south'" style="padding:4px; height:35px;">
			<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="simpanJenis()">SIMPAN</a>
			<a href="#" class="easyui-linkbutton c5" iconCls="icon-cancel" onclick="$('#jendelaTambahJenis').window('close')">BATAL</a>
		</div>
	</form>
</div>
<script>
	function simpanJenis(){
		var statusForm = false;
		$('#formJenis').form('submit',{
			onSubmit:function(){
				statusForm = $(this).form('enableValidation').form('validate');
				return false;
			}
		});
		if(statusForm){
			var jenis = $('#txtJenis').val();
			var target = "#jendelaTambahJenis";
			$.ajax({
				url			: "<?php echo base_url(); ?>"+"index.php/ts/jenis_ts/tambahJenis", 
				type		: "POST", 
				dataType	: "html",
				data		: {jenis:jenis},
				beforeSend	: function(){
					var win = $.messager.progress({
							title:'Mohon tunggu',
							msg:'Menambahkan Jenis'
						});
				},
				success: function(response){
					if(response){
						$('#dgJenis').datagrid('reload');
						$.messager.progress('close'); 
						$('#jendelaTambahJenis').window('close');
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