<div class="easyui-layout" data-options="fit:true">
	<div data-options="region:'north'">
		<div class="pageTitle">Daftar Titip Bayar Tutup Sementara</div>
	</div>
	<div data-options="region:'center'" style="padding:5px;">
		<table class="" id="dgRekapBS" style="height:100%">
			<thead>
				<tr>
					<th data-options="field:'NOSAL'" width="5%">NOSAL</th>
					<th data-options="field:'NO_SPK'" width="15%">NO SPK</th>
					<th data-options="field:'PERIODE'" width="7%">PERIODE</th>
					<th data-options="field:'PETUGAS'" width="15%">PETUGAS</th>
					<th data-options="field:'TGLREALISASI'" width="10%">TGL REALISASI</th>
					<th data-options="field:'JUMLAH'" width="10%">JUMLAH</th>
					<th data-options="field:'KETR'" width="20%">KETERANGAN</th>
					<th data-options="field:'PTSX'" width="5%">PTS</th>
					<th data-options="field:'ATSX'" width="5%">ATS</th>
					<th data-options="field:'ATMX'" width="5%">ATM</th>
					<th data-options="field:'PTBX'" width="5%">PTB</th>
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
			url:'<?php echo base_url("index.php/ts/laporan_ts/daftarTitipBayarTS");?>',
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