		<table id="dgCetakSPK" style="width:100%;height:100%;" rownumbers="true" pagination="true">
			<thead>
				<tr>
					<th data-options="field:'CBORDER',checkbox:true"></th>
					<th data-options="field:'NO_SPK'" width="140">NO SPK</th>
					<th data-options="field:'NOMOR'" width="140">NOMOR TS</th>
					<th data-options="field:'NOSAL'" width="50">NOSAL</th>
					<th data-options="field:'NAMA'" width="150">NAMA PELANGGAN</th>
					<th data-options="field:'ALAMAT'" width="230">ALAMAT</th>
					<th data-options="field:'DESA'" width="100">DESA</th>
					<th data-options="field:'NO_BUKU'" width="40">BUKU</th>
					<th data-options="field:'TGL_SPK'" width="90">TGL SPK</th>
					<th data-options="field:'TGL_REALISASI'" width="90">TGL REALISASI</th>
					<th data-options="field:'TGL_TEMPO'" width="90">TGL TEMPO</th>
					<th data-options="field:'JENIS_MTR'" width="70">JENIS MTR</th>
					<th data-options="field:'STAND'" width="50">STAND</th>
					<th data-options="field:'NO_SLAG'" width="60">NO SLAG</th>
					<th data-options="field:'REALISASI'" width="100">REALISASI</th>
					<th data-options="field:'KETERANGAN'" width="150">KET</th>
					<th data-options="field:'PETUGAS'" width="100">PETUGAS</th>
				</tr>
			</thead>
		</table>
<div id="tbCetakSPK" style="padding:5px;">
	<div class="easyui-layout" style="width:100%; height:36px;">
		<div data-options="region:'center'" style="text-align:center; padding:4px;">
			<form id="formFilterOrder">
			<!--Jawdwal&nbsp; : &nbsp;&nbsp;	
			<input class="easyui-combobox" id="filterJadwalOrder"
				name="language"
				data-options="
						url:'<?php //echo base_url("index.php/ts/order_ts/daftarJadwalDesa");?>',
						method:'post',
						valueField:'group',
						textField:'group',
						width:50,
						panelHeight:300,
						onSelect:function(){
							var thisVal = $('#filterJadwalOrder').combobox('getValue')
							var url = '<?php //echo base_url("index.php/ts/order_ts/daftarDesaByJdw");?>/'+thisVal;
							$('#filterDesaOrder').combobox('reload', url);
						}
				">
			
			&nbsp;&nbsp;&nbsp;&nbsp;	
			-->
			Petugas&nbsp; : &nbsp;&nbsp;	
			<select class="easyui-combogrid" style="width:100px" id="petugasP" data-options="
					panelWidth: 180,
					idField: 'KODE',
					textField: 'KETERANGAN',
					url: '<?php echo base_url("index.php/ts/realisasi_ts/daftarPetugas");?>',
					method: 'post',
					columns: [[
						{field:'KODE',title:'KODE',width:80},
						{field:'GROUP_PETUGAS',title:'GROUP',width:80},
						{field:'KETERANGAN',title:'NAMA',width:150}
					]],
					fitColumns: true, 
					required:false
				">
			</select>
			&nbsp;&nbsp; 
			Desa&nbsp; : &nbsp;&nbsp;
			<input class="easyui-combobox" id="filterDesaOrderP"
				name="language"
				data-options="
						url:'<?php echo base_url("index.php/ts/order_ts/daftarDesa");?>',
						method:'post',
						valueField:'KODE',
						textField:'DESA',
						width:180,
						panelHeight:300
				">
			&nbsp;&nbsp;
			Tanggal Jadwal : <input type="text" input class="easyui-datebox" id="txtDateP" style="width:110px" data-options="formatter:myformatter,parser:myparser">
			&nbsp;&nbsp;
			Nosal&nbsp; : &nbsp;&nbsp;
			<input type="text" class="autoCnosal easyui-textbox" id="nosalP" style="width:100px">
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="" id="tempo" name="tempo" value="1"> Khusus Tempo
			&nbsp;&nbsp;
			<!--
			<span>&nbsp;&nbsp;</span>
			<a href="#" class="easyui-linkbutton" iconCls="icon-clear" onclick="$('#formFilterOrder').form('clear');">RESET FILTER</a>
			-->
			<a href="#" class="easyui-linkbutton c1" iconCls="icon-search" onclick="pencarian()">CARI</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="#" class="easyui-linkbutton" iconCls="icon-print" onclick="cetak1()">CETAK</a>
			</form>
			<form id="cetakForm" action="<?php echo base_url("index.php/ts/realisasi_ts/cetakSPK3"); ?>" target="_blank" method="post">
				<input type="hidden" id="vars" name="vars[]" value="" />
			</form>
		</div>
		</div>
	</div>
</div>
<script>
	var pList=[];
	for(var i=0;i<100;i++){
		var aa = i+1;
		pList[i]=aa+"0";
	}
	
	function myformatter(date){
		var y = date.getFullYear();
		var m = date.getMonth()+1;
		var d = date.getDate();
		return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y;
	}
	function myparser(s){
		if (!s) return new Date();
		var ss = (s.split('-'));
		var y = parseInt(ss[2],10);
		var m = parseInt(ss[1],10);
		var d = parseInt(ss[0],10);
		if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
			return new Date(y,m-1,d);
		} else {
			return new Date();
		}
	}
	
	$(function(){
		$("#dgCetakSPK").datagrid({
			singleSelect:false,
			pageSize:20,
			pageList:pList,
			toolbar:'#tbCetakSPK',
			url:'<?php echo base_url("index.php/ts/realisasi_ts/daftarRealisasiTSCetak");?>',
			method:'post'
		});
	});
	function pencarian(){ 
		var tempoChk = 0;
		if ($('#tempo').is(":checked"))
		{
		  tempoChk = 1;
		}
		$('#dgCetakSPK').datagrid('load',{
			//jadwal: $('#filterJadwalOrder').combobox('getValue'),
			desa: $('#filterDesaOrderP').combobox('getValue'),
			tglJdw: $('#txtDateP').datebox('getValue'),
			petugas: $('#petugasP').combobox('getValue'),
			nosal: $('#nosalP').textbox('getValue'),
			tempo: tempoChk
		});
	}
	function cetak1(){
		var rows = $('#dgCetakSPK').datagrid('getChecked');
		//alert(rows);
		$( "#vars" ).val(JSON.stringify(rows));
		$( "#cetakForm" ).submit();
	}
</script>
