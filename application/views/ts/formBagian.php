<div class="easyui-layout" style="width:100%; height:100%; margin-bottom:5px;">
	<form id="formBagian" class="easyui-form" method="post" data-options="novalidate:true">
		<div data-options="region:'north'">
			<table id="dgTambahBagian" style="width:100%;height:100%;">
				<tr>
                	<td>Bagian:</td>
                	<td><input name="txtBagian" id="txtBagian" class="f1 easyui-textbox"></input></td>
            	</tr>
			</table>
		</div>
		<div data-options="region:'south'" style="padding:4px; height:35px;">
			<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="simpanBagian()">SIMPAN</a>
			<a href="#" class="easyui-linkbutton c5" iconCls="icon-cancel" onclick="$('#jendelaTambahBagian').window('close')">BATAL</a>
		</div>
	</form>
</div>
<script>
	function simpanBagian(){
		var statusForm = false;
		$('#formBagian').form('submit',{
			onSubmit:function(){
				statusForm = $(this).form('enableValidation').form('validate');
				return false;
			}
		});
		if(statusForm){
			var bagian = $('#txtBagian').val();
			var target = "#jendelaTambahBagian";
			$.ajax({
				url			: "<?php echo base_url(); ?>"+"index.php/ts/bagian_ts/tambahBagian", 
				type		: "POST", 
				dataType	: "html",
				data		: {bagian:bagian},
				beforeSend	: function(){
					var win = $.messager.progress({
							title:'Mohon tunggu',
							msg:'Menambahkan Jenis'
						});
				},
				success: function(response){
					if(response){
						$('#dgBagian').datagrid('reload');
						$.messager.progress('close'); 
						$('#jendelaTambahBagian').window('close');
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