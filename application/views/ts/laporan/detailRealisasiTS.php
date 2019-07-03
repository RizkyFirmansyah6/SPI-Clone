<div class="easyui-layout" data-options="fit:true">
	<div data-options="region:'north'">
		<div class="pageTitle">Daftar Detail Realisasi Tutup Sementara</div>
	</div>
	<div data-options="region:'center'" style="padding:5px;">
		<table class="" id="dgRekapBS" style="height:100%">
			<thead>
				<tr>
					<th data-options="field:'NOSAL'" width="5%">NOSAL</th>
					<th data-options="field:'NAMA'" width="15%">NAMA</th>
					<th data-options="field:'ALAMAT'" width="15%">ALAMAT</th>
					<th data-options="field:'WILAYAH'" width="3%">WILAYAH</th>
					<th data-options="field:'DESA'" width="5%">DESA</th>
					<th data-options="field:'NO_BUKU'" width="5%">BUKU</th>
					<th data-options="field:'TGLJADWAL'" width="10%">TGL JADWAL</th>
					<th data-options="field:'NO_SPK'" width="15%">NO SPK</th>
					<th data-options="field:'PERIODE'" width="7%">PERIODE</th>
					<th data-options="field:'PETUGAS'" width="15%">PETUGAS</th>
					<th data-options="field:'TGLREALISASI'" width="10%">TGL REALISASI</th>
					<th data-options="field:'LOKASI'" width="10%">LOKASI</th>
					<th data-options="field:'FOTO'" width="10%">FOTO</th>
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
					</select> -
					<select class="easyui-combobox" id="opt" style="width:90px; height:28px;">
						<option value="nosal">Nosal</value>
						<option value="nama">Nama</value>
						<option value="alamat">Alamat</value>
					</select>
					<input type="text" class="easyui-textbox" id="val" style="width:230px; height:28px;" />
					<a href="#" class="easyui-linkbutton c1" onclick="filterPeriode()"><i class="fa fa-check-square-o"></i> OK &nbsp;</a>
					<a href="#" class="easyui-linkbutton c2" onclick="$('#dgRekapBS').datagrid('reload')"><i class="fa fa-refresh"></i> RELOAD &nbsp;</a>
				</div>
				</div>
			</div>
			<div id="jendelaFoto" class="easyui-window" title="Foto Realisasi" data-options="modal:true,closed:true,iconCls:'icon-photo'" style="width:670px; height:670px; min-height:400px; padding:5px;">
			<div id="jendelaMap" class="easyui-window" title="Peta Lokasi Realisasi" data-options="modal:true,closed:true,iconCls:'icon-photo'" style="width:670px; height:670px; min-height:400px; padding:5px;">
		</div>
	</div>
</div>
<script>
	$(function(){
		$("#dgRekapBS").datagrid({
			singleSelect:true,
			toolbar:'#tbRekapBS',
			method:'post',
			url:'<?php echo base_url("index.php/ts/laporan_ts/daftarDetailRealisasiTS");?>',
			rowStyler: function(index,row){
				if (row.SISA > 0){
					return 'background-color:#fad395;';
				}
			}
		});
		
	});
	function filterPeriode(){
		$('#dgRekapBS').datagrid('load',{
			periode: $('#tesCC').combobox('getValue'),
			opt: $('#opt').textbox('getValue'),
			val: $('#val').textbox('getValue'),
		});
	}
	
	function photoViewer(src=''){
		var target = "#jendelaFoto";
		$(target).html("<center><img src="+src+" /></center>");
		//$.parser.parse(target);
		$(target).window('open');
	}
	
	function mapViewer(src=''){
		var target = "#jendelaMap";
		$(target).html("<center><iframe width=600 height=600 src="+src+"></iframe></center>");
		//$.parser.parse(target);
		$(target).window('open');
	}
	
	
</script>