<?php
	$MainJudul="";
	$Main->MainJudul="Master Data";
	$Main->Judul="Data User";
	$idSub=!empty($idSub)?$idSub:"";
	$Pesan="";
	$ParamAksi="";
	switch($Action)
	{
		case "Simpan";
			if(!empty($email)){
				$QTmp="select count(*) as jml from magang.user_tm where user_id='{$idSub}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	
				$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;			
				if ($jCount > 0)
				{	
					$Add="";
					$Add.=!empty($password)?", password='{$password}'":"";
					$Add.=!empty($person_id)?", person_id='{$person_id}'":"";
					$Qry="UPDATE magang.user_tm SET name='{$name}', email='{$email}', mobile='{$mobile}', role_id='{$role_id}', status_id='{$status_id}' {$Add} WHERE  user_id='{$idSub}';";}
				else
				{$Qry="INSERT INTO magang.user_tm (login, password, name, email, mobile, role_id, status_id, person_id, create_date) VALUES ('{$login}', '{$password}', '{$name}', '{$email}', '{$mobile}', '{$role_id}', '{$status_id}', {$person_id}, '{$pcreated_date}');";}
			
				$Simpan=_mysql_query( $Qry );
				
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				//echo "<script>setTimeout(function(){ Fm.Action.value='';Fm.submit(); }, 100);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from magang.user_tm where user_id='".$idSub."'");
			$plogin=$login;
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
			$Readonly="readonly";
		break;
		case "Hapus":
			_mysql_query("delete from magang.user_tm where user_id='".$idSub."'");
			$Func->kosongkanData("magang.user_tm");
			echo "<script>Fm.Action.value='BknSimpan';Fm.Mode.value='';Fm.submit();</script>";	
		break;
		case "Baru":
			$Func->kosongkanData("magang.user_tm");
			$plogin=$login;
			$idSub="";
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
		break;
		default:
			if(empty($Action)){$Func->kosongkanData("magang.user_tm");}
	}

	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$wh=!empty($ckata)?" and lower(nmgroupakses) like '%".strtolower($ckata)."%'":""; 
	$Qry="SELECT a.user_id, a.login, a.password, a.name, a.email, a.mobile, a.role_id, c.stsrole,  a.status_id, b.stsuser as status_user, a.person_id, a.create_date, a.activation_date FROM magang.user_tm as a inner join (select status_id, name  as stsuser from magang.status_tr where type='Status User') as b on a.status_id=b.status_id inner join (select status_id, name  as stsrole from magang.status_tr where type='Hak Akses User') as c on a.role_id=c.status_id	order by a.user_id"; 
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

		 	
		$onclick_edit="onclick=\"Fm.idSub.value='{$Isi['user_id']}';Fm.Action.value='Lihat';Fm.submit();\" ";
		$onclick_hapus="onclick=\"Cek=confirm('Apakah yakin akan menghapus data?');if(!Cek){return false;}else{Fm.idSub.value='{$Isi['user_id']}';Fm.Action.value='Hapus';Fm.submit();}\"";
		$td=" 
			<td>
				
				<a href='#' class='btn btn-icon btn-warning' {$onclick_edit}><i class='fas fa-edit fs-4 me-2'></i></a>
				<a  href='#' class='btn btn-icon btn-danger' {$onclick_hapus}><i class='fas fa-recycle fs-4 me-2'></i></a>
					
			</td>"; 
		

		switch($Isi['role_id']){
			case "ROL001":
				$badge="badge-primary";
			break;
			case "ROL101":
				$badge="badge-success";
			break;
			case "ROL102":
				$badge="badge-warning";
			break;
			default:
				$badge="badge-danger";
		}

		switch($Isi['status_id']){
			case "USR001":
				$bread="badge-primary";
			break;
			case "USR101":
				$bread="badge-success";
			break;
			case"USR002":
				$bread="badge-danger";
			break;
			default:
				$bread="badge-danger";
		}
		$ListMode.=" 
			<tr> 
 				<td>{$i}</td>
 				<td>{$Isi['login']}</td>
 				<td>{$Isi['name']}</td>
 				<td><span class='badge {$badge}'>{$Isi['stsrole']}</span></td>
 				<td>{$Isi['email']}</td>
 				<td>{$Isi['mobile']}</td>
				<td><span class='badge {$bread}'>{$Isi['status_user']}</span></td>
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
			
				
			<table id='kt_datatable_example_3' class='table table-row-dashed  gy-5 gs-7'>
			<thead>
				<tr class='fw-bold fs-6 text-gray-800'>
					<th class='min-w-10px'>No</th>
					<th class='min-w-300px'>Username</th>
					<th class='min-w-100px'>Name</th>
					<th class='min-w-100px'>Role</th>
					<th class='min-w-200px'>Email</th>
					<th class='min-w-100px'>No. Ponsel</th>
					<th class='min-w-150px'>Status</th>
					<th class='min-w-150px'>Aksi</th>
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