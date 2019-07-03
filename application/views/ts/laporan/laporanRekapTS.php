<div class="easyui-layout" data-options="fit:true">
	<div data-options="region:'north'">
		<div class="pageTitle">Rekap Tutup Sementara</div>
	</div>
	<div data-options="region:'center'" style="padding:5px;">
		<table class="" id="dgRekapBS" style="height:100%">
			<thead>
				<tr>
					<th data-options="field:'TGL'" width="50%">TANGGAL</th>
					<th data-options="field:'ORDERS'" width="10%">ORDER</th>
					<th data-options="field:'SPK'" width="10%">SPK</th>
					<th data-options="field:'BUKA'" width="10%">BERHASIL</th>
					<th data-options="field:'GAGAL'" width="10%">GAGAL</th>
					<th data-options="field:'SISA'" width="10%">SISA</th>
				</tr>
			</thead>
		</table>
		<div id="tbRekapBS" style="padding:5px;">
			    <div class="easyui-layout" style="width:100%; height:36px;">
					<div data-options="region:'center'" style="padding:4px;">
						Periode : 
						<select class="easyui-combobox" id="tesCC" style="width:200px; height:28px;">
						<?php
							echo($listPeriode);
						?>
						</select>
						<a href="#" class="easyui-linkbutton c1" onclick="filterPeriode()"><i class="fa fa-check-square-o"></i> OK &nbsp;</a>
						<a href="#" class="easyui-linkbutton c2" onclick="$('#dgRekapBS').datagrid('reload')"><i class="fa fa-refresh"></i> RELOAD &nbsp;</a>
					</div>
					</div>
				</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		$("#dgRekapBS").datagrid({
			singleSelect:true,
			toolbar:'#tbRekapBS',
			method:'post',
			url:'<?php echo base_url("index.php/ts/laporan_ts/daftarRekapTS");?>',
			rowStyler: function(index,row){
				if (row.SISA > 0){
					return 'background-color:#fad395;';
				}
			}
		});
	});
	function filterPeriode(){
		$('#dgRekapBS').datagrid('load',{
			periode: $('#tesCC').combobox('getValue')
		});
	}
</script>