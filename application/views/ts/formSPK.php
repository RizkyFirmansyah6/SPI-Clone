<div class="easyui-layout" style="width:100%; height:100%; margin-bottom:5px;">
	<form id="formSPK" class="easyui-form" method="post" data-options="novalidate:true">
		<div data-options="region:'center'">
			<table id="dgBuatSPKnew" style="width:100%;height:100%;" class="easyui-datagrid" rownumbers="true">
				<thead>
					<tr>
						<th data-options="field:'NO_BUKU'" width="10%">BUKU</th>
						<th data-options="field:'NOMOR'" width="20%">NOMOR TS</th>
						<th data-options="field:'TGL'" width="15%">TGL ORDER</th>
						<th data-options="field:'DESA'" width="25%">DESA</th>
						<th data-options="field:'NOSAL'" width="16%">NOSAL</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($dataTabel as $row){
						echo "<tr>
								<td>".$row['NO_BUKU']."</td>
								<td>".$row['NOMOR']."</td>
								<td>".$row['TGL']."</td>
								<td>".$row['DESA']."</td>
								<td>".$row['NOSAL']."</td>
							</tr>";
					}
					?>
				</tbody>
			</table>
		</div>
		<div data-options="region:'north'" style="padding:4px; height:30px;">
			<script>
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
			</script>
			Tanggal Jadwal : <input type="text" input class="easyui-datebox" id="txtDate" style="width:120px">
			<span>&nbsp;&nbsp;&nbsp;</span>
			Petugas&nbsp; : &nbsp;&nbsp;	
				<select class="easyui-combogrid" style="width:250px" id="petugasSPK" data-options="
						panelWidth: 310,
						idField: 'KODE',
						textField: 'KETERANGAN',
						url: '<?php echo base_url("index.php/ts/order_ts/daftarPetugas");?>',
						method: 'post',
						columns: [[
							{field:'KODE',title:'KODE',width:80},
							{field:'GROUP_PETUGAS',title:'GROUP',width:80},
							{field:'KETERANGAN',title:'NAMA',width:150}
						]],
						fitColumns: true, 
						required:true
					">
				</select>
		</div>
		<div data-options="region:'south'" style="padding:4px; height:35px;">
			<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="simpanSPK()">SIMPAN</a>
			<a href="#" class="easyui-linkbutton c5" iconCls="icon-cancel" onclick="$('#jendelaBuatSPK').window('close')">BATAL</a>
		</div>
	</div>
</div>
<script>
	function simpanSPK(){
		var statusForm = false;
		$('#formSPK').form('submit',{
			onSubmit:function(){
				statusForm = $(this).form('enableValidation').form('validate');
				return false;
			}
		});
		if(statusForm){
			$('#dgBuatSPKnew').datagrid('checkAll');
			var rows = $('#dgBuatSPKnew').datagrid('getChecked');
			var petugas = $("#petugasSPK").combogrid('getValue');
			var tglSPK = $('#txtDate').datebox('getValue');
			var target = "#jendelaBuatSPK";
			$.ajax({
				url			: "<?php echo base_url(); ?>"+"index.php/ts/order_ts/simpanSPK", 
				type		: "POST", 
				dataType	: "html",
				data		: {selected:rows,pet:petugas,tgl:tglSPK},
				beforeSend	: function(){
					var win = $.messager.progress({
							title:'Mohon tunggu',
							msg:'Menyimpan SPK'
						});
				},
				success: function(response){
					if(response){
						$('#dgOrder').datagrid('reload');
						$.messager.progress('close'); 
						$('#jendelaBuatSPK').window('close');
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