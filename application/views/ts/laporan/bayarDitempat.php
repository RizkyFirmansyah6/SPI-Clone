<div class="easyui-layout" data-options="fit:true">
	<div data-options="region:'north'">
		<div class="pageTitle">Rekap Bayar Ditempat</div>
	</div>
	<div data-options="region:'center'" style="padding:5px;">
		<table class="" id="dgRekapBS" style="height:100%">
			<thead>
				<tr>
					<th data-options="field:'id_petugas'" width="5%">ID</th>
					<th data-options="field:'petugas'" width="15%">PETUGAS</th>
					<th data-options="field:'jml_rek'" width="8%">REKENING</th>
					<th data-options="field:'jml_nosal'" width="8%">NOSAL</th>
					<th data-options="field:'air'" width="8%">AIR</th>
					<th data-options="field:'non_air'" width="8%">NON AIR</th>
					<th data-options="field:'total'" width="8%">TOTAL</th>
					<th data-options="field:'blm_verifikasi'" width="10%">BELUM VERIFIKASI</th>
					<th data-options="field:'verifikasi'" width="10%">TERVERIFIKASI</th>
					<th data-options="field:'tgl_verifikasi'" width="10%">TGL VERIFIKASI</th>
					<th data-options="field:'verifikator'" width="15%">USER VERIFIKASI</th>
				</tr>
			</thead>
		</table>
		<div id="tbRekapBS" style="padding:5px;">
			    <div class="easyui-layout" style="width:100%; height:36px;">
					<div data-options="region:'center'" style="padding:4px;">
						Periode : 
						<input class="easyui-datebox" style="width:10%; height:28px;" 
						name='tgl_bayar' id="tgl_bayar" value="<?php echo date('d-M-Y'); ?>">
						<a href="#" class="easyui-linkbutton c1" onclick="filterPeriode()"><i class="fa fa-check-square-o"></i> OK &nbsp;</a>
						<a href="#" class="easyui-linkbutton c2" onclick="cetakLaporan()"><i class="fa fa-excel"></i> PDF &nbsp;</a>
					</div>
					</div>
				</div>
		</div>
	</div>
</div>
<script>
	var base_url = "<?php print base_url(); ?>";
	$(function(){
		$("#dgRekapBS").datagrid({
			singleSelect:true,
			toolbar:'#tbRekapBS',
			method:'post',
			url:'<?php echo base_url("index.php/ts/laporan_ts/getBayarDitempat");?>'
		});
	});
	function filterPeriode(){
		$('#dgRekapBS').datagrid('load',{
			tgl_bayar: $('#tgl_bayar').datebox('getValue')
		});
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
	
	function cetakLaporan(){
	    var tgl_bayar = $('#tgl_bayar').datebox('getValue').replace("/","~").replace("/","~").replace("/","~").replace("/","~");
        PopupCenter(base_url+"index.php/ts/laporan_ts/laporanRekapBayarDitempat/"+tgl_bayar,"LAPORAN PENERIMAAN BAYAR DITEMPAT","800","400");
    	
	} 
	
	 
	function PopupCenter(url, title, w, h) {
        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    }
	
</script>