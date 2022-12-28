<?php
	$Qry="select a.id, a.action, a.start_date, a.end_date, b.stsmagang from magang.recruitment_schedule_tx as a
left join (
	SELECT aa.schedule_id,  bb.stsmagang FROM magang.recruitment_schedule_person_tx as aa 
inner join (select status_id, name as stsmagang from magang.status_tr where type='Status Lamaran') as bb on aa.status_id=bb.status_id
where aa.person_id='{$person_id}'	
) as b on a.id=b.schedule_id
where recruitment_id='{$prmid}' order by a.start_date";

	$Qry=_mysql_query($Qry); $ListMO="";$i=1;
	while($Isi=_mysql_fetch_array($Qry)){ 
		
		$ListMO.="
			<tr> 
 				<td>{$i}</td>
 				<td>{$Isi['action']}</td>
 				<td>".$Func->TglAll($Isi['start_date'])."<br>".substr($Isi['start_date'],-9)."</td>
 				<td>".$Func->TglAll($Isi['end_date'])."<br>".substr($Isi['end_date'],-9)."</td>
 				<td>{$Isi['stsmagang']}</td>
			</tr>
		";$i++;
	}
	$Modal="
		<div class='modal fade' tabindex='-1' id='kt_modal_1'>
		<div class='modal-dialog modal-fullscreen'>
			<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title'>Status Informasi Jadwal Tahapan Magang</h5>
					
					<!--begin::Close-->
					<div class='btn btn-icon btn-sm btn-active-light-primary ms-2' data-bs-dismiss='modal' aria-label='Close'>
						<span class='svg-icon svg-icon-2x'></span>
					</div>
					<!--end::Close-->
				</div>

				<div class='modal-body'>
					<table id='kt_datatable_example_3' class='table table-striped gy-5 gs-7'>
					<thead>
						<tr class='fw-bold fs-6 text-gray-800'>
							<th class='min-w-10px'>No</th>
							<th class='min-w-500px'>Tahapan</th>
							<th class='min-w-50px'>Waktu Mulai</th>
							<th class='min-w-50px'>Waktu Akhir</th>
							<th class='min-w-50px'>Status</th>
						</tr>
					</thead>
					<tbody>
						$ListMO
					</tbody>
					</table>
				</div>

				<div class='modal-footer'>
					<button type='button' class='btn btn-light' data-bs-dismiss='modal'>Close</button>
				</div>
			</div>
		</div>
	</div>
	";
?>