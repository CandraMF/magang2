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
						<td colspan=2>Status</td>
					</tr>
					<tr>						
						<td colspan=2>".$Func->cmbQuery('status_id',@$status_id,"select status_id, name from magang.status_tr where type='Status Rekrutmen'")."</td>
					</tr>
					<tr>
						<td>Tgl. Pembukaan</td>
						<td>Tgl. Penutupan</td>
						
					</tr>
					<tr>
						<td>".$Func->txtField('open_date',substr(@$open_date,0,10),'15','','date',"style='width:80%'")."</td>
						<td>".$Func->txtField('close_date',substr(@$close_date,0,10),'15','','date',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td>No. Surat</td>
						<td>Tgl. Surat</td>
					</tr>
					<tr>
						<td>".$Func->txtField('letter',@$letter,'15','','text',"style='width:80%'")."</td>
						<td>".$Func->txtField('letter_date',@$letter_date,'15','','date',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td colspan=2>Posisi</td>
					</tr>
					<tr>						
						<td colspan=2>".$Func->cmbQuery('position_id',@$position_id,"select position_id, name from magang.position_tr where status_id='POS101'")."</td>
					</tr>
					<tr>
						<td colspan=2>Unit Kerja</td>
					</tr>
					<tr>						
						<td colspan=2>".$Func->cmbQuery('department_id',@$department_id,"select department_id, name from magang.department_tr where status_id='DEP101'")."</td>
					</tr>
					<tr>
						<td colspan=2>Keterangan</td>
					</tr>
					<tr>						
						<td colspan=2>
							<textarea name='description' style='height:100px;width:100%;' class='form-control'>{$description}</textarea>
						</td>
					</tr>
					<tr>
						<td colspan=2>Catatan</td>
					</tr>
					<tr>						
						<td colspan=2>
							<textarea name='notes' style='height:100px;width:100%;' class='form-control'>{$notes}</textarea>
						</td>
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