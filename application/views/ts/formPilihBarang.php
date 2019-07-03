<div class="easyui-layout" style="width:100%; height:100%;">
	<form id="formPilihBarangBaru" class="easyui-form" method="post">
		<div data-options="region:'center'" style="background-color:#fff;">
			<table width="100%" border="0" cellspacing="5">
				<tr>
					<td>Kode Barang</td>
					<td>:</td>
					<td width="60%">
						<!--<input id="comboPilihBarang" class="" style="width:100%; height:26px;"></input>-->
						<input id="cgAmbilBarang" style="width:100%; height:26px;" class="easyui-combogrid" data-options="panelWidth:720,
																												url: '<?php echo base_url("index.php/bs/realisasi_bs/daftarBarang")?>',
																												idField:'kode',
																												textField:'kode',
																												mode:'remote',
																												fitColumns:true,
																												cache:false,
																												required:true,
																												columns:[[
																													{field:'kode',title:'KODE',width:70},
																													{field:'nama_item',title:'Nama',width:200},
																													{field:'ukuran',title:'Ukuran',width:200},
																													{field:'kd_satuan',title:'Satuan',width:200},
																													{field:'stok',title:'Stok',width:50}
																												]],
																												onSelect:function(){bagiData();}"></input>
					</td>
				</tr>
				<tr>
					<td>Nama Barang</td>
					<td>:</td>
					<td width="60%" id="namaBarang"></td>
				</tr>
				<tr>
					<td>UKURAN</td>
					<td>:</td>
					<td width="60%" id="ukuranBarang"></td>
				</tr>
				<tr>
					<td>QTY</td>
					<td>:</td>
					<td width="60%">
						<!--<input class="easyui-textbox" id="qtyBarangDiambil" type="text" name="nip" data-options="required:true" style="width:50px; height:26px;" onchange="validasiQTY()" value=""></input>-->
						<input type="text" id="nnQTY">
						<span id="qtyBarang"></span>
						<span id="satuanBarang"></span>
					</td>
				</tr>
				<tr>
					<td>GUD</td>
					<td>:</td>
					<td width="60%"><input class="easyui-textbox" id="gud" type="text" name="nip" data-options="required:true" style="width:50px; height:26px;"></input></td>
				</tr>
			</table>
		</div>
		<div data-options="region:'south'" style="padding:6px; height:39px; text-align:center;">
			<a href="#" class="easyui-linkbutton" onclick="tambahData()" style="color:#27ae60"><i class="fa fa-plus-square"></i> TAMBAHKAN</a>
			<a href="#" class="easyui-linkbutton" onclick="$('#piihBPB').dialog('close')" style="color:#e74c3c"><i class="fa fa-close"></i> TUTUP</a>
		</div>
	</form>
</div>
<script>
	var globalMaxStok;
	$(function(){
/* 		$('#comboPilihBarang').combogrid({
			panelWidth:720,
			url: '<?php echo base_url("index.php/bs/realisasi_bs/daftarBarang")?>',
			idField:'kode',
			textField:'kode',
			mode:'remote',
			fitColumns:true,
			cache:false,
			columns:[[
				{field:'kode',title:'KODE',width:70},
				{field:'nama_item',title:'Nama',width:200},
				{field:'ukuran',title:'Ukuran',width:200},
				{field:'kd_satuan',title:'Satuan',width:200},
				{field:'stok',title:'Stok',width:50}
				]],
			onChange:bagiData
		}); */
		$('#nnQTY').numberspinner({
			min:1
		});
	});
	function bagiData(){
		var g = $('#cgAmbilBarang').combogrid('grid');
		var cacad = g.datagrid('getSelected');
			if(cacad != ''){
			$("#namaBarang").html(cacad.nama_item);
			$("#ukuranBarang").html(cacad.ukuran);
			$("#satuanBarang").html(cacad.kd_satuan);
			$("#qtyBarang").html(" / "+cacad.stok);
			globalMaxStok = cacad.stok;
			$('#nnQTY').numberspinner({
				max:parseInt(cacad.stok),
				value:1
			});
		}
	}
	function tambahData(){
		$('#dgFormBPB').datagrid('appendRow',{
			KODE: $("#cgAmbilBarang").combogrid('getValue'),
			URAIAN: $("#namaBarang").html(),
			UKURAN: $("#ukuranBarang").html(),
			QTY: $("#nnQTY").textbox('getValue'),
			SATUAN: $("#satuanBarang").html(),
			GUD: $("#gud").textbox('getValue')
		});
		$('#piihBPB').dialog('close');
	}
</script>