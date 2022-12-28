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
						<td colspan=2>Kegiatan</td>
					</tr>
					<tr>						
						<td colspan=2>".$Func->cmbQuery('action_id',@$action_id,"select status_id, name from magang.status_tr where type='Kegiatan Rekrutmen'")."</td>
					</tr>
					<tr>
						<td>Tgl. Mulai</td>
						<td>Tgl. Selesai</td>
					</tr>
					<tr>
						<td>".$Func->txtField('start_date',@$start_date,'15','','datetime-local',"style='width:80%'")."</td>
						<td>".$Func->txtField('end_date',@$end_date,'15','','datetime-local',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td colspan=2>Status</td>
					</tr>
					<tr>						
						<td colspan=2>".$Func->cmbQuery('pstatus_id',@$status_id,"select status_id, name from magang.status_tr where type='Status Jadwal Rekrutmen'")."</td>
					</tr>
					<tr>
						<td colspan=2>Catatan</td>
					</tr>
					<tr>						
						<td colspan=2>
							<textarea name='pnotes' style='height:100px;width:100%;' class='form-control'>{$notes}</textarea>
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