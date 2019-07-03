<div class="easyui-layout" data-options="fit:true">
	<div data-options="region:'north'">
		<div class="pageTitle">Master Bagian</div>
	</div>
	
	<div data-options="region:'center'" style="padding:5px;">
		<table id="dgBagian" style="width:100%;height:100%;" title="Bagian" rownumbers="true" pagination="false">
			<thead>
				<tr>
					<th data-options="field:'Kd_Bag'" width="7%">Kode</th>
					<th data-options="field:'Nama_Bag'" editor="{type:'textbox'}" width="20%">Nama</th>
					<th data-options="field:'SET'" formatter="formatAction" field="productid" width="15%">Set</th>
				</tr>
			</thead>
		</table>
		
		<div id="tbBagian" style="padding:5px;">
			    <div class="easyui-layout" style="width:100%; height:36px;">
					<div data-options="region:'center'" style="padding:4px;">
						<a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="tambahBagian()">Tambah Bagian</a>
					</div>
				</div>
		</div>
		<input type="hidden" id="col" value=""/>
		<input type="hidden" id="row" value=""/>
		<input type="hidden" id="jen" value=""/>
		<input type="hidden" id="fieldPB" value=""/> 
	    <div id="jendelaTambahBagian" class="easyui-window" title="Modal Window" data-options="modal:true,closed:true,iconCls:'icon-print'" style="width:400px; min-height:200px; padding:5px;">
		</div>
	</div>
</div>
<script type="text/javascript">
	function formatAction(value,row,index){
			if (row.editing){
				var c = '<a href="#" onclick="cancelrow(this)">Batal</a>';
				var s = ' | <a href="#" onclick="saverow(this)">Simpan</a> ';
				return s+c;
			} else {
				var e = '<a href="#" onclick="editrow(this)">Set</a>';
				var d = ' | <a href="#" onclick="if(confirm(&quot;Yakin akan dihapus?&quot;)){resetrow(&quot;'+row.Kd_Bag+'&quot;,&quot;'+row.Nama_Bag+'&quot;)}">Hapus</a> ';
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
		$("#dgBagian").datagrid({
			singleSelect:true,
			checkOnSelect:false,
			collapsible:true,
			pageSize:20,
			pageList:pList,
			toolbar:'#tbBagian',
			footer:'#ftBagian',
			url:'<?php echo base_url("index.php/ts/bagian_ts/daftarBagian");?>',
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
			onBeforeEdit:function(index,row){
				row.editing = true;
				updateActions(index);
			},
			
			onBeginEdit:function(index,row){
				var editors = $('#dgBagian').datagrid('getEditors', index);
				var n1 = $(editors[0].target);
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
				updaterow(row.Kd_Bag,row.Nama_Bag);
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
	
	function updateActions(index){
		$('#dgBagian').datagrid('updateRow',{
			index:index,
			row:{}
		});
	}
	function getRowIndex(target){
		var tr = $(target).closest('tr.datagrid-row');
		return parseInt(tr.attr('datagrid-row-index'));
	}
	function editrow(target){ 
		$('#dgBagian').datagrid('beginEdit', getRowIndex(target));
	}
	function updaterow(kd,nama){ 
		// alert(nama);
		
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/bagian_ts/ubahBagian",
			type		: "POST", 
			dataType	: "html",
			data		: {kd:kd,nama:nama},
			success: function(response){
				$('#dgBagian').datagrid('reload');
			},
			error: function(){
				alert('error');
			}
		});
	}
	function resetrow(kd,nama){ 
		// alert(nama);
		
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/bagian_ts/hapusBagian", 
			type		: "POST", 
			dataType	: "html",
			data		: {kd:kd},
			beforeSend	: function(){
					var win = $.messager.progress({
							title:'Mohon tunggu',
							msg:'Dalam proses...'
						});
			},
			success: function(response){
				$.messager.progress('close'); 
				alert(response);
				$('#dgBagian').datagrid('reload');
			},
			error: function(){
				alert('error');
			}
		});
	}
	function deleterow(target){
		$.messager.confirm('Confirm','Are you sure?',function(r){
			if (r){
				$('#dgBagian').datagrid('deleteRow', getRowIndex(target));
			}
		});
	}
	function saverow(target){
		$('#dgBagian').datagrid('endEdit', getRowIndex(target));
	}
	function cancelrow(target){
		$('#dgBagian').datagrid('cancelEdit', getRowIndex(target));
	}
	
	function tambahBagian(){
		var target = "#jendelaTambahBagian";
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/bagian_ts/formTambahBagian", 
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
	
</script>