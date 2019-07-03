<div class="easyui-layout" data-options="fit:true">
	<div data-options="region:'north'">
		<div class="pageTitle">Rekap Per Petugas</div>
	</div>
	
	<div data-options="region:'center'" style="padding:5px;">
		<table id="dgRekapPerPtgs" style="width:100%;height:50%;" title="Rekap Per Petugas" rownumbers="true" pagination="false">
			<thead>
				<tr>
					<th data-options="field:'KDPETUGAS'" width="7%">Kode Petugas</th>
					<th data-options="field:'NMPETUGAS'" width="20%">Nama Petugas</th>
					<th data-options="field:'SPK'"align="right"  width="10%">Jumlah SPK</th>
					<th data-options="field:'BERHASIL'" align="right"  width="10%">Berhasil Tutup</th>
					<th data-options="field:'GAGAL'" align="right"  width="10%">Gagal</th>
					<th data-options="field:'BAYAR'" align="right"  width="10%">Terbayar</th>
					<th data-options="field:'TEMPO'" align="right"  width="10%">Tempo</th>
					<th data-options="field:'SISA'" align="right"  width="10%">Sisa</th>
				</tr>
			</thead>
		</table>
		<table id="dgRekapPerTgl" style="width:100%;height:50%;" title="Rekap Per Tanggal SPK" rownumbers="true" pagination="false" idField="NO_BUKU">
			<thead>
				<tr>
					<th data-options="field:'KDPETUGAS'" width="7%">Kode Petugas</th>
					<th data-options="field:'NMPETUGAS'" width="20%">Nama Petugas</th>
					<th data-options="field:'TGLSPK'" width="10%">Tanggal SPK</th>
					<th data-options="field:'SPK'"align="right"  width="10%">Jumlah SPK</th>
					<th data-options="field:'BERHASIL'" align="right"  width="10%">Berhasil Tutup</th>
					<th data-options="field:'GAGAL'" align="right"  width="10%">Gagal</th>
					<th data-options="field:'BAYAR'" align="right"  width="10%">Terbayar</th>
					<th data-options="field:'TEMPO'" align="right"  width="10%">Tempo</th>
					<th data-options="field:'SISA'" align="right"  width="10%">Sisa</th>
				</tr>
			</thead>
		</table>
		<div id="bkOrder" style="padding:5px;">
			<div class="easyui-layout" style="width:100%; height:36px;">
				
			</div>
		</div>
		<table id="dgOrder" style="width:100%;height:100%;" title="Daftar Nosal Per Tanggal SPK Tiap Petugas" rownumbers="true" pagination="true">
			<thead>
				<tr>
					<!--<th data-options="field:'CBORDER',checkbox:true"></th>-->
					<th data-options="field:'NO_BUKU'" width="7%">NO BUKU</th>
					<th data-options="field:'DESA'" width="10%">DESA</th>
					<th data-options="field:'NOSAL'" width="5%">NOSAL</th>
					<th data-options="field:'NOMOR'" width="10%">NOMOR TS</th>
					<th data-options="field:'TGL_SPK'" width="7%">TGL SPK</th>
					<th data-options="field:'NO_SPK'" width="7%">NO SPK</th>
					<th data-options="field:'TGL_TEMPO'" width="7%">TGL TEMPO</th>
					<th data-options="field:'TGL_BAYAR'" width="7%">TGL BAYAR</th>
					<th data-options="field:'TGL_REALISASI'" width="8%">TGL REALISASI</th>
					<th data-options="field:'REALISASI'" width="7%">REALISASI</th>
					<th data-options="field:'KETERANGAN'" width="10%">KETERANGAN</th>
					<th data-options="field:'NAMA'" width="20%">NAMA PELANGGAN</th>
					<th data-options="field:'ALAMAT'" width="38%">ALAMAT</th>
					<th data-options="field:'KDPETUGAS'" width="8%">KODE PETUGAS</th>
					<th data-options="field:'NMPETUGAS'" width="19%">NAMA PETUGAS</th>
				</tr>
			</thead>
		</table>
		
		<!--
		<div id="tbOrder" style="padding:5px;">
			    <div class="easyui-layout" style="width:100%; height:36px;">
					<div data-options="region:'east'" style="width:570px; padding:4px;">
						<form id="formFilterOrder">
						
						JADWAL&nbsp; : &nbsp;&nbsp;	
						<input class="easyui-combobox" id="filterJadwalOrder"
							name="language"
							data-options="
									url:'<?php //echo base_url("index.php/ts/rekap_petugas_ts/daftarJadwalDesa");?>',
									method:'post',
									valueField:'group',
									textField:'group',
									width:50,
									panelHeight:300,
									onSelect:function(){
										var thisVal = $('#filterJadwalOrder').combobox('getValue')
										var url = '<?php //echo base_url("index.php/ts/rekap_petugas_ts/daftarDesaByJdw");?>/'+thisVal;
										$('#filterDesaOrder').combobox('reload', url);
									}
							">
						
						&nbsp;&nbsp;&nbsp;&nbsp;	
						DESA&nbsp; : &nbsp;&nbsp;
						<input class="easyui-combobox" id="filterDesaOrder"
							name="language"
							data-options="
									url:'<?php //echo base_url("index.php/ts/rekap_petugas_ts/daftarDesa");?>',
									method:'post',
									valueField:'KODE',
									textField:'DESA',
									width:200,
									panelHeight:300
							">
						<a href="#" class="easyui-linkbutton" iconCls="icon-clear" onclick="$('#formFilterOrder').form('clear');">CLEAR FILTER</a>
						<a href="#" class="easyui-linkbutton c1" iconCls="icon-search" onclick="pencarian()">CARI</a>
						</form>
					</div>
					<div data-options="region:'center'" style="padding:4px;">
					</div>
				</div>
		</div>
		-->
		<div id="tbOrderAA" style="padding:5px;">
			    <div class="easyui-layout" style="width:100%; height:36px;">
					<div data-options="region:'east'" style="width:570px; padding:4px;">
						
					</div>
					<div data-options="region:'center'" style="padding:4px;">
						<form id="formFilterOrderAA">
							Tanggal Jadwal : <input id="datebox" name="datebox" type="text" class="easyui-datebox" required="required" data-options="formatter:myformatter,parser:myparser"> 
						<a href="#" class="easyui-linkbutton c1" iconCls="icon-search" onclick="filterTgl()">FILTER</a>
						</form>
					</div>
				</div>
		</div>
		
		<input type="hidden" id="ptg" value=""/> 
		<input type="hidden" id="tgl" value=""/> 
		<input type="hidden" id="fieldPPtg" value=""/> 
		<input type="hidden" id="fieldPTgl" value=""/> 
	    <div id="jendelaBuatSPK" class="easyui-window" title="Modal Window" data-options="modal:true,closed:true,iconCls:'icon-print'" style="width:700px; min-height:400px; padding:5px;">
		</div>
	</div>
</div>
<script type="text/javascript">
	function formatAction(value,row,index){
		if (row.DESA != "TOTAL") {
			if (row.editing){
				var c = '<a href="#" onclick="cancelrow(this)">Batal</a>';
				var s = ' | <a href="#" onclick="saverow(this)">Simpan</a> ';
				return s+c;
			} else {
				var e = '<a href="#" onclick="editrow(this)">Set</a>';
				var d = ' | <a href="#" onclick="if(confirm(&quot;Yakin akan dihapus?&quot;)){resetrow(&quot;'+row.PETUGAS+'&quot;,&quot;'+row.DESA+'&quot;,&quot;'+row.NO_BUKU+'&quot;)}">Hapus</a> ';
				var ptgs = row.PETUGAS + " ";
				var ptgs1 = ptgs.trim();
				if (ptgs1 != ""){
					return e+d;
				} else {
					return e;
				}
			}
		}
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
</script>
<script>
	var pList=[];
	for(var i=0;i<100;i++){
		pList[i]=i+1;
	}
	
	
	$(function(){
		$("#dgRekapPerPtgs").datagrid({
			singleSelect:true,
			checkOnSelect:true,
			collapsible:true,
			pageSize:20,
			pageList:pList,
			toolbar:'#tbOrderAA',
			footer:'#ftOrder',
			url:'<?php echo base_url("index.php/ts/rekap_petugas_ts/rekapPerPtgsTS");?>',
			method:'post',
			onRowContextMenu : function(e,field){
				//e.preventDefault();
				$('#mmUser').menu('show', {
					left: e.pageX,
					top: e.pageY
				});
			},
			
			onClickCell:function(index,field,val){
				$('#fieldPPtg').val(field); 
			},
			onClickRow:function(index,row){
				$('#ptg').val(row.KDPETUGAS);
				showPerTgl();
				$('#totspk').html('0');
			},
			showFooter:true
			
		});
		
	});
	
	$(function(){
		$("#dgRekapPerTgl").datagrid({
			singleSelect:true,
			checkOnSelect:false,
			collapsible:true,
			pageSize:20,
			pageList:pList,
			toolbar:'#tbOrder',
			footer:'#ftOrder',
			url:'<?php echo base_url("index.php/ts/rekap_petugas_ts/rekapPerTglPtgsTS");?>',
			method:'post',
			onDblClickCell: function(index,field,value){
				$(this).datagrid('beginEdit', index);
				var ed = $(this).datagrid('getEditor', {index:index,field:field});
				$(ed.target).focus();
			},
			onRowContextMenu : function(e,field){
				//e.preventDefault();
				$('#mmUser').menu('show', {
					left: e.pageX,
					top: e.pageY
				});
			},
			onClickCell:function(index,field,val){
				$('#fieldPTgl').val(field);
				// alert(field);
			},
			onClickRow:function(index,row){
				$('#ptg').val(row.KDPETUGAS);
				$('#tgl').val(row.TGLSPK);
				// alert(row.PETUGAS);
				showNosal();
			},
			
			onBeforeEdit:function(index,row){
				row.editing = true;
				updateActions(index);
			},
			
			onBeginEdit:function(index,row){
				var editors = $('#dgRekapPerBuku').datagrid('getEditors', index);
				var n1 = $(editors[0].target);
				var n2 = $(editors[1].target);
				var n3 = $(editors[2].target);
				n3.numberbox({
					onChange:function(){
						var cost = row.ORDERS - row.SPK - row.BAYAR - n3.numberbox('getValue');
						n2.numberbox('setValue',cost);
					}
				})
			},
			onAfterEdit:function(index,row){
				row.editing = false;
				updateActions(index);
			},
			onCancelEdit:function(index,row){
				row.editing = false;
				updateActions(index);
			},
			onEndEdit:function(index,row){
				if (row.JMLSPK > (row.ORDERS - row.SPK - row.BAYAR)) {
					toomuch(index,(row.ORDERS - row.SPK - row.BAYAR));
				}
				counts();
			},
			showFooter:true

			
		});
		$.extend($.fn.datagrid.defaults.editors, { 
			numberspinner: {
				init: function(container, options){
					var input = $('<input type="text">').appendTo(container);
					return input.numberspinner(options);
				},
				destroy: function(target){
					$(target).numberspinner('destroy');
				},
				getValue: function(target){
					return $(target).numberspinner('getValue');
				},
				setValue: function(target, value){
					$(target).numberspinner('setValue',value);
				},
				resize: function(target, width){
					$(target).numberspinner('resize',width);
				}
			}
		});
		
	});
	
	function updateActions(index){
		$('#dgRekapPerBuku').datagrid('updateRow',{
			index:index,
			row:{}
		});
	}
	function getRowIndex(target){
		var tr = $(target).closest('tr.datagrid-row');
		return parseInt(tr.attr('datagrid-row-index'));
	}
	function editrow(target){ 
		$('#dgRekapPerBuku').datagrid('beginEdit', getRowIndex(target));
	}
	function resetrow(ptg,desa,buku){ 
		alert(ptg+desa+buku);
		
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/rekap_petugas_ts/resetPenjadwalan", 
			type		: "POST", 
			dataType	: "html",
			data		: {ptg:ptg,desa:desa,buku:buku},
			beforeSend	: function(){
					var win = $.messager.progress({
							title:'Mohon tunggu',
							msg:'Dalam proses...'
						});
			},
			success: function(response){
				$.messager.progress('close'); 
				alert(response);
				$('#dgRekapPerBuku').datagrid('reload');
				$('#dgRekapPerDesa').datagrid('reload');
				
			},
			error: function(){
				alert('error');
			}
		});
	}
	function deleterow(target){
		$.messager.confirm('Confirm','Are you sure?',function(r){
			if (r){
				$('#dgRekapPerBuku').datagrid('deleteRow', getRowIndex(target));
			}
		});
	}
	function saverow(target){
		$('#dgRekapPerBuku').datagrid('endEdit', getRowIndex(target));
	}
	function cancelrow(target){
		$('#dgRekapPerBuku').datagrid('cancelEdit', getRowIndex(target));
	}
	function toomuch(index,val){
		alert("Tidak boleh lebih besar dari sisa");
		$('#dgRekapPerBuku').datagrid('updateRow',{
		index: index,
		row: {
			JMLSPK: val,
			SISA: 0
		}
		});
	}
	function counts(){
		var rows = $('#dgRekapPerBuku').datagrid('getData');
		var totOrd=0;
		var totSpk=0;
		var totByr=0;
		var totSis=0;
		var totSet=0;
		
		var len=rows['rows'].length;
		for(var i=0; i<len ; i++) {
			totOrd = parseInt(totOrd) + parseInt(rows['rows'][i]['ORDERS']);
			totSpk = parseInt(totSpk) + parseInt(rows['rows'][i]['SPK']);
			totByr = parseInt(totByr) + parseInt(rows['rows'][i]['BAYAR']);
			totSis = parseInt(totSis) + parseInt(rows['rows'][i]['SISA']);
			totSet = parseInt(totSet) + parseInt(rows['rows'][i]['JMLSPK']);
		}
		$('#dgRekapPerBuku').datagrid('reloadFooter',[
			{"DESA":"TOTAL","NO_BUKU":"","PETUGAS":"","ORDERS":totOrd,"SPK":totSpk,"BAYAR":totByr,"SISA":totSis,"JMLSPK":totSet,"SET":""}
		]);
	}
	
	$(function(){
		$("#dgOrder").datagrid({
			singleSelect:false,
			checkOnSelect:false,
			collapsible:true,
			pageSize:20,
			pageList:pList,
			toolbar:'#tbOrder',
			footer:'#ftOrder',
			url:'<?php echo base_url("index.php/ts/rekap_petugas_ts/daftarOrderTS");?>',
			method:'post',
			onRowContextMenu : function(e,field){
				//e.preventDefault();
				$('#mmUser').menu('show', {
					left: e.pageX,
					top: e.pageY
				});
			},
			rowStyler:function(index,row){
				// if (row.TGL_SPK != ''){
					// return 'background-color:cyan;color:black;';
				// }if (index == '9'){
					// return 'text-align:right';
				// }
			}
		});
		
	});
	
	function showPerTgl(){
		var ptg = $('#ptg').val();
		var field = $('#fieldPPtg').val();
		$('#dgRekapPerTgl').datagrid('load',{
			petugas: ptg,
			field: field,
			tglJadwal: $('#formFilterOrderAA #datebox').datebox('getValue')
		});
	}
	
	function showNosal(){
		var ptg = $('#ptg').val();
		var tgl = $('#tgl').val();
		var field = $('#fieldPPtg').val();
		var field2 = $('#fieldPTgl').val();
		
		// alert(ptg+tgl);
		$('#dgOrder').datagrid('load',{
			petugas: ptg,
			tgl: tgl,
			field: field,
			field2: field2
		});
	
	}
	
	function pencarian(){
		$('#dgOrder').datagrid('load',{
			jadwal: $('#filterJadwalOrder').combobox('getValue'),
			desa: $('#filterDesaOrder').combobox('getValue')
		});
	}
	
	function filterTgl(){
		$('#dgRekapPerPtgs').datagrid('load',{
			tglJadwal: $('#datebox').datebox('getValue')
		});
	}
	
	function buatSPK(){
		var rows = $('#dgOrder').datagrid('getChecked');
		var target = "#jendelaBuatSPK";
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/rekap_petugas_ts/formBuatSPK", 
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
				$('#txtDate').datebox('setValue', '<?php  echo date("d/m/Y"); ?>');
			},
			error: function(){
				alert('error');
			},
		});
	}
	
	function simpanPenjadwalan(){
		var datebox = $('#datebox').datebox('getValue');
		//alert(datebox);
		var rows = $('#dgRekapPerBuku').datagrid('getData');
		var target = "#jendelaBuatSPK";
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/rekap_petugas_ts/simpanPenjadwalan", 
			type		: "POST", 
			dataType	: "html",
			data		: {selected:rows,datebox:datebox},
			beforeSend	: function(){
					var win = $.messager.progress({
							title:'Mohon tunggu',
							msg:'Menyimpan SPK'
						});
			},
			success: function(response){
				$.messager.progress('close'); 
				alert(response);
				$('#dgRekapPerBuku').datagrid('reload');
				$('#dgRekapPerDesa').datagrid('reload');
				
			},
			error: function(){
				alert('error');
			},
		});
	}
	
</script>