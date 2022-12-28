<?php
	$MainJudul="";
	$statusid=!empty($statusid)?$statusid:"";
	$Main->MainJudul="Utama";
	$Main->Judul="Semua Rekrutmen";
	
	$Pesan="";
	$ParamAksi="";
	switch($Action)
	{
		case "Simpan";
		
			if(!empty($status_id)&&!empty($open_date)&&!empty($close_date)){
				$QTmp="select count(*) as jml from magang.recruitment_tx where recruitment_id='{$idSub}'";
				
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	
				$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;			
				$Func->ambilData("select user_id from magang.user_tm where email='{$sUserId}'");
				$Func->ambilData("select name as department from magang.department_tr where department_id='{$department_id}'");
				$Func->ambilData("select name as position from magang.position_tr where position_id='{$position_id}'");
				if ($jCount > 0)
				{	
					$Qry="UPDATE magang.recruitment_tx SET open_date='{$open_date}', close_date='{$close_date}', position_id='{$position_id}', position='{$position}', department_id='{$department_id}', department='{$department}', letter='{$letter}', letter_date='{$letter_date}', notes='{$notes}', description='{$description}', status_id='{$status_id}', user_id='{$user_id}', update_date='{$TANGGAL_AKSES}' WHERE  recruitment_id='{$idSub}';";}
				else
				{$Qry="INSERT INTO magang.recruitment_tx (open_date, close_date, position_id, position, department_id, department, letter, letter_date, notes, description, status_id, user_id, create_date) VALUES ('{$open_date}', '{$close_date}', '{$position_id}', '{$position}', '{$department_id}', '{$department}', '{$letter}', '{$letter_date}', '{$notes}', '{$description}', '{$status_id}', '{$user_id}', '{$TANGGAL_AKSES}');";}
				
				$Simpan=_mysql_query( $Qry );
				
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				//echo "<script>setTimeout(function(){ Fm.Action.value='';Fm.submit(); }, 100);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from magang.recruitment_tx where recruitment_id='".$idSub."'");
			$plogin=$login;
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
			$Readonly="readonly";
		break;
		case "Hapus":
			_mysql_query("delete from magang.recruitment_tx where recruitment_id='".$idSub."'");
			$Func->kosongkanData("magang.recruitment_tx");
			echo "<script>Fm.Action.value='BknSimpan';Fm.Mode.value='';Fm.submit();</script>";	
		break;
		case "Baru":
			$Func->kosongkanData("magang.recruitment_tx");
			$plogin=$login;
			$idSub="";
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
		break;
		default:
			if(empty($Action)){$Func->kosongkanData("magang.recruitment_tx");}
	}

	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$wh=!empty($statusid)?" where a.status_id='{$statusid}'":""; 
	$Qry="SELECT * FROM magang.recruitment_tx as a inner join (select status_id, name as sts from magang.status_tr where type='Status Rekrutmen') as b on a.status_id=b.status_id $wh order by a.recruitment_id"; 
	
	
	$Qry=_mysql_query($Qry); 
	
	///// LIST GRID 
	
	while($Isi=_mysql_fetch_array($Qry)){ 
		$wr = $i % 2 == 0 ? "style='background:$Main->BgRow'" : "style='background:$Main->BgRow2'"; 
		$wh = $i % 2 == 0 ? "$Main->BgRow" : "$Main->BgRow2"; 

		 	
		$onclick_edit="onclick=\"Fm.idSub.value='{$Isi['recruitment_id']}';Fm.Action.value='Lihat';Fm.submit();\" ";
		$onclick_hapus="onclick=\"Cek=confirm('Apakah yakin akan menghapus data?');if(!Cek){return false;}else{Fm.idSub.value='{$Isi['recruitment_id']}';Fm.Action.value='Hapus';Fm.submit();}\"";
		$td=" 
			<td align=center>
				<div class='card-toolbar'>
					<!--begin::Menu-->
					<button type='button' class='btn btn-sm btn-icon btn-icon-primary btn-active-light-primary me-n3' data-kt-menu-trigger='click' data-kt-menu-placement='bottom-end' data-kt-menu-flip='top-end'>
						<!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks-2.svg-->
						<span class='svg-icon svg-icon-2'>
							<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24px' height='24px' viewBox='0 0 24 24' version='1.1'>
								<g stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>
									<rect x='5' y='5' width='5' height='5' rx='1' fill='#000000'></rect>
									<rect x='14' y='5' width='5' height='5' rx='1' fill='#000000' opacity='0.3'></rect>
									<rect x='5' y='14' width='5' height='5' rx='1' fill='#000000' opacity='0.3'></rect>
									<rect x='14' y='14' width='5' height='5' rx='1' fill='#000000' opacity='0.3'></rect>
								</g>
							</svg>
						</span>
						<!--end::Svg Icon-->
					</button>
					<!--begin::Menu 2-->
					<div class='menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold w-200px' data-kt-menu='true' style=''>
						<div class='separator mb-3 opacity-75'></div>
						
						<div class='menu-item px-3' {$onclick_edit}>
							<a href='#' class='menu-link px-3'>Edit</a>
						</div>
						
						<div class='menu-item px-3' {$onclick_hapus}>
							<a href='#' class='menu-link px-3'>Hapus</a>
						</div>

						<div class='menu-item px-3' onclick=\"parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}/jadwal/baru/{$Isi['recruitment_id']}';\">
							<a href='#' class='menu-link px-3'>Jadwal</a>
						</div>

						<div class='menu-item px-3' onclick=\"parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}/major/baru/{$Isi['recruitment_id']}';\">
							<a href='#' class='menu-link px-3'>Jurusan</a>
						</div>
						<div class='separator mb-3 opacity-75'></div>
					</div>
					<!--end::Menu 2-->
					<!--end::Menu-->
				</div>

			</td>"; 
		

		
		$ListMode.=" 
			<tr  > 
 				<td>{$i}</td>
 				<td>
					<strong>{$Isi['position']}</strong><br>
					{$Isi['department']}<br>
					<span class='badge badge-dark' style='margin-bottom:4px;'>{$Isi['description']}</span><br>
					<span class='badge badge-info' >".$Func->TglAll($Isi['open_date'])."</span>
					<span class='badge badge-warning'>".$Func->TglAll($Isi['close_date'])."</span>
					<span class='badge badge-success'>{$Isi['sts']}</span>
				</td>
				{$td}
			</tr> 
		";$i++; 
	}

	include "{$Dir->ModAdmin}{$Pr}/detail.inc.php";

	$Qry="select status_id, name from magang.status_tr where type='Status Rekrutmen'"; 
	$Qry=_mysql_query($Qry);$li="";
	$aktif="";
	$statusid=!empty($statusid)?$statusid:"";
	while($Isi=_mysql_fetch_array($Qry)){ 
		$aktif="";
		if($statusid==$Isi['status_id']){
			$aktif="active";
		}
		$li.="
			<li class='nav-item' onclick=\"Fm.statusid.value='{$Isi['status_id']}';Fm.Action.value='BknSimpan';Fm.submit();\">
				<a class='nav-link {$aktif}' href='#'>{$Isi['name']}</a>
			</li>
		";
	}
	$aktifall="";
	if(empty($statusid)){
		$aktifall="active";
	}
	
	$Main->Isi = "
	{$Pesan}
	<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/' enctype='multipart/form-data'> 
	".$Func->txtField('Pr',$Pr,'','','hidden')." 
	".$Func->txtField('Mode',$Mode,'','','hidden')." 
	".$Func->txtField('halaman',$halaman,'','','hidden')." 
	".$Func->txtField('Action',$Action,'','','hidden')." 
	".$Func->txtField('idSub',$idSub,'','','hidden')." 
	".$Func->txtField('statusid',@$statusid,'','','hidden')." 

	<div class='card '>
		<div class='card-header card-header-stretch'>
			<h3 class='card-title'>
				<a href='#' class='btn btn-success me-2 mb-2' onclick=\"Fm.Action.value='Baru';Fm.submit();\" ><i class='las fa-folder-plus fs-2 me-2'></i>Tambah Data</a>
			</h3>
			<div class='card-toolbar'>
				



				<ul class='nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0'>
					<li class='nav-item' onclick=\"Fm.statusid.value='';Fm.Action.value='BknSimpan';Fm.submit();\">
						<a class='nav-link {$aktifall} ' href='#kt_tab_pane_7'>Semua</a>
					</li>
					{$li}
				</ul>
			</div>
		</div>
		<div class='card-body'>
			<table id='kt_datatable_example_3' class='table table-striped gy-5 gs-7'>
				<thead>
					<tr class='fw-bold fs-6 text-gray-800'>
						<th class='min-w-10px'>No</th>
						<th class='min-w-500px'>Rekrutmen</th>
						<th class='min-w-50px'>Aksi</th>
					</tr>
				</thead>
				<tbody>
					$ListMode
				</tbody>
			</table>
		</div>
	</div>
	
	
	
		
		<script>
		$('#kt_datatable_example_3').DataTable({
			
			'search': true
		});
		</script>
		{$ParamAksi}
		{$Modal}
	</form>
	

	
	";
	//$Main->Isi = $Func->Kotak('Halaman Utama',$Main->Isi,'85%');
?>