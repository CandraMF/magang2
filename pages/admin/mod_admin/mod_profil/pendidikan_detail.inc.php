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
						<td width='10%'>Jenis Pendidikan</td>
						<td>".$Func->cmbQuery('education_type',@$education_type,"select status_id, name  from magang.status_tr where type='Jenis Pendidikan'")."</td>
					</tr>
					<tr>
						<td>Jurusan</td>
						<td>".$Func->cmbQuery('major_id',@$major_id,"select major_id, name from magang.major_tr")."</td>
					</tr>
					<tr>
						<td>Tahun Masuk</td>
						<td>".$Func->txtField('start_year',@$start_year,'4','4','number',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td>Tahun Keluar</td>
						<td>".$Func->txtField('end_year',@$end_year,'4','4','number',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td>Sekolah/Universitas</td>
						<td>".$Func->cmbQuery('school_id',@$school_id,"select school_id, name from magang.school_tr")."</td>
					</tr>
					<tr>
						<td>Wilayah</td>
						<td>".$Func->cmbQuery('region_id',@$region_id,"select region_id, name from magang.region_tr")."</td>
					</tr>
					<tr>
						<td>IPK</td>
						<td>".$Func->txtField('score',@$score,'3','3','number',"style='width:80%'")."</td>
					</tr>
					<tr>
						<td>Status</td>
						<td>".$Func->cmbQuery('status_id',@$status_id,"select status_id, name as sts from magang.status_tr where type='Status Pendidikan'")."</td>
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