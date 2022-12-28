<?php
	$prmid=!empty($prmid)?$prmid:"";
	$MainJudul="";
	$Main->MainJudul="Master Data";
	$Main->Judul="Data Daerah";
	$recruitment_id=!empty($recruitment_id)?$recruitment_id:"";
	$idSub=!empty($idSub)?$idSub:"";
	$Pesan="";
	$ParamAksi="";

	$Func->ambilData("select person_id from magang.person_tm where email='{$sUserId}'");
	switch($Action)
	{
		case "Apply";
			if(!empty($recruitment_id)){
				$QTmp="select count(*) as jml from magang.recruitment_person_tx where recruitment_id='{$recruitment_id}' and person_id='{$person_id}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	
				$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;			
				if ($jCount > 0)
				{}
					
				else
				{
					$status_id='APL001';
					$action_id='ACT101';
					$action='Seleksi Administrasi';
					$description='Seleksi Administrasi';
					$Qry="INSERT INTO magang.recruitment_person_tx (recruitment_id, person_id, description, status_id, action_id, action,  create_date) VALUES ('{$recruitment_id}', '{$person_id}', '{$description}', '{$status_id}', '{$action_id}', '{$action}', '{$TANGGAL_AKSES}');";					
					$Simpan=_mysql_query( $Qry );					
					$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Data Sudah di kirim</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				}
			
				//echo "<script>setTimeout(function(){ Fm.Action.value='';Fm.submit(); }, 100);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from magang.recruitment_person_tx where id='".$idSub."'");
			$plogin=$login;
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
			$Readonly="readonly";
		break;
		
		case "Baru":
			$Func->kosongkanData("magang.recruitment_person_tx");
			$plogin=$login;
			$idSub="";
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
		break;
		default:
			if(empty($Action)){$Func->kosongkanData("magang.recruitment_person_tx");}
	}
		$Func->ambilData("select person_id from magang.person_tm where email='{$sUserId}'");
	$Qry = _mysql_query( "select count(*) as jml from magang.recruitment_person_tx where person_id='{$person_id}'" );	
	$Hasil=_mysql_fetch_array($Qry);	
	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;	
	$wh="";
	if ($jCount > 0){
		$Func->ambilData("select recruitment_id as prmid from magang.recruitment_person_tx where person_id='{$person_id}'");
		
		$wh=" and recruitment_id='{$prmid}'";
		$jinfo=1;
	}else{
		$jinfo=2;
	}

	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$Qry="select recruitment_id ,open_date, close_date, position, department, description from magang.recruitment_tx where status_id='REC101' $wh order by open_date"; 
	$Qry=_mysql_query($Qry); 
	
	///// LIST GRID 
	
	while($Isi=_mysql_fetch_array($Qry)){ 
		$ListM="";
		$Qry01=_mysql_query("select id, major, description from magang.recruitment_major_tx where recruitment_id='{$Isi['recruitment_id']}'"); 
		while($Isi01=_mysql_fetch_array($Qry01)){ 
			$ListM.="
				<br><span class='badge badge-info' >{$Isi01['major']}</span><br><br>
					<em>{$Isi01['description']}</em></span>
				<hr>

			";
		}
		if($jinfo==1){
			$onclick="onclick=\"Fm.Action.value='Lihat';Fm.submit();\"";
			$FrmApply="<button type='button' class='btn btn-sm btn-info' {$onclick}>INFORMASI</button>";
		}else{
			$onclick="onclick=\"Cek=confirm('Apakah anda yakin akan melakukan proses pendaftaran?');if(!Cek){return false;}else{Fm.recruitment_id.value='{$Isi['recruitment_id']}';Fm.Action.value='Apply';Fm.submit();}\"";
			$FrmApply="<button type='button' class='btn btn-sm btn-success' {$onclick}>APPLY</button>";
		}
		
		$ListMode.=" 
			<div class='card shadow-sm'>
				<div class='card-header'>
					<h3 class='card-title'>{$Isi['department']}</h3>
					<div class='card-toolbar'>
						<button type='button' class='btn btn-sm btn-light'>
							{$Isi['position']}
						</button>
						{$FrmApply}
						
					</div>
				</div>
				<div class='card-body'>
					<div class='alert alert-primary'>
						

						<!--begin::Wrapper-->
						<div class='d-flex flex-column'>
							<!--begin::Title-->
							<h5 class='mb-1'>Keterangan</h5>
							<!--end::Title-->
							<!--begin::Content-->
							<span{$Isi['description']}.</span>
							<!--end::Content-->
						</div>
						<!--end::Wrapper-->
					</div>


					
					{$ListM}
				</div>
				<div class='card-footer'>
					Dibuka : <span class='badge badge-info' >".$Func->TglAll($Isi['open_date'])."</span> s/d
					<span class='badge badge-warning'>".$Func->TglAll($Isi['close_date'])."</span>
				</div>
			</div>
		";$i++; 
	}

	include "{$Dir->ModAdmin}{$Pr}/detail.inc.php";
	$Main->Isi = "{$Pesan}
	<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/' enctype='multipart/form-data'> 
	".$Func->txtField('Pr',$Pr,'','','hidden')." 
	".$Func->txtField('Mode',$Mode,'','','hidden')." 
	".$Func->txtField('halaman',$halaman,'','','hidden')." 
	".$Func->txtField('Action',$Action,'','','hidden')." 
	".$Func->txtField('idSub',$idSub,'','','hidden')." 
	".$Func->txtField('recruitment_id',$recruitment_id,'','','hidden')." 
		<div class='py-10'>
			
			$ListMode
		</div>
		
		
		{$ParamAksi}
		{$Modal}
	</form>
	

	
	";
	//$Main->Isi = $Func->Kotak('Halaman Utama',$Main->Isi,'85%');
?>