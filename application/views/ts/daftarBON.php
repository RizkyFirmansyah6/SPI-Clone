<div style="padding-bottom:5px;">
	<a href="#" class="easyui-linkbutton c1" onclick="formBPB()"><i class="fa fa-plus"></i> BUAT BON</a>
</div>
    <table class="easyui-datagrid" style="width:100%;"
            data-options="
                singleSelect:true,
                rownumbers:true,
                fitColumns:true,  
				view:groupview,
                groupField:'nomor',
                groupFormatter:function(value,rows){
                    return value + ' terdapat ' + rows.length + ' Buah barang  &nbsp;&nbsp;&nbsp;&nbsp;<button type=\'button\' style=\'align:right;\'>RETUR</button>';
                },
				onLoadSuccess:function(){
					var dg = $(this);
					var index = $(this).attr('group-index');
					dg.datagrid('collapseGroup', index);
				}
            ">
        <thead>
            <tr>
                <th data-options="field:'nomor',width:80">NOMOR</th>
                <th data-options="field:'kode',width:100">KODE</th>
                <th data-options="field:'nama',width:250,align:'right'">NAMA</th>
                <th data-options="field:'ukuran',width:80,align:'right'">UKURAN</th>
                <th data-options="field:'rtn',width:50">RTN</th>
                <th data-options="field:'pakai',width:60,align:'center'">PAKAI</th>
                <th data-options="field:'satuan',width:60,align:'center'">SATUAN</th>
            </tr>
        </thead>
		<tbody>
			<?php
			if($dataBarang > 0){
				foreach($dataBarang as $row){
					echo "<tr>
						<td>".$row['nomor']."</td>
						<td>".$row['kode']."</td>
						<td>".$row['nama']."</td>
						<td>".$row['ukuran']."</td>
						<td>".$row['rtn']."</td>
						<td>".$row['pakai']."</td>
						<td>".$row['satuan']."</td>
					</tr>";
				}
			}/* else{
				echo "<tr>
						<td colspan='9' align='center'>Belum ada bon barang. Untuk membuat bon barang klik tombol buat bon di atas.</td>
					</tr>";
			} */
			?>
		</tbody>
    </table>