<div class="easyui-layout" data-options="fit:true">
	<div data-options="region:'north'">
		<div class="pageTitle">Master Auditor</div>
	</div>
	
	<div data-options="region:'center'" style="padding:5px;">
		<table id="dgAuditor" style="width:100%;height:100%;" title="Auditor" rownumbers="true" pagination="false">
			<thead>
				<tr>
					<th data-options="field:'No_PKPT'" width="10%">No PKPT</th>
					<th data-options="field:'Nama'" editor="{type:'textbox'}" width="50%">Nama Lengkap</th>
					<th data-options="field:'SET'" formatter="formatAction" field="productid" width="15%">Set</th>
				</tr>
			</thead>
		</table>
		
		<div id="tbAuditor" style="padding:5px;">
			    <div class="easyui-layout" style="width:100%; height:36px;">
					<div data-options="region:'center'" style="padding:4px;">
						<a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="tambahAuditor()">Tambah Auditor</a>
					</div>
				</div>
		</div>
		<input type="hidden" id="col" value=""/>
		<input type="hidden" id="row" value=""/>
		<input type="hidden" id="jen" value=""/>
		<input type="hidden" id="fieldPB" value=""/> 
	    <div id="jendelaTambahAuditor" class="easyui-window" title="Modal Window" data-options="modal:true,closed:true,iconCls:'icon-print'" style="width:550px; min-height:300px; padding:5px;">
		</div>
	</div>
</div>
<script type="text/javascript">
	function formatAction(value,row,index){
			var d = '<a href="#" onclick="if(confirm(&quot;Yakin akan dihapus?&quot;)){resetrow(&quot;'+row.No_PKPT+'&quot;)}">Hapus</a> ';
			return d;
	}
</script>
<script>
	var pList=[];
	for(var i=0;i<100;i++){
		pList[i]=i+1;
	}
	$(function(){
		$("#dgAuditor").datagrid({
			singleSelect:true,
			checkOnSelect:false,
			collapsible:true,
			pageSize:20,
			pageList:pList,
			toolbar:'#tbAuditor',
			footer:'#ftAuditor',
			url:'<?php echo base_url("index.php/ts/auditor_ts/daftarAuditor");?>',
			method:'post',
			onDblClickCell: function(index,field,value){
				// $(this).datagrid('beginEdit', index);
				// var ed = $(this).datagrid('getEditor', {index:index,field:field});
				// $(ed.target).focus();
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
				var editors = $('#dgAuditor').datagrid('getEditors', index);
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
				updaterow(row.No_PKPT,row.NIP);
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
		$('#dgAuditor').datagrid('updateRow',{
			index:index,
			row:{}
		});
	}
	function getRowIndex(target){
		var tr = $(target).closest('tr.datagrid-row');
		return parseInt(tr.attr('datagrid-row-index'));
	}
	function editrow(target){ 
		$('#dgAuditor').datagrid('beginEdit', getRowIndex(target));
	}
	
	function resetrow(nopkpt){ 
		// alert(nama);
		
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/auditor_ts/hapusAuditor", 
			type		: "POST", 
			dataType	: "html",
			data		: {nopkpt:nopkpt},
			beforeSend	: function(){
					var win = $.messager.progress({
							title:'Mohon tunggu',
							msg:'Dalam proses...'
						});
			},
			success: function(response){
				$.messager.progress('close'); 
				alert(response);
				$('#dgAuditor').datagrid('reload');
			},
			error: function(){
				alert('error');
			}
		});
	}
	function deleterow(target){
		$.messager.confirm('Confirm','Are you sure?',function(r){
			if (r){
				$('#dgAuditor').datagrid('deleteRow', getRowIndex(target));
			}
		});
	}
	function saverow(target){
		$('#dgAuditor').datagrid('endEdit', getRowIndex(target));
	}
	function cancelrow(target){
		$('#dgAuditor').datagrid('cancelEdit', getRowIndex(target));
	}
	
	function tambahAuditor(){
		var target = "#jendelaTambahAuditor";
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/auditor_ts/formTambahAuditor", 
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