<div class="easyui-layout" data-options="fit:true">
	<div data-options="region:'north'">
		<div class="pageTitle">Laporan SPK Tutup Sementara</div>
	</div>
	<div data-options="region:'center'" style="padding:5px;">
		<div id="w2" class="easyui-window" data-options="title:'Daftar SPK',inline:true,collapsible:false,minimizable:false,maximizable:false,closable:false" style="width:300px;height:300px;padding:0px; text-align:center;">
			<table style="width:98%; padding:5%; text-align:left;">
				<tr>
					<td>
					Periode : 
					<select class="easyui-combobox" id="periode2" style="width:100%; height:28px;">
					<?php
						echo($listPeriode);
					?>
					</select>
					</td>
				</tr>
				<tr>
					<td>
					MULAI : 
					<input class="easyui-datebox" required style="width:100%; height:28px;" id="tglAw2">
					</td>
				</tr>
				<tr>
					<td>
					HINGGA : 
					<input class="easyui-datebox" required style="width:100%; height:28px;" id="tglAk2">
					</td>
				</tr>
				<tr>
					<td>
					TAMPILKAN : 
					<select class="easyui-combobox" id="modeTampilan2" style="width:100%; height:28px;">
					<?php
						echo($listModeTampilan);
					?>
					</select>
					</td>
				</tr>
				<tr align="center">
					<td>
					<br/>
					<a href="#" class="easyui-linkbutton c1" onclick="filterPeriode()"><i class="fa fa-check-square-o"></i> TAMPILKAN LAPORAN &nbsp;</a>
					</td>
				</tr>
			</table>
        </div>
	</div>
</div>
<script>
	function filterPeriode(){
		var periode = $("#periode2").combobox('getValue');
		var tglAW = $("#tglAw2").datebox('getValue');
		var tglAK = $("#tglAk2").datebox('getValue');
		var dateAr = tglAW.split('/');
		tglAW = dateAr[2] + dateAr[1] + dateAr[0];
		//tglAW = tglAW.replace(/\//g, '');
		dateAr = tglAK.split('/');
		tglAK = dateAr[2] + dateAr[1] + dateAr[0];
		//tglAK = tglAK.replace(/\//g, '');
		
		var mode = $("#modeTampilan2").combobox('getValue');
		var win = window.open('<?php echo base_url('index.php/ts/laporan_ts/daftarSPK/') ?>/'+periode+'/'+tglAW+'/'+tglAK+'/'+mode, '_blank');
		win.focus();
	}
	$('.easyui-datebox').datebox({
		formatter : function(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return (d<10?('0'+d):d)+'/'+(m<10?('0'+m):m)+'/'+y;
		},
		parser : function(s){

			if (!s) return new Date();
			var ss = s.split('/');
			var y = parseInt(ss[2],10);
			var m = parseInt(ss[1],10);
			var d = parseInt(ss[0],10);
			if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
				return new Date(y,m-1,d)
			} else {
				return new Date();
			}
		}
	});
</script>