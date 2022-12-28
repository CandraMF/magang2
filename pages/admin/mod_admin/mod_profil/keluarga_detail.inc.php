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
						<td width='10%'>Jenis</td>
						<td>".$Func->cmbQuery('family_type',@$family_type,"select status_id, name  from magang.status_tr where type='Jenis Keluarga'")."</td>
					</tr>
					<tr>
						<td>Nama&nbsp;Lengkap</td>
						<td>".$Func->txtField('name',@$name,'14','','text',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td>Tempat&nbsp;Lahir</td>
						<td>".$Func->txtField('birth_place',@$birth_place,'14','','text',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td>Tanggal&nbsp;Lahir</td>
						<td>".$Func->txtField('birth_date',@$birth_date,'14','','text',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td>No.&nbsp;Ponsel</td>
						<td>".$Func->txtField('mobile',@$mobile,'13','','text',"style='width:80%'")."</td>
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