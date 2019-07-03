<div style="padding-bottom:5px;">
	<a href="#" class="easyui-linkbutton c1" onclick="formBPB()"><i class="fa fa-plus"></i> BUAT BON RETUR</a>
</div>
    <table class="easyui-datagrid" style="width:100%;">
        <thead>
            <tr>
                <th>NOMOR</th>
                <th>KODE</th>
                <th>NAMA</th>
                <th>UKURAN</th>
                <th>RTN</th>
                <th>PAKAI</th>
                <th>SATUAN</th>
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