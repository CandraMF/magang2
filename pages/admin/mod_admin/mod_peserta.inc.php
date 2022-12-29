<?php
	$MainJudul="";
	$Main->MainJudul="Utama";
	$Main->Judul="Peserta";
	$idSub=!empty($idSub)?$idSub:"";
	$Pesan="";
	$ParamAksi="";
	switch($Action)
	{
		case "Simpan";
			if(!empty($name)){
				$QTmp="select count(*) as jml from magang.person_tm where person_id='{$idSub}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	
				$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;			
				if ($jCount > 0)
				{	
					$Qry="UPDATE magang.person_tm SET title_pre='{$title_pre}', name='{$name}', title_post='{$title_post}', identity_id='{$identity_id}', tax_id='{$tax_id}', driving_a='{$driving_a}', driving_b='{$driving_b}', driving_c='{$driving_c}', birth_place='{$birth_place}', birth_date='{$birth_date}', religion_id='{$religion_id}', blood_type='{$blood_type}', marital_status_id='{$marital_status_id}', ethnicity_id='{$ethnicity_id}', email='{$email}', mobile='{$mobile}', mobile_alt='{$mobile_alt}', address='{$address}', region_id='{$region_id}', region='{$region}', zip='{$zip}', address_home='{$address_home}', region_id_home='{$region_id_home}', region_home='{$region_home}', zip_home='{$zip_home}' WHERE  person_id='{$idSub}';";}
				else
				{
					$Qry="INSERT INTO magang.person_tm (title_pre, name, title_post, identity_id, tax_id, driving_a, driving_b, driving_c, birth_place, birth_date, religion_id, blood_type, marital_status_id, ethnicity_id, email, mobile, mobile_alt, address, region_id, region, zip, address_home, region_id_home, region_home, zip_home) VALUES ('{$title_pre}', '{$name}', '{$title_post}', '{$identity_id}', '{$tax_id}', '{$driving_a}', '{$driving_b}', '{$driving_c}', '{$birth_place}', '{$birth_date}', '{$religion_id}', '{$blood_type}', '{$marital_status_id}', '{$ethnicity_id}', '{$email}', '{$mobile}', '{$mobile_alt}', '{$address}', '{$region_id}', '{$region}', '{$zip}', '{$address_home}', '{$region_id_home}', '{$region_home}', '{$zip_home}');";
				}
			
				$Simpan=_mysql_query( $Qry );
				
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				//echo "<script>setTimeout(function(){ Fm.Action.value='';Fm.submit(); }, 100);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from magang.person_tm where person_id='".$idSub."'");
			$plogin=$login;
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
			$Readonly="readonly";
		break;
		case "Hapus":
			_mysql_query("delete from magang.person_tm where person_id='".$idSub."'");
			$Func->kosongkanData("magang.person_tm");
			echo "<script>Fm.Action.value='BknSimpan';Fm.Mode.value='';Fm.submit();</script>";	
		break;
		case "Baru":
			$Func->kosongkanData("magang.person_tm");
			$plogin=$login;
			$idSub="";
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
		break;
		default:
			if(empty($Action)){$Func->kosongkanData("magang.person_tm");}
	}

	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$wh=!empty($ckata)?" and lower(nmgroupakses) like '%".strtolower($ckata)."%'":""; 
	$Qry="select person_id, identity_id, name, birth_place, birth_date, email, mobile  from magang.person_tm order by person_id"; 
	$ParamDet="{$Pg}/{$Pr}/{$ckata}/{$Action}"; 
	$Qry=_mysql_query($Qry); 
	
	///// LIST GRID 
	
	while($Isi=_mysql_fetch_array($Qry)){ 
		$wr = $i % 2 == 0 ? "style='background:$Main->BgRow'" : "style='background:$Main->BgRow2'"; 
		$wh = $i % 2 == 0 ? "$Main->BgRow" : "$Main->BgRow2"; 

		 	
		$onclick_edit="onclick=\"Fm.idSub.value='{$Isi['person_id']}';Fm.Action.value='Lihat';Fm.submit();\" ";
		$onclick_hapus="onclick=\"Cek=confirm('Apakah yakin akan menghapus data?');if(!Cek){return false;}else{Fm.idSub.value='{$Isi['person_id']}';Fm.Action.value='Hapus';Fm.submit();}\"";
		$td=" 
			<td>
				<a href='#' class='btn btn-icon btn-warning' {$onclick_edit}><i class='fas fa-edit fs-4 me-2'></i></a>
				<a  href='#' class='btn btn-icon btn-danger' {$onclick_hapus}><i class='fas fa-recycle fs-4 me-2'></i></a>
			</td>"; 
		

		
		$ListMode.=" 
			<tr> 
 				<td>{$i}</td>
 				<td>{$Isi['name']}</td>
 				<td>{$Isi['identity_id']}</td>
 				<td>{$Isi['birth_place']}, ".$Func->TglAll($Isi['birth_date'])."</td>
 				<td>{$Isi['email']}</td>
 				<td>{$Isi['mobile']}</td>
				{$td}
			</tr> 
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
		<div class='py-10'>
			<a href='#' class='btn btn-success me-2 mb-2' onclick=\"Fm.Action.value='Baru';Fm.submit();\" ><i class='las fa-folder-plus fs-2 me-2'></i>Tambah Data</a>
			
			<table id='kt_datatable_example_3' class='table table-striped gy-5 gs-7'>
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