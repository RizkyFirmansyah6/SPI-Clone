<div class="easyui-layout" data-options="fit:true">
	<form id="formFilterOrder">
	<div data-options="region:'north'">
		<div class="pageTitle">Realisasi Tutup Sementara</div>
	</div>
	<div data-options="region:'center'" style="padding:5px;">
		<table id="dgRekapPerTglSPK" style="width:100%;height:50%;" title="Rekap Per Tanggal SPK" rownumbers="true" pagination="false">
			<thead>
				<tr>
					<th data-options="field:'TGL_SPK'" width="10%">Tanggal SPK</th>
					<th data-options="field:'SPK'" width="10%">Order SPK</th>
					<th data-options="field:'BERHASIL'" width="20%">TMS</th>
					<th data-options="field:'BAYAR'" width="20%">Telah Dibayar</th>
					<th data-options="field:'SISA'" width="20%">Sisa</th>
				</tr>
			</thead>
		</table>
		
		<table id="dgRealisasi" style="width:100%;height:100%;" title="Daftar SPK Buka Sementara" rownumbers="true" pagination="true">
			<thead>
				<tr>
					<!--<th data-options="field:'NO_BPB'" width="110">NO BPB</th>-->
					<th data-options="field:'NOMOR'" width="110">NOMOR TS</th>
					<th data-options="field:'NO_SPK'" width="110">NO SPK</th>
					<th data-options="field:'TGL_SPK'" width="110">TGL SPK</th>
					<th data-options="field:'NOSAL'" width="50">NOSAL</th>
					<th data-options="field:'NAMA'" width="150">NAMA PELANGGAN</th>
					<th data-options="field:'ALAMAT'" width="300">ALAMAT</th>
					<th data-options="field:'DESA'" width="110">DESA</th>
					<th data-options="field:'NO_BUKU'" width="40">BUKU</th>
					<th data-options="field:'TGL_REALISASI'" width="90">TGL REALISASI</th>
					<th data-options="field:'TUTUP'" width="90">TUTUP</th>
					<th data-options="field:'REALISASI'" width="90">REALISASI</th>
					<th data-options="field:'JENIS_MTR'" width="70">JENIS MTR</th>
					<th data-options="field:'DIAMETER'" width="70">DIAMETER</th>
					<th data-options="field:'STAND'" width="50">STAND</th>
					<th data-options="field:'NO_SLAG'" width="60">NO SLAG</th>
					<th data-options="field:'REALISASI'" width="100">REALISASI</th>
					<th data-options="field:'KETERANGAN'" width="150">KET</th>
					<th data-options="field:'PETUGAS'" width="100">KODE PETUGAS</th>
					<th data-options="field:'NM_PETUGAS'" width="100">NAMA PETUGAS</th>
					<th data-options="field:'NO_SEGEL'" width="60">NO. SEGEL</th>
					<th data-options="field:'TGL_TEMPO'" width="100">TGL TEMPO</th>
					<th data-options="field:'TGL_BAYAR'" width="100">TGL BAYAR</th>
					<!--<th data-options="field:'TGL'" width="110">TGL TS</th>-->
				</tr>
			</thead>
		</table>
			<div id="tbRealisasi" style="padding:5px;">
				<div class="easyui-layout" style="width:100%; height:36px;">
					<div data-options="region:'east'" style="width:870px; text-align:right; padding:4px;">
						
						Status&nbsp; : &nbsp;&nbsp;	
						<select class="easyui-combobox" style="width:150px" id="status" name="status">
							<option value="">-semua-</option>
							<option value="1">Sudah Realisasi</option>
							<option value="0">Belum Realisasi</option>
							<option value="2">Terbayar</option>
							<option value="3">Tempo</option>
							<option value="4">Berhasil</option>
							<option value="5">Gagal</option>
						</select>
						&nbsp;&nbsp;&nbsp;&nbsp;
						Petugas&nbsp; : &nbsp;&nbsp;	
						<select class="easyui-combogrid" style="width:150px" id="petugas" data-options="
								panelWidth: 310,
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
						
						&nbsp;&nbsp;&nbsp;&nbsp;	
						Nosal&nbsp; : &nbsp;&nbsp;
						<input type="text" class="autoCnosal easyui-textbox" id="nosal" style="width:100px">
						<a href="#" class="easyui-linkbutton" iconCls="icon-clear" onclick="$('#formFilterOrder').form('clear');">Reset</a>
						<a href="#" class="easyui-linkbutton c1" iconCls="icon-search" onclick="autoCompleteNosal();pencarian()">Cari</a>
						
					</div>
					<div data-options="region:'center'" style="padding:4px;">
						<a href="#" class="easyui-linkbutton" onclick="daftarCetakSPK()"><i class="fa fa-print"></i> Cetak SPK</a>
						<!--<a href="#" class="easyui-linkbutton c7" onclick="listBON()" style="color:#fff;"><i class="fa fa-file-text"></i> BON BARANG</a>-->
						<a href="#" class="easyui-linkbutton c1" onclick="realisasiSPK()"><i class="fa fa-check-square-o"></i> Realisasi</a>
						
						
					</div>
					<!--<div data-options="region:'center'" style="padding:4px;">
					</div>-->
				</div>
			</div>
		</div>
		<input type="hidden" id="tglSPK" value=""/>
	    <div id="jendelaDaftarCetakSPK" class="easyui-window" title="Cetak SPK" data-options="modal:true,closed:true,iconCls:'icon-print'" style="width:80%; min-height:500px; padding:5px;">
	    <div id="jendelaBuatBPB" class="easyui-window" title="BON BP" data-options="modal:true,closed:true,iconCls:'icon-print'" style="width:800px; height:100%; min-height:400px; padding:5px;">
	    <div id="jendelaDaftarBON" class="easyui-window" title="BON BARANG" data-options="modal:true,closed:true,iconCls:'icon-print'" style="width:800px; height:400px; min-height:400px; padding:5px;">
	    <div id="jendelaRealisasiSPK" class="easyui-window" title="REALISASI TS" data-options="modal:true,closed:true" style="width:800px; height:580px; min-height:400px; padding:5px;">
		</div>
	</div>
	</form>
</div>
<script>
	var pList=[];
	for(var i=0;i<100;i++){
		pList[i]=i+1;
	}
	
	function autoCompleteNosal() {
	var inp 	= $('#nosal').textbox('getValue');
	var nos			= inp.trim();
	
	if (inp != ""){
		var nosal 	= "";
		if (nos.length == 1) {
			nosal = "00000"+nos;
		} else if (nos.length == 2) {
			nosal = "0000"+nos;
		} else if (nos.length == 3) {
			nosal = "000"+nos;
		} else if (nos.length == 4) {
			nosal = "00"+nos;
		} else if (nos.length == 5) {
			nosal = "0"+nos;
		} else {
			nosal = nos;
		}
		$('#nosal').textbox('setValue',nosal);
	}
}
	
	$(function(){
		$("#dgRekapPerTglSPK").datagrid({
			singleSelect:true,
			checkOnSelect:true,
			collapsible:true,
			pageSize:20,
			pageList:pList,
			toolbar:'#tbOrder',
			footer:'#ftOrder',
			url:'<?php echo base_url("index.php/ts/realisasi_ts/rekapPerTgl");?>',
			method:'post',
			onRowContextMenu : function(e,field){
				//e.preventDefault();
				$('#mmUser').menu('show', {
					left: e.pageX,
					top: e.pageY
				});
			},
			
			onClickCell:function(index,field,val){
				$('#col').val(field);
				//alert(index+field+val);
			},
			onClickRow:function(index,row){
				$('#tglSPK').val(row.TGL_SPK);
				showDetPerTgl();
			},
			showFooter:true
		});
	});
	
	$(function(){
		$("#dgRealisasi").datagrid({
			singleSelect:true,
			pageSize:20,
			toolbar:'#tbRealisasi',
			url:'<?php echo base_url("index.php/ts/realisasi_ts/daftarRealisasiTS");?>',
			method:'post',
			rowStyler:function(index,row){
				if (row.TGL_BAYAR != null){
					return 'color:blue;';
				}
				if (row.TGL_TEMPO != null) {
					return 'background-color:khaki;';
				} else if (row.TUTUP == 1) {
					return 'background-color:lightgreen;';
				} else if (row.TUTUP == 0 && row.TGL_REALISASI!=null) {
					return 'background-color:pink;';
				}
			}
		});
	});
	
	function showDetPerTgl(){
		var tglSPK = $('#tglSPK').val();
		var status = $('#status').combobox('getValue');
		var petugas = $('#petugas').combobox('getValue');
		
		$('#dgRealisasi').datagrid('load',{
			tglJdw: tglSPK,
			status: status,
			petugas: petugas
		});
	}
	
	function pencarian(){
		var tglHid = $("#tglSPK").val();
		$('#dgRealisasi').datagrid('load',{
			status: $('#status').combobox('getValue'),
			petugas: $('#petugas').combobox('getValue'),
			nosal: $('#nosal').textbox('getValue'),
			tglJdw: tglHid
		});
	}
	
	
	function daftarCetakSPK(){
		var target = "#jendelaDaftarCetakSPK";
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/realisasi_ts/viewDaftarCetakSPK", 
			type		: "POST", 
			dataType	: "html",
			beforeSend	: function(){
				$(target).html('Loading . . . ');
			},
			success: function(response){
				$(target).html(response);
				$.parser.parse(target);
				$(target).window('open');
			},
			error: function(){
				alert('error');
			}
		});
	}
	function listBON(barisLama = 'null'){
		var target = "#jendelaDaftarBON";
		if(barisLama == 'null'){
			var rows = $('#dgRealisasi').datagrid('getChecked');
		}else{
			var rows = barisLama;
		}
		
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/realisasi_ts/daftarBON", 
			type		: "POST", 
			dataType	: "html",
			data		: {selected:rows},
			beforeSend	: function(){
				$(target).html('Loading . . . ');
			},
			success: function(response){
				$(target).html(response);
				$.parser.parse(target);
				$(target).window('open');
			},
			error: function(){
				alert('error');
			}
		});
		return false;
	}
	function detailBON(noBon){
		var target = "#jendelaDaftarDetailBON";
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/realisasi_ts/detailBON", 
			type		: "POST", 
			dataType	: "html",
			data		: {selected:rows},
			beforeSend	: function(){
				$(target).html('Loading . . . ');
			},
			success: function(response){
				$(target).html(response);
				$.parser.parse(target);
				$(target).window('open');
			},
			error: function(){
				alert('error');
			}
		});
		return false;
	}
	function formBPB(){
		var target = "#jendelaBuatBPB";
		var rows = $('#dgRealisasi').datagrid('getChecked');
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/realisasi_ts/formBPB", 
			type		: "POST", 
			dataType	: "html",
			data		: {selected:rows},
			beforeSend	: function(){
				$(target).html('Loading . . . ');
			},
			success: function(response){
				$(target).html(response);
				$.parser.parse(target);
				$(target).window('open');
			},
			error: function(){
				alert('error');
			}
		});
		return false;
	}
	function realisasiSPK(){
		var target = "#jendelaRealisasiSPK";
		var rows = $('#dgRealisasi').datagrid('getChecked');
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/realisasi_ts/formRealisasiSPK", 
			type		: "POST", 
			dataType	: "html",
			data		: {selected:rows},
			beforeSend	: function(){
				$(target).html('Loading . . . ');
			},
			success: function(response){
				$(target).html(response);
				$.parser.parse(target);
				$(target).window('open');
			},
			error: function(){
				alert('error');
			}
		});
		return false;
	}
</script>