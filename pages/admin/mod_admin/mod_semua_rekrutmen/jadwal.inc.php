<?php
	$MainJudul="";
	$Main->MainJudul="Master Data";
	$Main->Judul="Data Daerah";
	$recruitment_id=$idPop;
	$Pesan="";
	$ParamAksi="";
	switch($Aksi)
	{
		case "Simpan";
			if(!empty($action_id)){
				$QTmp="select count(*) as jml from magang.recruitment_schedule_tx where id='{$idPopSub}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	
				$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;			
				$Func->ambilData("select name as paction from magang.status_tr where status_id='{$action_id}'");
				if ($jCount > 0)
				{	
					$Qry="UPDATE magang.recruitment_schedule_tx SET recruitment_id='{$recruitment_id}', action_id='{$action_id}', action='{$paction}', start_date='{$start_date}', end_date='{$end_date}', status_id='{$pstatus_id}', notes='{$pnotes}' WHERE  id='{$idPopSub}';";}
				else
				{
					$Qry="INSERT INTO magang.recruitment_schedule_tx (recruitment_id, action_id, action, start_date, end_date, status_id, notes) VALUES ('{$recruitment_id}', '{$action_id}', '{$paction}', '{$start_date}', '{$end_date}', '{$pstatus_id}', '{$pnotes}');";
				}
			
				$Simpan=_mysql_query( $Qry );
				
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				//echo "<script>setTimeout(function(){ Fm2.Aksi.value='';Fm2.submit(); }, 100);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from magang.recruitment_schedule_tx where id='".$idPopSub."'");
			$plogin=$login;
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
			$Readonly="readonly";
		break;
		case "Hapus":
			_mysql_query("delete from magang.recruitment_schedule_tx where id='".$idPopSub."'");
			$Func->kosongkanData("magang.recruitment_schedule_tx");
			echo "<script>Fm2.Aksi.value='BknSimpan';Fm2.Mode.value='';Fm2.submit();</script>";	
		break;
		case "Baru":
			$Func->kosongkanData("magang.recruitment_schedule_tx");
			$plogin=$login;
			$idPopSub="";
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
		break;
		default:
			if(empty($Aksi)){$Func->kosongkanData("magang.recruitment_schedule_tx");}
	}

	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$Qry="SELECT * FROM magang.recruitment_schedule_tx as a order by a.id"; 
	$ParamDet="{$Pg}/{$Pr}/{$ckata}/{$Aksi}"; 
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
 				<td>{$Isi['action']}</td>
 				<td>".$Func->TglAll($Isi['start_date'])." [".substr($Isi['start_date'],-8)."]</td>
 				<td>".$Func->TglAll($Isi['end_date'])." [".substr($Isi['end_date'],-8)."]</td>
				{$td}
			</tr> 
		";$i++; 
	}

	include "{$Dir->ModAdmin}{$Pr}/jadwal_detail.inc.php";
	$Main->Isi = "{$Pesan}
	<form name=Fm2 id=Fm2 method=post Aksi='{$Url->BaseMain}/{$Pg}/{$Pr}/' enctype='multipart/form-data'> 
	".$Func->txtField('Pr',$Pr,'','','hidden')." 
	".$Func->txtField('Mode',$Mode,'','','hidden')." 
	".$Func->txtField('Aksi',$Aksi,'','','hidden')." 
	".$Func->txtField('idPop',$idPop,'','','hidden')." 
	".$Func->txtField('idPopSub',$idPopSub,'','','hidden')." 
		<div class='py-10'>
			<a href='#' class='btn btn-success me-2 mb-2' onclick=\"Fm2.Aksi.value='Baru';Fm2.submit();\" ><i class='las fa-folder-plus fs-2 me-2'></i>Tambah Data</a>
			
			<table id='kt_datatable_example_3' class='table table-striped gy-5 gs-7'>
			<thead>
				<tr class='fw-bold fs-6 text-gray-800'>
					<th class='min-w-10px'>No</th>
					<th class='min-w-100px'>Kegiatan</th>
					<th class='min-w-100px'>Mulai</th>
					<th class='min-w-100px'>Selesai</th>
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