<?php
	$MainJudul="";
	$Main->MainJudul="Utama";
	$Main->Judul="Profil";
	$recruitment_id=$idPop;
	$Pesan="";
	$ParamAksi="";
	$Func->ambilData("select person_id from magang.person_tm where email='{$sUserId}'");

	switch($Aksi)
	{
		case "Simpan";
			if(!empty($education_type)){
				$QTmp="select count(*) as jml from magang.person_education_tx where id='{$idPopSub}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	
				$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
				$Func->ambilData("select name as major from magang.major_tr where major_id='{$major_id}'");
				$Func->ambilData("select name as school from magang.school_tr where school_id='{$school_id}'");
				$Func->ambilData("select name as region from magang.region_tr where region_id='{$region_id}'");
				if ($jCount > 0)
				{	
					$Qry="UPDATE magang.person_education_tx SET person_id='{$person_id}', education_type='{$education_type}', start_year='{$start_year}', end_year='{$end_year}', major_id='{$major_id}', major='{$major}', school_id='{$school_id}', school='{$school}', region_id='{$region_id}', region='{$region}', score='{$score}', status_id='{$status_id}',  update_date='{$pupdated_date}' WHERE  id='{$idPopSub}';";}
				else
				{
					$is_last=0;
					$Qry="INSERT INTO magang.person_education_tx (person_id, education_type, start_year, end_year, major_id, major, school_id, school, region_id, region, score, status_id, is_last, create_date) VALUES ('{$person_id}', '{$education_type}', '{$start_year}', '{$end_year}', '{$major_id}', '{$major}', '{$school_id}', '{$school}', '{$region_id}', '{$region}', '{$score}', '{$status_id}', '{$is_last}', '{$pcreated_date}');";
				}
		
				$Simpan=_mysql_query( $Qry );
				
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				//echo "<script>setTimeout(function(){ Fm.Action.value='';Fm.submit(); }, 100);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from magang.person_education_tx where id='".$idPopSub."'");
			$plogin=$login;
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
			$Readonly="readonly";
		break;
		case "Hapus":
			_mysql_query("delete from magang.person_education_tx where id='".$idPopSub."'");
			$Func->kosongkanData("magang.person_education_tx");
			
		break;
		case "Baru":
				
			$Func->kosongkanData("magang.person_education_tx");
			$plogin=$login;
			$idPopSub="";
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
			
		break;
		default:
			if(empty($Action)){$Func->kosongkanData("magang.person_education_tx");}
	}

	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$Func->ambilData("select person_id from magang.person_tm where email='{$sUserId}'");
	$Qry="select a.id, b.jenis, a.major, a.school, c.sts from magang.person_education_tx as a 
	inner join(select status_id, name as jenis from magang.status_tr where type='Jenis Pendidikan') as b on a.education_type=b.status_id
	inner join(select status_id, name as sts from magang.status_tr where type='Status Pendidikan') as c on a.status_id=c.status_id
	where a.person_id='{$person_id}' order by a.education_type"; 
	$ParamDet="{$Pg}/{$Pr}/{$ckata}/{$Action}"; 
	$Param="{$Url->BaseMain}/".$ParamDet; 

	$Param="{$Url->BaseMain}/".$ParamDet; 
	 
	///// PAGE HALAMAN GRID 
	$PageNavi = new pageNavi; 
	$batas='20';

	$substrpos=substr($REQUEST_URI,$strpos);
	if(empty($strpos)){$halaman=1;}else{$halaman=str_replace("pagehal-","",$substrpos);}
	
	$posisi = $PageNavi->cariPosisi($batas);$i=$posisi+1; 
	if(empty($Excel)){
		if(empty($ckata)){$limit=" limit $batas OFFSET  $posisi";}else{$halaman=1;$i=1;}		
	} 
	$LinkPageNavi="pagehal-{$halaman}";

	$jmldata = _mysql_num_rows(_mysql_query($Qry)); 
	$jmlhalaman = $PageNavi->jumlahHalaman($jmldata, $batas); 
	$linkHalaman = $PageNavi->navHalaman($halaman, $jmlhalaman, $Param); 
	$link="
				<div class='gridjs-pagination'>
					<div class='gridjs-pages'>
						$linkHalaman
					</div>
				</div>
			"; 
	 
	
	$Qry=_mysql_query($Qry); 
	
	///// LIST GRID 
	
	while($Isi=_mysql_fetch_array($Qry)){ 
		$wr = $i % 2 == 0 ? "style='background:$Main->BgRow'" : "style='background:$Main->BgRow2'"; 
		$wh = $i % 2 == 0 ? "$Main->BgRow" : "$Main->BgRow2"; 

		 	
		$onclick_edit="onclick=\"Fm2.idPopSub.value='{$Isi['id']}';Fm2.Aksi.value='Lihat';Fm2.submit();\" ";
		$onclick_hapus="onclick=\"Cek=confirm('Apakah yakin akan menghapus data?');if(!Cek){return false;}else{Fm2.idPopSub.value='{$Isi['id']}';Fm2.Aksi.value='Hapus';Fm2.submit();}\"";
		$td=" 
			<td>
				<a href='#' class='btn btn-icon btn-warning' {$onclick_edit}><i class='fas fa-edit fs-4 me-2'></i></a>
				<a  href='#' class='btn btn-icon btn-danger' {$onclick_hapus}><i class='fas fa-recycle fs-4 me-2'></i></a>
			</td>"; 
		

		$ListMode.=" 
			<tr> 
 				<td>{$i}</td>
 				<td>{$Isi['jenis']}</td>
 				<td>{$Isi['major']}</td>
 				<td>{$Isi['school']}</td>
 				<td>{$Isi['sts']}</td>
				{$td}
			</tr> 
		";$i++; 
	}

	include "{$Dir->ModAdmin}{$Pr}/pendidikan_detail.inc.php";
	$Main->Isi = "
	<form name=Fm2 id=Fm2 method=post Aksi='{$Url->BaseMain}/{$Pg}/{$Pr}/{$Mode}' enctype='multipart/form-data'> 
	".$Func->txtField('Pr',$Pr,'','','hidden')." 
	".$Func->txtField('Mode',$Mode,'','','hidden')." 
	".$Func->txtField('Aksi',$Aksi,'','','hidden')." 
	".$Func->txtField('idPop',$idPop,'','','hidden')." 
	".$Func->txtField('idPopSub',$idPopSub,'','','hidden')." 
	".$Func->txtField('person_id',$person_id,'','','hidden')." 
		<div class='py-10'>
			<div class='card-header card-header-stretch'>
			
				<div class='card-toolbar'>
					<ul class='nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0'>
						<li class='nav-item' >
							<a class='nav-link ' href='{$Url->BaseMain}/{$Pg}/{$Pr}/data_diri/baru'>Data Diri</a>
						</li>
						<li class='nav-item' >
							<a class='nav-link active' href='{$Url->BaseMain}/{$Pg}/{$Pr}/pendidikan/baru'>Pendidikan</a>
						</li>
						<li class='nav-item' >
							<a class='nav-link ' href='{$Url->BaseMain}/{$Pg}/{$Pr}/keluarga/baru'>Keluarga</a>
						</li>
						<li class='nav-item' >
							<a class='nav-link ' href='{$Url->BaseMain}/{$Pg}/{$Pr}/pekerjaan/baru'>Pekerjaan</a>
						</li>
						<li class='nav-item' >
							<a class='nav-link ' href='{$Url->BaseMain}/{$Pg}/{$Pr}/organisasi/baru'>Organisasi</a>
						</li>
						<!-- <li class='nav-item' >
							<a class='nav-link ' href='{$Url->BaseMain}/{$Pg}/{$Pr}/berkas/baru'>Berkas</a>
						</li> -->
					</ul>
				</div>
			</div><br>
			{$Pesan}
			<a href='#' class='btn btn-success me-2 mb-2' onclick=\"Fm2.Aksi.value='Baru';Fm2.submit();\" ><i class='las fa-folder-plus fs-2 me-2'></i>Tambah Data</a>
			<table id='kt_datatable_example_3' class='table table-striped gy-5 gs-7'>
			<thead>
				<tr class='fw-bold fs-6 text-gray-800'>
					<th class='min-w-10px'>No</th>
					<th class='min-w-100px'>Jenis</th>
					<th class='min-w-100px'>Jurusan</th>
					<th class='min-w-100px'>Sekolah</th>
					<th class='min-w-100px'>Status</th>
					<th class='min-w-50px'>Aksi</th>
				</tr>
			</thead>
			<tbody>
				$ListMode
			</tbody>
			</table>
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