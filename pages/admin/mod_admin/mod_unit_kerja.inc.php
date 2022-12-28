<?php
	$MainJudul="";
	$Main->MainJudul="Master Data";
	$Main->Judul="Unit Kerja";
	$idSub=!empty($idSub)?$idSub:"";
	$Pesan="";
	$ParamAksi="";
	switch($Action)
	{
		case "Simpan";
			if(!empty($name)&&!empty($head_id)){
				$QTmp="select count(*) as jml from magang.department_tr where department_id='{$idSub}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	
				$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;			
				if ($jCount > 0)
				{	
					$Qry="UPDATE magang.department_tr SET name='{$name}', head_id='{$head_id}' WHERE  department_id='{$idSub}';";}
				else
				{$Qry="INSERT INTO magang.department_tr (name, head_id) VALUES ('{$name}', '{$head_id}');";}
			
				$Simpan=_mysql_query( $Qry );
				
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				//echo "<script>setTimeout(function(){ Fm.Action.value='';Fm.submit(); }, 100);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from magang.department_tr where department_id='".$idSub."'");
		echo $head_id;
			$plogin=$login;
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
			$Readonly="readonly";
		break;
		case "Hapus":
			_mysql_query("delete from magang.department_tr where department_id='".$idSub."'");
			$Func->kosongkanData("magang.department_tr");
			echo "<script>Fm.Action.value='BknSimpan';Fm.Mode.value='';Fm.submit();</script>";	
		break;
		case "Baru":
			$Func->kosongkanData("magang.department_tr");
			$plogin=$login;
			$idSub="";
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
		break;
		default:
			if(empty($Action)){$Func->kosongkanData("magang.department_tr");}
	}

	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	
	$Qry="select a.department_id, a.head_id ,a.name, b.sts from magang.department_tr as a inner join (select status_id, name as sts from magang.status_tr where type='Status Unit Kerja') as b on a.status_id=b.status_id where a.head_id isnull order by code"; 
	$Qry=_mysql_query($Qry); 
	while($Isi=_mysql_fetch_array($Qry)){ 
		$onclick_edit="onclick=\"Fm.idSub.value='{$Isi['department_id']}';Fm.Action.value='Lihat';Fm.submit();\" ";
		$onclick_hapus="onclick=\"Cek=confirm('Apakah yakin akan menghapus data?');if(!Cek){return false;}else{Fm.idSub.value='{$Isi['department_id']}';Fm.Action.value='Hapus';Fm.submit();}\"";
		$td=" 
			<td>
				<a href='#' class='btn btn-icon btn-warning' {$onclick_edit}><i class='fas fa-edit fs-4 me-2'></i></a>
				<a  href='#' class='btn btn-icon btn-danger' {$onclick_hapus}><i class='fas fa-recycle fs-4 me-2'></i></a>
			</td>"; 
		$ListMode.=" 
			<tr> 
 				<td>{$i}</td>
 				<td>{$Isi['name']}</td>
 				<td>{$Isi['sts']}</td>
				{$td}
			</tr> 
		";
		$Qry01="select a.department_id, a.head_id ,a.name, b.sts from magang.department_tr as a inner join (select status_id, name as sts from magang.status_tr where type='Status Unit Kerja') as b on a.status_id=b.status_id where a.head_id ='".floatval($Isi['department_id'])."' order by code"; 
		$ia=1;
		$Qry01=_mysql_query($Qry01); 
		while($Isi01=_mysql_fetch_array($Qry01)){ 
			$onclick_edit="onclick=\"Fm.idSub.value='{$Isi01['department_id']}';Fm.Action.value='Lihat';Fm.submit();\" ";
			$onclick_hapus="onclick=\"Cek=confirm('Apakah yakin akan menghapus data?');if(!Cek){return false;}else{Fm.idSub.value='{$Isi01['department_id']}';Fm.Action.value='Hapus';Fm.submit();}\"";
			$td=" 
				<td>
					<a href='#' class='btn btn-icon btn-warning' {$onclick_edit}><i class='fas fa-edit fs-4 me-2'></i></a>
					<a  href='#' class='btn btn-icon btn-danger' {$onclick_hapus}><i class='fas fa-recycle fs-4 me-2'></i></a>
				</td>"; 
			$ListMode.=" 
				<tr> 
					<td>{$i}.{$ia}</td>
					<td style='padding-left:30px;'>{$Isi01['name']}</td>
					<td>{$Isi01['sts']}</td>
					{$td}
				</tr> 
			";
			
			$Qry02="select a.department_id, a.head_id ,a.name, b.sts from magang.department_tr as a inner join (select status_id, name as sts from magang.status_tr where type='Status Unit Kerja') as b on a.status_id=b.status_id where a.head_id ='".floatval($Isi01['department_id'])."' order by code"; 
			$ib=1;
			$Qry02=_mysql_query($Qry02); 
			while($Isi02=_mysql_fetch_array($Qry02)){ 
				$onclick_edit="onclick=\"Fm.idSub.value='{$Isi02['department_id']}';Fm.Action.value='Lihat';Fm.submit();\" ";
				$onclick_hapus="onclick=\"Cek=confirm('Apakah yakin akan menghapus data?');if(!Cek){return false;}else{Fm.idSub.value='{$Isi02['department_id']}';Fm.Action.value='Hapus';Fm.submit();}\"";
				$td=" 
					<td>
						<a href='#' class='btn btn-icon btn-warning' {$onclick_edit}><i class='fas fa-edit fs-4 me-2'></i></a>
						<a  href='#' class='btn btn-icon btn-danger' {$onclick_hapus}><i class='fas fa-recycle fs-4 me-2'></i></a>
					</td>"; 
				$ListMode.=" 
					<tr> 
						<td>{$i}.{$ia}.{$ib}</td>
						<td style='padding-left:60px;'>{$Isi02['name']}</td>
						<td>{$Isi02['sts']}</td>
						{$td}
					</tr> 
				";

				$Qry03="select a.department_id, a.head_id ,a.name, b.sts from magang.department_tr as a inner join (select status_id, name as sts from magang.status_tr where type='Status Unit Kerja') as b on a.status_id=b.status_id where a.head_id ='".floatval($Isi02['department_id'])."' order by code"; 
				$ic=1;
				$Qry03=_mysql_query($Qry03); 
				while($Isi03=_mysql_fetch_array($Qry03)){ 
					$onclick_edit="onclick=\"Fm.idSub.value='{$Isi03['department_id']}';Fm.Action.value='Lihat';Fm.submit();\" ";
					$onclick_hapus="onclick=\"Cek=confirm('Apakah yakin akan menghapus data?');if(!Cek){return false;}else{Fm.idSub.value='{$Isi03['department_id']}';Fm.Action.value='Hapus';Fm.submit();}\"";
					$td=" 
						<td>
							<a href='#' class='btn btn-icon btn-warning' {$onclick_edit}><i class='fas fa-edit fs-4 me-2'></i></a>
							<a  href='#' class='btn btn-icon btn-danger' {$onclick_hapus}><i class='fas fa-recycle fs-4 me-2'></i></a>
						</td>"; 
					$ListMode.=" 
						<tr> 
							<td>{$i}.{$ia}.{$ib}.{$ic}</td>
							<td style='padding-left:90px;'>{$Isi03['name']}</td>
							<td>{$Isi03['sts']}</td>
							{$td}
						</tr> 
					";
					$ic++; 
				}
				$ib++; 
			}
			$ia++; 
		}


		$i++; 
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
					<th class='min-w-500px'>Posisi/Jabatan</th>
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