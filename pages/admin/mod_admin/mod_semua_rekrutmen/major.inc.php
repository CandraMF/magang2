<?php
	$MainJudul="";
	$Main->MainJudul="Utama";
	$Main->Judul="Jurusan";
	$recruitment_id=$idPop;
	$Pesan="";
	$ParamAksi="";
	switch($Aksi)
	{
		case "Simpan";
			if(!empty($major_id)){
				$QTmp="select count(*) as jml from magang.recruitment_major_tx where id='{$idPopSub}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	
				$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;			
				$Func->ambilData("select name as major from magang.major_tr where major_id='{$major_id}'");
				if ($jCount > 0)
				{	
					$Qry="UPDATE magang.recruitment_major_tx SET recruitment_id='{$recruitment_id}', major_id='{$major_id}', major='{$major}',  description='{$pdescription}' WHERE  id='{$idPopSub}';";}
				else
				{
					$Qry="INSERT INTO magang.recruitment_major_tx (recruitment_id, major_id, major, description) VALUES ('{$recruitment_id}', '{$major_id}', '{$major}', '{$pdescription}');";
				}
			
				$Simpan=_mysql_query( $Qry );
				
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				//echo "<script>setTimeout(function(){ Fm2.Aksi.value='';Fm2.submit(); }, 100);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from magang.recruitment_major_tx where id='".$idPopSub."'");
			$plogin=$login;
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
			$Readonly="readonly";
		break;
		case "Hapus":
			_mysql_query("delete from magang.recruitment_major_tx where id='".$idPopSub."'");
			$Func->kosongkanData("magang.recruitment_major_tx");
			echo "<script>Fm2.Aksi.value='BknSimpan';Fm2.Mode.value='';Fm2.submit();</script>";	
		break;
		case "Baru":
			$Func->kosongkanData("magang.recruitment_major_tx");
			$plogin=$login;
			$idPopSub="";
			$ParamAksi="<script>setTimeout(function(){  $('#kt_modal_1').modal('show'); }, 500);</script>";
		break;
		default:
			if(empty($Aksi)){$Func->kosongkanData("magang.recruitment_major_tx");}
	}

	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$Qry="SELECT * FROM magang.recruitment_major_tx as a where recruitment_id='{$idPop}' order by a.id"; 
	
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
 				<td>{$Isi['major']}</td>
 				<td>{$Isi['description']}</td>
				{$td}
			</tr> 
		";$i++; 
	}

	include "{$Dir->ModAdmin}{$Pr}/major_detail.inc.php";
	///////////////////////////
	$Func->ambilData("SELECT a.status_id as sstatus_id, a.position as sposition, b.sts as ssts, a.department as sdepartment, a.open_date as sopen_date, a.close_date as sclose_date, a.letter as sletter, a.letter_date as sletter_date, a.description as sdescription FROM magang.recruitment_tx as a inner join (select status_id, name as sts from magang.status_tr where type='Status Rekrutmen') as b on a.status_id=b.status_id where a.recruitment_id='{$idPop}' order by a.recruitment_id");

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
	///////////////////////////
	$Main->Isi = "{$Pesan}
	<form name=Fm2 id=Fm2 method=post Aksi='{$Url->BaseMain}/{$Pg}/{$Pr}/' enctype='multipart/form-data'> 
	".$Func->txtField('Pr',$Pr,'','','hidden')." 
	".$Func->txtField('Mode',$Mode,'','','hidden')." 
	".$Func->txtField('Aksi',$Aksi,'','','hidden')." 
	".$Func->txtField('idPop',$idPop,'','','hidden')." 
	".$Func->txtField('idPopSub',$idPopSub,'','','hidden')." 
		<div class='py-10'>
			<div class='card shadow-sm'>
				<div class='card-header'>
					<h3 class='card-title'>Jurusan Rekrutmen</h3>
					<div class='card-toolbar'>
						
						<button type='button' class='btn btn-sm btn-light'>
							<a href='{$Url->BaseMain}/{$Pg}/{$Pr}/'   >Kembali</a>
						</button>
					</div>
				</div>
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
				<div class='card-body'>
					<a href='#' class='btn btn-success me-2 mb-2' onclick=\"Fm2.Aksi.value='Baru';Fm2.submit();\" ><i class='las fa-folder-plus fs-2 me-2'></i>Tambah Data</a>
					
					<table id='kt_datatable_example_3' class='table table-striped gy-5 gs-7'>
						<thead>
							<tr class='fw-bold fs-6 text-gray-800'>
								<th class='min-w-10px'>No</th>
								<th class='min-w-100px'>Jurusan</th>
								<th class='min-w-100px'>Keterangan</th>
								<th class='min-w-50px'>Aksi</th>
							</tr>
						</thead>
						<tbody>
							$ListMode
						</tbody>
					</table>
				</div>
			
			<div>
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