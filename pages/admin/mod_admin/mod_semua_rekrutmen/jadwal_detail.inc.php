<?php
	$status_id=!empty($status_id)?$status_id:$statusid;
	$recruitment_id=1;
	$schedule_id=1;
	$Liste="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$wh=!empty($statusid)?" where a.status_id='{$statusid}'":""; 
	$Qry="select a.person_id, b.identity_id, b.name, b.birth_place, b.birth_date, b.email, b.mobile, c.sts_lamaran_id, c.stslamaran from magang.recruitment_person_tx as a 
	inner join magang.person_tm as b on a.person_id=b.person_id
	left join (SELECT a.person_id, a.status_id as sts_lamaran_id, b.stslamaran	FROM magang.recruitment_schedule_person_tx as a 
	inner join (SELECT status_id, name as stslamaran FROM magang.status_tr where type='Status Lamaran') as b on a.status_id=b.status_id
	where a.schedule_id='1') as c on a.person_id=c.person_id 
	where a.recruitment_id='1'"; 
	
	
	$Qry=_mysql_query($Qry); 
	
	///// LIST GRID 
	
	while($Isi=_mysql_fetch_array($Qry)){ 
	
		
		
		$Liste.=" 
			
			<tr> 
 				<td>{$i} <input type='hidden' name='tmpform' id='tmpform{$i}' class='tmpform' value='{$recruitment_id}|{$schedule_id}|{$Isi['sts_lamaran_id']}'> </td>
 				<td>{$Isi['name']}</td>
 				<td>{$Isi['identity_id']}</td>
 				<td>{$Isi['birth_place']}, ".$Func->TglAll($Isi['birth_date'])."</td>
 				<td>{$Isi['email']}</td>
 				<td>{$Isi['mobile']}</td>
				<td>".$Func->cmbQuery("sts_lamaran_id",$Isi['sts_lamaran_id'],"SELECT status_id, name as stslamaran FROM magang.status_tr where type='Status Lamaran'","onchange=\"Fm2.tmpform1.value='{$recruitment_id}|{$schedule_id}|'+$(this).val();\"")."</td>
			</tr> 
		";$i++; 
	}
	switch($sstatus_id){
		case "REC001":
			$sbadg="badge badge-secondary";
		break;
		case "REC101":
			$sbadg="badge-success";
		break;
		case "REC102":
			$sbadg="badge-primary";
		break;
		case "REC201":
			$sbadg="badge-warning";
		break;
	}
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
						<td>".$Func->txtField('start_date',@$start_date,'','','datetime-local',"style='width:80%'")."</td>
						<td>".$Func->txtField('end_date',@$end_date,'','','datetime-local',"style='width:80%'")."</td>
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

	<div class='modal fade' tabindex='-1' id='kt_modal_2'>
		 <div class='modal-dialog modal-fullscreen'>
			<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title'>Verifikasi Jadwal</h5>
					
					<!--begin::Close-->
					<div class='btn btn-icon btn-sm btn-active-light-primary ms-2' data-bs-dismiss='modal' aria-label='Close'>
						<span class='svg-icon svg-icon-2x'></span>
					</div>
					<!--end::Close-->
				</div>

				<div class='modal-body'>	
					<table class='table table-striped gy-5 gs-7'>
					<thead>
					<tr class='fw-bold fs-6 text-gray-800'>
						
							<th class='min-w-100px'>Posisi</th>
							<th class='min-w-100px'>Unit Kerja</th>
							<th class='min-w-100px'>Periode</th>
							<th class='min-w-100px'>Surat</th>
							<th class='min-w-100px'>Keterangan</th>
						
						</tr>
					</thead>
					<tr>
						
						<td><strong class='text-gray-800 fw-boldest fs-5 text-hover-primary mb-1'>{$sposition}</strong><br>
						<span class='badge {$sbadg}'>{$ssts}</span>
						</td>
						<td><span class='text-gray-400 fw-bold d-block'>{$sdepartment}</span></td>
						<td> <code >".$Func->TglAll($sopen_date)."</code>s/d				<code>".$Func->TglAll($sclose_date)."</code></td>
						<td>
							No. Surat<code >{$sletter}</code> <br> Tgl. Surat  <code >".$Func->TglAll($sletter_date)."</code>
						</td>
						<td>
							<em>{$sdescription}</em>
						</td>
						
					</tr> 
					</table><hr>
					<table id='kt_datatable_example_4' class='table table-striped gy-5 gs-7'>
						<thead>
							<tr class='fw-bold fs-6 text-gray-800'>
								<th class='min-w-10px'>No</th>
								<th class='min-w-150px'>Nama</th>
								<th class='min-w-100px'>NIK</th>
								<th class='min-w-100px'>TTL</th>
								<th class='min-w-100px'>Email</th>
								<th class='min-w-100px'>No. Ponsel</th>
								<th class='min-w-50px'>Aksi</th>
							</tr>
						</thead>
						<tbody>
							$Liste
						</tbody>
					</table>
					
				</div>

				<div class='modal-footer'>
					<button type='button' class='btn btn-light' data-bs-dismiss='modal'>Close</button>
					<button type='button' class='btn btn-primary' onclick=\"hitung();\" >Save changes</button>
					Fm.Action.value='Simpan';Fm.submit();
				</div>
			</div>
		</div>
	</div>
	".$Func->txtField('tmptampung2',@$tmptampung2,'','','text')." 
	<script>
		function hitung(){
			var max=".floatval($i-1).";
			var no=1;
			var txtstr='0|0|0';
			while(max>=no){
				txtstr+=', '+Fm2.tmptampung2.value;
				no++;
			}
			Fm2.tmptampung2.value=txtstr;
		}
		
		$('#kt_datatable_example_4').DataTable({
			
			'search': true
		});
		</script>
	";
?>