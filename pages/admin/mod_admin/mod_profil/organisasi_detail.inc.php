<?php
	$Modal="
		<div class='modal fade' tabindex='-1' id='kt_modal_1'>
		<div class='modal-dialog'>
			<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title'>Form Isian</h5>
					
					<!--begin::Close-->
					<div class='btn btn-icon btn-sm btn-active-light-primary ms-2' data-bs-dismiss='modal' aria-label='Close'>
						<span class='svg-icon svg-icon-2x'></span>
					</div>
					<!--end::Close-->
				</div>

				<div class='modal-body'>
					<table width='100%'>
					<tr>
						<td width='10%'>Organisasi</td>
						<td>".$Func->txtField('organization',@$organization,'14','','text',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td>Posisi/Jabatan</td>
						<td>".$Func->txtField('position',@$position,'14','','text',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td>Tanggal&nbsp;Masuk</td>
						<td>".$Func->txtField('start_period',@$start_period,'14','','date',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td>Tanggal&nbsp;Keluar</td>
						<td>".$Func->txtField('end_period',@$end_period,'13','','date',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td>Deskripsi</td>
						<td><textarea name='description' style='height:100px;width:100%' class='form-control'>{$description}</textarea></td>
					</tr>
					
					</table>
				</div>

				<div class='modal-footer'>
					<button type='button' class='btn btn-light' data-bs-dismiss='modal'>Close</button>
					<button type='button' class='btn btn-primary' onclick=\"Fm2.Aksi.value='Simpan';Fm2.submit();\" >Save changes</button>
				</div>
			</div>
		</div>
	</div>
	";
?>