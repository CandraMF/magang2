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
						<td>Posisi</td>
						<td>".$Func->txtField('name',@$name,'','','text',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td>Status</td>
						<td>".$Func->cmbQuery('status_id',@$status_id,"select status_id, name  from magang.status_tr where type='Status Posisi/Jabatan'")."</td>
					</tr>
					</table>
				</div>

				<div class='modal-footer'>
					<button type='button' class='btn btn-light' data-bs-dismiss='modal'>Close</button>
					<button type='button' class='btn btn-primary' onclick=\"Fm.Action.value='Simpan';Fm.submit();\" >Save changes</button>
				</div>
			</div>
		</div>
	</div>
	";
?>