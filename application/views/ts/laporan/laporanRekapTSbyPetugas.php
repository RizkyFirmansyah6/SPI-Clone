<div class="easyui-layout" data-options="fit:true">
	<div data-options="region:'north'">
		<div class="pageTitle">Rekap Tutup Sementara</div>
	</div>
	<div data-options="region:'center'" style="padding:5px;">
		<table class="" id="dgRekapBSbyPetugas" style="height:100%">
			<thead>
				<tr>
					<th data-options="field:'petugas'" width="10%">KODE PETUGAS</th>
					<th data-options="field:'keterangan'" width="20%">NAMA</th>
					<!--<th data-options="field:'orders'" width="10%" align="right">ORDER</th>-->
					<th data-options="field:'spk'" width="10%" align="right">SPK</th>
					<th data-options="field:'bayar'" width="10%" align="right">TERBAYAR</th>
					<th data-options="field:'REALISASI_KOPLING'" width="10%" align="right">R. Kopling</th>
					<th data-options="field:'REALISASI_LEPAS_METER'" width="10%" align="right">R. Lepas Meter</th>
					<th data-options="field:'REALISASI_DOP'" width="10%" align="right">R. Dop</th>
					<th data-options="field:'tempo'" width="10%" align="right">TEMPO</th>
					<th data-options="field:'sisa'" width="10%" align="right">SISA</th>
				</tr>
			</thead>
		</table>
		<div id="tbRekapBS2" style="padding:5px;">
			    <div class="easyui-layout" style="width:100%; height:36px;">
					<div data-options="region:'center'" style="padding:4px;">
						<form name="filter" id="filter" action="<?php echo base_url("index.php/ts/download_csv/rekap_per_petugas"); ?>" target="_blank" method="post">
						Periode : 
						<select class="easyui-combobox" id="periode" name="periode" style="width:200px; height:28px;">
						<?php
							echo($listPeriode);
						?>
						</select>
						<a href="#" class="easyui-linkbutton c1" onclick="filterPeriode()"><i class="fa fa-check-square-o"></i> Filter &nbsp;</a>
						<a href="#" class="easyui-linkbutton c4" onclick='$( "#filter" ).submit();'><i class="fa fa-check-square-o"></i> Download CSV &nbsp;</a>
						<!--<a href="#" class="easyui-linkbutton c2" onclick="$('#dgRekapBSbyPetugas').datagrid('reload')"><i class="fa fa-refresh"></i> RELOAD &nbsp;</a>-->
					</div>
				</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		$("#dgRekapBSbyPetugas").datagrid({
			singleSelect:true,
			toolbar:'#tbRekapBS2',
			method:'post',
			url:'<?php echo base_url("index.php/ts/laporan_ts/daftarRekapTSbyPetugas");?>',
			showFooter:true
		});
	});
	function filterPeriode(){
		$('#dgRekapBSbyPetugas').datagrid('load',{
			periode: $('#periode').combobox('getValue')
		});
	}
</script>