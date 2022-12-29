<?php
	$Func->ambilData("SELECT a.status_id as sstatus_id, a.position as sposition, b.sts as ssts, a.department as sdepartment, a.open_date as sopen_date, a.close_date as sclose_date, a.letter as sletter, a.letter_date as sletter_date, a.description as sdescription FROM magang.recruitment_tx as a inner join (select status_id, name as sts from magang.status_tr where type='Status Rekrutmen') as b on a.status_id=b.status_id where a.recruitment_id='{$prmid}' order by a.recruitment_id");

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
					<div class='card-body'>
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
					</table>
				</div>
				<hr>
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