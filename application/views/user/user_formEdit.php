<form id="formUpdateUser">
<?php
foreach($data as $row){
?>
	<table>
		<tr>
			<td><span  class="form-caption">NIP &nbsp;&nbsp;&nbsp;&nbsp;</span></td>
			<td><?php echo $row->nip; ?><input type="hidden" name="id" value="<?php echo $row->id; ?>"></td>
		</tr>
		<tr>
			<td><span  class="form-caption">Status &nbsp;&nbsp;&nbsp;&nbsp;</span></td>
			<td>
				<input class="easyui-combobox" name="status" style="width:210px;" data-options="
				valueField: 'id',
				textField: 'nama',
				data: [{
					id: '0',
					nama: 'NON-AKTIF'
				},{
					id: '1',
					nama: 'AKTIF'
				}]" value="<?php echo $row->status_id; ?>"/>
			</td>
		</tr>
		<tr>
			<td><span  class="form-caption">User Group &nbsp;&nbsp;&nbsp;&nbsp;</span></td>
			<td>
				<input class="easyui-combobox" name="id_user_group" style="width:210px;"
				name="language"
				data-options="
						url:'<?php echo base_url("index.php/user_group/daftarDataGroup/1");?>',
						method:'get',
						valueField:'id',
						textField:'nama',
						panelHeight:'auto',
						required:true
				" value="<?php echo $row->id_user_group; ?>">
			</td>
		</tr>
		<tr>
			<td><span  class="form-caption">Nama Lengkap &nbsp;&nbsp;&nbsp;&nbsp;</span></td>
			<td><?php echo $row->full_name; ?></td>
		</tr>
		<tr>
			<td></td>
			<td><a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitUpdateForm()">Simpan Perubahan</a></td>
		</tr>
	</table>
	<div id="stateUpdate"></div>
<?php
}
?>
</form>