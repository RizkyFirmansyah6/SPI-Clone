<div class="easyui-layout" data-options="fit:true">
	<div data-options="region:'north'">
		<div class="pageTitle">Program Tahunan</div>
	</div>
	
	<div data-options="region:'center'" style="padding:5px;">
		<table id="dgProgramTahunan" style="width:100%;height:50%;" title="Program Tahunan" rownumbers="true" pagination="true">
			<thead>
				<tr>
					<th data-options="field:'Nomor'" width="15%">Nomor</th>
					<th data-options="field:'Obyek'" width="15%">Obyek</th>
					<th data-options="field:'Ruang_Lingkup'" width="20%">Ruang Lingkup</th>
					<th data-options="field:'Dasar'" width="12%">Dasar Audit/Monev</th>
					<th data-options="field:'Program'" width="7%">Program</th>
					<th data-options="field:'Jenis'" width="7%">Jenis</th>
					<th data-options="field:'No_Tugas'" width="10%">Nomor Tugas</th>
					<th data-options="field:'Tahun'" width="10%">Tahun</th>
				</tr>
			</thead>
		</table>
		<table id="dgAuditorProgram" style="width:100%;height:35%;" title="Auditor" rownumbers="true" pagination="false" idField="No_PKPT">
			<thead>
				<tr>
					<th field="No_PKPT" width="7%">No_PKPT</th>
					<th data-options="field:'Nama'" editor="{type:'combobox',id:'petugasSPK',options:{url:'<?php echo base_url("index.php/ts/kelola_spi_ts/daftarSemuaAuditor");?>',valueField:'NIP',textField:'Nama'}}" width="20%">Nama Lengkap</th>
					<th data-options="field:'Jabatan'" width="7%">Jabatan</th>
					<th data-options="field:'Index_Karyawan'" align="right"  width="10%">Index</th>
					<th data-options="field:'SET'" formatter="formatAudit" field="productid" width="7%">Set</th>
				</tr>
			</thead>
		</table>
		<table id="dgSasaran" style="width:100%;height:50%;" title="Sasaran Program Tahunan" rownumbers="true" pagination="true">
			<thead>
				<tr>
					<th data-options="field:'Urut_Sasaran'" width="5%">No Urut</th>
					<th data-options="field:'Isi_Sasaran'" width="85%">Isi</th>
				</tr>
			</thead>
		</table>
		<table id="dgTujuan" style="width:100%;height:50%;" title="Tujuan Program Tahunan" rownumbers="true" pagination="true">
			<thead>
				<tr>
					<th data-options="field:'Urut_Tujuan'" width="5%">No Urut</th>
					<th data-options="field:'Isi_Tujuan'" width="85%">Isi</th>
				</tr>
			</thead>
		</table>
		
		<div id="tbTahunan" style="padding:5px;">
			    <div class="easyui-layout" style="width:100%; height:36px;">
					<div data-options="region:'east'" style="width:620px; text-align:left; padding:4px;">
						<form id="formFilterTahunan">
						
						Tahun&nbsp; : &nbsp;&nbsp;	
						<input class="easyui-combobox" id="filterTahunTahunan"
							name="language"
							data-options="
									url:'<?php echo base_url("index.php/ts/kelola_spi_ts/daftarTahun");?>',
									method:'post',
									valueField:'Kd_Tahun',
									textField:'Tahun',
									width:70,
									panelHeight:300,
							">
						
						&nbsp;&nbsp;&nbsp;&nbsp;	
						Program&nbsp; : &nbsp;&nbsp;
						<input class="easyui-combobox" id="filterProgramTahunan"
							name="language"
							data-options="
									url:'<?php echo base_url("index.php/ts/kelola_spi_ts/daftarProgram");?>',
									method:'post',
									valueField:'Kd_Program',
									textField:'Nama_Program',
									width:85,
									panelHeight:300
							">
						&nbsp;&nbsp;&nbsp;&nbsp;	
						Jenis&nbsp; : &nbsp;&nbsp;
						<input class="easyui-combobox" id="filterJenisTahunan"
							name="language"
							data-options="
									url:'<?php echo base_url("index.php/ts/kelola_spi_ts/daftarJenis");?>',
									method:'post',
									valueField:'Kd_Jenis',
									textField:'Nama_Jenis',
									width:90,
									panelHeight:300
							">
						<a href="#" class="easyui-linkbutton" iconCls="icon-clear" onclick="$('#formFilterTahunan').form('clear');">CLEAR FILTER</a>
						<a href="#" class="easyui-linkbutton c1" iconCls="icon-search" onclick="pencarian()">CARI</a>
						</form>
					</div>
					<div data-options="region:'center'" style="padding:4px;">
						<a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="tambahProgThn()">Tambah Program Tahunan</a>
					</div>
				</div>
		</div>
		<input type="hidden" id="row" value=""/>
		<input type="hidden" id="des" value=""/>
		<input type="hidden" id="buk" value=""/> 
		<input type="hidden" id="ptg" value=""/> 
		<input type="hidden" id="fieldPB" value=""/> 
	    <div id="jendelaBuatProgramTahunan" class="easyui-window" title="Modal Window" data-options="modal:true,closed:true,iconCls:'icon-print'" style="width:1000px; min-height:600px; padding:5px;">
		</div>
	</div>
</div>
<script type="text/javascript">
	function formatAudit(value,row,index){
		if (row.editing){
			var c = '<a href="#" onclick="cancelaudit(this)">Batal</a>';
			var s = ' | <a href="#" onclick="saveaudit(this)">Simpan</a> ';
			return s+c;
		} else {
			var e = '<a href="#" onclick="editaudit(this)">Set</a>';
			var d = ' | <a href="#" onclick="if(confirm(&quot;Yakin akan dihapus?&quot;)){resetrow(&quot;'+row.PETUGAS+'&quot;,&quot;'+row.DESA+'&quot;,&quot;'+row.NO_BUKU+'&quot;)}">Hapus</a> ';
			return e+d;
		}
	}
</script>
<script>
	var pList=[];
	for(var i=0;i<100;i++){
		pList[i]=i+1;
	}
	
	
	$(function(){
		$("#dgProgramTahunan").datagrid({
			singleSelect:true,
			checkOnSelect:false,
			collapsible:true,
			pageSize:20,
			pageList:pList,
			toolbar:'#tbTahunan',
			footer:'#ftTahunan',
			url:'<?php echo base_url("index.php/ts/kelola_spi_ts/daftarSPITS");?>',
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
				$('#row').val(row.Nomor);
				//alert(row.KODE);
				showAuditor();
				showSasaran();
				showTujuan();
			},
			showFooter:true
			
		});
		
	});

	$(function(){
		$("#dgAuditorProgram").datagrid({
			singleSelect:true,
			checkOnSelect:false,
			collapsible:true,
			pageSize:20,
			pageList:pList,
			toolbar:'#tbAuditor',
			footer:'#ftAuditor',
			url:'<?php echo base_url("index.php/ts/kelola_spi_ts/daftarAuditor");?>',
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
				$('#fieldPB').val(field);
				// alert(index+field+val);
			},
			onClickRow:function(index,row){
				
			},
			
			onBeforeEdit:function(index,row){
				row.editing = true;
				updateAudit(index);
			},
			
			onBeginEdit:function(index,row){
				var editors = $('#dgAuditorProgram').datagrid('getEditors', index);
				var n1 = $(editors[0].target);
				// var n2 = $(editors[1].target);
			},
			onAfterEdit:function(index,row){
				row.editing = false;
				updateAudit(index);
			},
			onCancelEdit:function(index,row){
				row.editing = false;
				updateAudit(index);
			},
			onEndEdit:function(index,row){
				
			},
			showFooter:false

			
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

	$(function(){
		$("#dgSasaran").datagrid({
			singleSelect:true,
			checkOnSelect:false,
			collapsible:true,
			pageSize:20,
			pageList:pList,
			toolbar:'#tbSasaran',
			footer:'#ftSasaran',
			url:'<?php echo base_url("index.php/ts/kelola_spi_ts/daftarSasaran");?>',
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
				$('#fieldPB').val(field);
				// alert(index+field+val);
			},
			onClickRow:function(index,row){
				
			},
			
			onBeforeEdit:function(index,row){
				row.editing = true;
				updateAudit(index);
			},
			
			onBeginEdit:function(index,row){
				var editors = $('#dgAuditorProgram').datagrid('getEditors', index);
				var n1 = $(editors[0].target);
				// var n2 = $(editors[1].target);
			},
			onAfterEdit:function(index,row){
				row.editing = false;
				updateAudit(index);
			},
			onCancelEdit:function(index,row){
				row.editing = false;
				updateAudit(index);
			},
			onEndEdit:function(index,row){
				
			},
			showFooter:false

			
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

	$(function(){
		$("#dgTujuan").datagrid({
			singleSelect:true,
			checkOnSelect:false,
			collapsible:true,
			pageSize:20,
			pageList:pList,
			toolbar:'#tbTujuan',
			footer:'#ftTujuan',
			url:'<?php echo base_url("index.php/ts/kelola_spi_ts/daftarTujuan");?>',
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
				$('#fieldPB').val(field);
				// alert(index+field+val);
			},
			onClickRow:function(index,row){
				
			},
			
			onBeforeEdit:function(index,row){
				row.editing = true;
				updateAudit(index);
			},
			
			onBeginEdit:function(index,row){
				var editors = $('#dgAuditorProgram').datagrid('getEditors', index);
				var n1 = $(editors[0].target);
				// var n2 = $(editors[1].target);
			},
			onAfterEdit:function(index,row){
				row.editing = false;
				updateAudit(index);
			},
			onCancelEdit:function(index,row){
				row.editing = false;
				updateAudit(index);
			},
			onEndEdit:function(index,row){
				
			},
			showFooter:false

			
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
	
	// $(function(){
	// 	$("#dgRekapPerBuku").datagrid({
	// 		singleSelect:true,
	// 		checkOnSelect:false,
	// 		collapsible:true,
	// 		pageSize:20,
	// 		pageList:pList,
	// 		toolbar:'#tbSPI',
	// 		footer:'#ftSPI',
	// 		url:'<?php echo base_url("index.php/ts/order_ts/rekapPerBukuOrderTS");?>',
	// 		method:'post',
	// 		onDblClickCell: function(index,field,value){
	// 			$(this).datagrid('beginEdit', index);
	// 			var ed = $(this).datagrid('getEditor', {index:index,field:field});
	// 			$(ed.target).focus();
	// 		},
	// 		onRowContextMenu : function(e,field){
	// 			//e.preventDefault();
	// 			$('#mmUser').menu('show', {
	// 				left: e.pageX,
	// 				top: e.pageY
	// 			});
	// 		},
	// 		onClickCell:function(index,field,val){
	// 			$('#fieldPB').val(field);
	// 			// alert(index+field+val);
	// 		},
	// 		onClickRow:function(index,row){
	// 			$('#des').val(row.DESA);
	// 			$('#buk').val(row.NO_BUKU);
	// 			$('#ptg').val(row.PETUGAS);
	// 			// alert(row.PETUGAS);
	// 			showNosal();
	// 		},
			
	// 		onBeforeEdit:function(index,row){
	// 			row.editing = true;
	// 			updateActions(index);
	// 		},
			
	// 		onBeginEdit:function(index,row){
	// 			var editors = $('#dgRekapPerBuku').datagrid('getEditors', index);
	// 			var n1 = $(editors[0].target);
	// 			var n2 = $(editors[1].target);
	// 			var n3 = $(editors[2].target);
	// 			n3.numberbox({
	// 				onChange:function(){
	// 					var cost = row.ORDERS - row.SPK - row.BAYAR - n3.numberbox('getValue');
	// 					n2.numberbox('setValue',cost);
	// 				}
	// 			})
	// 		},
	// 		onAfterEdit:function(index,row){
	// 			row.editing = false;
	// 			updateActions(index);
	// 		},
	// 		onCancelEdit:function(index,row){
	// 			row.editing = false;
	// 			updateActions(index);
	// 		},
	// 		onEndEdit:function(index,row){
	// 			if (row.JMLSPK > (row.ORDERS - row.SPK - row.BAYAR)) {
	// 				toomuch(index,(row.ORDERS - row.SPK - row.BAYAR));
	// 			}
	// 			counts();
	// 		},
	// 		showFooter:true

			
	// 	});
	// 	$.extend($.fn.datagrid.defaults.editors, { 
	// 		numberspinner: {
	// 			init: function(container, options){
	// 				var input = $('<input type="text">').appendTo(container);
	// 				return input.numberspinner(options);
	// 			},
	// 			destroy: function(target){
	// 				$(target).numberspinner('destroy');
	// 			},
	// 			getValue: function(target){
	// 				return $(target).numberspinner('getValue');
	// 			},
	// 			setValue: function(target, value){
	// 				$(target).numberspinner('setValue',value);
	// 			},
	// 			resize: function(target, width){
	// 				$(target).numberspinner('resize',width);
	// 			}
	// 		}
	// 	});
		
	// });
	
	function updateAudit(index){
		$('#dgAuditorProgram').datagrid('updateRow',{
			index:index,
			row:{}
		});
	}
	function getRowIndex(target){
		var tr = $(target).closest('tr.datagrid-row');
		return parseInt(tr.attr('datagrid-row-index'));
	}
	function editaudit(target){ 
		$('#dgAuditorProgram').datagrid('beginEdit', getRowIndex(target));
	}
	// function resetrow(ptg,desa,buku){ 
	// 	alert(ptg+desa+buku);
		
	// 	$.ajax({
	// 		url			: "<?php echo base_url(); ?>"+"index.php/ts/order_ts/resetPenjadwalan", 
	// 		type		: "POST", 
	// 		dataType	: "html",
	// 		data		: {ptg:ptg,desa:desa,buku:buku},
	// 		beforeSend	: function(){
	// 				var win = $.messager.progress({
	// 						title:'Mohon tunggu',
	// 						msg:'Dalam proses...'
	// 					});
	// 		},
	// 		success: function(response){
	// 			$.messager.progress('close'); 
	// 			alert(response);
	// 			$('#dgRekapPerBuku').datagrid('reload');
	// 			$('#dgRekapPerDesa').datagrid('reload');
				
	// 		},
	// 		error: function(){
	// 			alert('error');
	// 		}
	// 	});
	// }
	// function deleterow(target){
	// 	$.messager.confirm('Confirm','Are you sure?',function(r){
	// 		if (r){
	// 			$('#dgRekapPerBuku').datagrid('deleteRow', getRowIndex(target));
	// 		}
	// 	});
	// }
	function saveaudit(target){
		$('#dgAuditorProgram').datagrid('endEdit', getRowIndex(target));
	}
	function cancelaudit(target){
		$('#dgAuditorProgram').datagrid('cancelEdit', getRowIndex(target));
	}
	// function toomuch(index,val){
	// 	alert("Tidak boleh lebih besar dari sisa");
	// 	$('#dgRekapPerBuku').datagrid('updateRow',{
	// 	index: index,
	// 	row: {
	// 		JMLSPK: val,
	// 		SISA: 0
	// 	}
	// 	});
	// }
	// function counts(){
	// 	var rows = $('#dgRekapPerBuku').datagrid('getData');
	// 	var totOrd=0;
	// 	var totSpk=0;
	// 	var totByr=0;
	// 	var totSis=0;
	// 	var totSet=0;
		
	// 	var len=rows['rows'].length;
	// 	for(var i=0; i<len ; i++) {
	// 		totOrd = parseInt(totOrd) + parseInt(rows['rows'][i]['ORDERS']);
	// 		totSpk = parseInt(totSpk) + parseInt(rows['rows'][i]['SPK']);
	// 		totByr = parseInt(totByr) + parseInt(rows['rows'][i]['BAYAR']);
	// 		totSis = parseInt(totSis) + parseInt(rows['rows'][i]['SISA']);
	// 		totSet = parseInt(totSet) + parseInt(rows['rows'][i]['JMLSPK']);
	// 	}
	// 	$('#dgRekapPerBuku').datagrid('reloadFooter',[
	// 		{"DESA":"TOTAL","NO_BUKU":"","PETUGAS":"","ORDERS":totOrd,"SPK":totSpk,"BAYAR":totByr,"SISA":totSis,"JMLSPK":totSet,"SET":""}
	// 	]);
	// }
	
	// $(function(){
	// 	$("#dgOrder").datagrid({
	// 		singleSelect:false,
	// 		checkOnSelect:false,
	// 		collapsible:true,
	// 		pageSize:20,
	// 		pageList:pList,
	// 		toolbar:'#tbOrder',
	// 		footer:'#ftOrder',
	// 		url:'<?php echo base_url("index.php/ts/order_ts/daftarOrderTS");?>',
	// 		method:'post',
	// 		onRowContextMenu : function(e,field){
	// 			//e.preventDefault();
	// 			$('#mmUser').menu('show', {
	// 				left: e.pageX,
	// 				top: e.pageY
	// 			});
	// 		},
	// 		rowStyler:function(index,row){
	// 			// if (row.TGL_SPK != ''){
	// 				// return 'background-color:cyan;color:black;';
	// 			// }if (index == '9'){
	// 				// return 'text-align:right';
	// 			// }
	// 		}
	// 	});
		
	// });
	
	function showAuditor(){
		var row = $('#row').val();
		$('#dgAuditorProgram').datagrid('load',{
			Nomor: row
		});
	}

	function showSasaran(){
		var row = $('#row').val();
		$('#dgSasaran').datagrid('load',{
			Nomor: row
		});
	}
	
	function showTujuan(){
		var row = $('#row').val();
		$('#dgTujuan').datagrid('load',{
			Nomor: row
		});
	}
	
	function pencarian(){
		$('#dgProgramTahunan').datagrid('load',{
			tahun: $('#filterTahunTahunan').combobox('getValue'),
			program: $('#filterProgramTahunan').combobox('getValue'),
			jenis: $('#filterJenisTahunan').combobox('getValue')
		});
	}
	
	function tambahProgThn(){
		var target = "#jendelaBuatProgramTahunan";
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/kelola_spi_ts/formTambahProgram", 
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
			},
		});
	}
	
	// function simpanPenjadwalan(){
	// 	var datebox = $('#datebox').datebox('getValue');
	// 	//alert(datebox);
	// 	var rows = $('#dgRekapPerBuku').datagrid('getData');
	// 	var target = "#jendelaBuatSPK";
	// 	$.ajax({
	// 		url			: "<?php echo base_url(); ?>"+"index.php/ts/order_ts/simpanPenjadwalan", 
	// 		type		: "POST", 
	// 		dataType	: "html",
	// 		data		: {selected:rows,datebox:datebox},
	// 		beforeSend	: function(){
	// 				var win = $.messager.progress({
	// 						title:'Mohon tunggu',
	// 						msg:'Menyimpan SPK'
	// 					});
	// 		},
	// 		success: function(response){
	// 			$.messager.progress('close'); 
	// 			alert(response);
	// 			$('#dgRekapPerBuku').datagrid('reload');
	// 			$('#dgRekapPerDesa').datagrid('reload');
				
	// 		},
	// 		error: function(){
	// 			alert('error');
	// 		},
	// 	});
	// }
	
</script>