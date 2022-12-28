<?php
	$status_id=!empty($status_id)?$status_id:$statusid;
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
						<td colspan=2>Jurusan</td>
					</tr>
					<tr>						
						<td colspan=2>".$Func->cmbQuery('major_id',@$major_id,"select major_id, name from magang.major_tr ")."</td>
					</tr>
					<tr>
						<td colspan=2>Catatan</td>
					</tr>
					<tr>						
						<td colspan=2>
							<textarea name='pdescription' style='height:100px;width:100%;' class='form-control'>{$description}</textarea>
						</td>
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