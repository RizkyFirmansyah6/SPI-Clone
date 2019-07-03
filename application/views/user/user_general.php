<div class="easyui-layout" data-options="fit:true">
	<div data-options="region:'north'">
		<div class="pageTitle">Manajemen User Aplikasi</div>
	</div>
	<div data-options="region:'west',collapsed:false" style="width:250px; padding:5px;">
		<div class="easyui-panel" title="Tambah User Aplikasi" style="width:100%;padding:5px;">
			<p>Untuk menambahkan user yang bisa mengakses kedalam aplikasi, isi form di bawah ini dengan benar.</p>
			<form id="ff" method="post" style="">
				<table cellpadding="5" width="100%">
					<tr>
						<td>
							<div  class="form-caption">NIP / Nama Pegawai</div>
							<input id="cg" class="easyui-textbox" type="text" name="nip" data-options="required:true" style="width:210px;"></input>
						</td>
					</tr>
					<tr>
						<td>
							<div  class="form-caption">Status User</div>
							<select class="easyui-combobox" name="status" style="width:210px;" data-options="required:true" >
								<option value="0" selected>Tidak Aktif [default]</option>
								<option value="1">Aktif</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<div  class="form-caption">Group User</div>
							<input class="easyui-combobox" name="id_user_group" style="width:210px;"
								name="language"
								data-options="
										url:'<?php echo base_url("index.php/user_group/daftarDataGroup/1");?>',
										method:'get',
										valueField:'id',
										textField:'nama',
										panelHeight:'auto',
										required:true
								">
						</td>
					</tr>
					<tr>
						<td id="state">
						</td>
					</tr>
					<tr>
						<td>
							<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">Simpan</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<div data-options="region:'center'" style="padding:5px;">
		<table class="" title="Daftar pegawai yang terdaftar kedalam aplikasi" style="width:100%;height:auto" id="dgUser">
			<thead>
				<tr>
					<th data-options="field:'id',hidden:true">id</th>
					<th data-options="field:'nip'" width="20%">NIP</th>
					<th data-options="field:'status'" width="15%">Status Aktif</th>
					<th data-options="field:'full_name'" width="45%">Nama Lengkap</th>
					<th data-options="field:'nama_group'" width="20%">Group</th>
				</tr>
			</thead>
		</table>
		<div id="w" class="easyui-window" title=" Edit User Aplikasi" data-options="modal:true,closed:true,iconCls:'icon-edit'" style="width:380px;padding:10px;">
			The window content.
		</div>
		<div id="mmUser" class="easyui-menu" style="width:120px;">
			<div data-options="iconCls:'icon-edit'" onclick="formEditSelected()">Edit</div>
			<div class="menu-sep"></div>
			<div data-options="iconCls:'icon-cancel'" onclick="deleteSelected()">Delete</div>
		</div>
		<script>
			$(function(){
				$("#dgUser").datagrid({
					singleSelect:true,
					collapsible:true,
					url:'<?php echo base_url("index.php/user/daftarDataPegawai/1");?>',
					method:'get',
					onRowContextMenu : function(e,field){
						e.preventDefault();
						$('#mmUser').menu('show', {
							left: e.pageX,
							top: e.pageY
						});
					}
				});
				
				// combo grid preparation
				$('#cg').combogrid({
					panelWidth:270,
					url: "<?php echo base_url("index.php/user/comboDataPegawai")?>",
					idField:'nip',
					textField:'nip',
					mode:'remote',
					fitColumns:true,
					columns:[[
						{field:'nip',title:'NIP',width:70},
						{field:'full_name',title:'Nama Lengkap',width:200}
					]]
				});
				
				// combo grid event change
				$("input[name='mode']").change(function(){
					var mode = $(this).val();
					$('#cg').combogrid({
						mode: mode
					});
				});
			});
			function formEditSelected(){
				var selected = $('#dgUser').datagrid('getSelected').id;
				
				var target = "#state";
				$.ajax({
					url			: "<?php echo base_url(); ?>"+"index.php/user/formEditUser", 
					type		: "POST", 
					dataType	: "html",
					data		: {id:selected},
					success: function(response){
						$('#w').html(response);
						$.parser.parse("#w");
						//$('#userGroupEditField').combobox('setValue','5');
						$('#w').window('open');
					},
					error: function(){
						alert('error');
					},
				});
				return false;
			}
			function deleteSelected(){
				var selected = $('#dgUser').datagrid('getSelected').id;
				$.messager.confirm('Hapus Pengguna Aplikasi ', 'Anda yakin menghapus ['+selected+'] '+$('#dgUser').datagrid('getSelected').full_name+' ?', function(r){
					if (r){
						var target = "#state";
						$.ajax({
							url			: "<?php echo base_url(); ?>"+"index.php/user/hapusUser", 
							type		: "POST", 
							dataType	: "html",
							data		: {id:selected},
							success: function(response){
								if(response == '1'){
									$('#dgUser').datagrid('reload');
								}else{
									alert(response);
								}
							},
							error: function(){
								alert('error');
							},
						});
						return false;
					}
				});
			}
			function submitForm(){
				var target = "#state";
				$.ajax({
					url			: "<?php echo base_url(); ?>"+"index.php/user/tambahUser", 
					type		: "POST", 
					dataType	: "html",
					data		: $("#ff").serialize(),
					beforeSend	: function(){
						$(target).html('<div><i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;&nbsp;Loading . . . .</div>');
					},
					success: function(response){
						if(response == '1'){
							$('#dgUser').datagrid('reload');
							$(target).html('<div><i class="fa fa-check-circle"></i>&nbsp;&nbsp;Sukses menyimpan.</div>');
							$("#ff")[0].reset();
						}else{
							$(target).html(response);
						}
					},
					error: function(){
						alert('error');
					},
				});
				return false;
			}
	function submitUpdateForm(){
		var target = "#stateUpdate";
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/user/updateUser", 
			type		: "POST", 
			dataType	: "html",
			data		: $("#formUpdateUser").serialize(),
			beforeSend	: function(){
				$(target).html('<div><i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;&nbsp;Loading . . . .</div>');
			},
			success: function(response){
				if(response == '1'){
					$(target).html('Sukses');
					$('#dgUser').datagrid('reload');
					$('#w').html("");
					$('#w').window('close');
				}else{
					$(target).html(response);
				}
			},
			error: function(){
				alert('error');
			},
		});
		return false;
	}
		</script>
	</div>
</div>