<?php
	$MainJudul="";
	$Main->MainJudul="Master Data";
	$Main->Judul="Data Jurusan";
	$idSub=!empty($idSub)?$idSub:"";
	$Pesan="";
	$ParamAksi="";
	switch($Action)
	{
		case "Simpan";
			if(!empty($name)){
				$QTmp="select count(*) as jml from magang.major_tr where major_id='{$idSub}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	
				$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;			
				if ($jCount > 0)
				{	
					$Qry="UPDATE magang.major_tr SET name='{$name}' WHERE  major_id='{$idSub}';";}
				else
				{$Qry="INSERT INTO magang.major_tr (name) VALUES ('{$name}');";}
			
				$Simpan=_mysql_query( $Qry );
				
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				//echo "<script>setTimeout(function(){ Fm.Action.value='';Fm.submit(); }, 100);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from magang.major_tr where major_id='".$idSub."'");
			$plogin=$login;
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
			$Readonly="readonly";
		break;
		case "Hapus":
			_mysql_query("delete from magang.major_tr where major_id='".$idSub."'");
			$Func->kosongkanData("magang.major_tr");
			echo "<script>Fm.Action.value='BknSimpan';Fm.Mode.value='';Fm.submit();</script>";	
		break;
		case "Baru":
			$Func->kosongkanData("magang.major_tr");
			$plogin=$login;
			$idSub="";
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
		break;
		default:
			if(empty($Action)){$Func->kosongkanData("magang.major_tr");}
	}

	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$wh=!empty($ckata)?" and lower(nmgroupakses) like '%".strtolower($ckata)."%'":""; 
	$Qry="SELECT a.major_id, a.name FROM magang.major_tr as a order by a.major_id"; 
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

		 	
		$onclick_edit="onclick=\"Fm.idSub.value='{$Isi['major_id']}';Fm.Action.value='Lihat';Fm.submit();\" ";
		$onclick_hapus="onclick=\"Cek=confirm('Apakah yakin akan menghapus data?');if(!Cek){return false;}else{Fm.idSub.value='{$Isi['major_id']}';Fm.Action.value='Hapus';Fm.submit();}\"";
		$td=" 
			<td>
				<a href='#' class='btn btn-icon btn-warning' {$onclick_edit}><i class='fas fa-edit fs-4 me-2'></i></a>
				<a  href='#' class='btn btn-icon btn-danger' {$onclick_hapus}><i class='fas fa-recycle fs-4 me-2'></i></a>
			</td>"; 
		

		
		$ListMode.=" 
			<tr> 
 				<td>{$i}</td>
 				<td>{$Isi['name']}</td>
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
					<th class='min-w-500px'>Jurusan</th>
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