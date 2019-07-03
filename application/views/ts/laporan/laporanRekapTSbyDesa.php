<div class="easyui-layout" data-options="fit:true">
	<div data-options="region:'north'">
		<div class="pageTitle">Rekap Tutup Sementara per Desa</div>
	</div>
	<div data-options="region:'center'" style="padding:5px;">
				<div id="tbRekapBS" style="">
					<div class="easyui-layout" style="width:100%; height:36px;">
						<div data-options="region:'center'" style="padding:4px;">
							Periode : 
							<select class="easyui-combobox" id="tesCC2" style="width:200px; height:28px;">
							<?php
								echo($listPeriode);
							?>
							</select>
							<a href="#" class="easyui-linkbutton c1" onclick="filterPeriodeByDesa()"><i class="fa fa-check-square-o"></i> OK &nbsp;</a>
							<a href="#" class="easyui-linkbutton c2" onclick="$('#dgRekapBS').datagrid('reload')"><i class="fa fa-refresh"></i> PDF &nbsp;</a>
							<a href="#" class="easyui-linkbutton c2" onclick="$('#dgRekapBS').datagrid('reload')"><i class="fa fa-refresh"></i> EXCL &nbsp;</a>
						</div>
					</div>
				</div>
		<div id="targetToLoad"></div>
	</div>
</div>
<script>
	function filterPeriodeByDesa(){
		var target = "#targetToLoad";
		var periode = $('#tesCC2').combobox('getValue');
		$.ajax({
			url			: "<?php echo base_url(); ?>"+"index.php/ts/laporan_ts/daftarRekapTSbyDesa", 
			type		: "POST", 
			dataType	: "html",
			data		: {selected:periode},
			beforeSend	: function(){
				$(target).html('Loading . . . ');
			},
			success: function(response){
				$(target).html(response);
			},
			error: function(){
				alert('error');
			},
		});
	}
</script>