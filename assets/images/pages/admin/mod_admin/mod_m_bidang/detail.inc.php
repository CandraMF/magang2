<?php
	$Show = $Func->gFile("{$Main->Tema}/kosong.html");	
	$TambahId=!empty($TambahId)?$TambahId:"";
	$Readonly="";
	switch($Aksi)
	{
		case "Simpan";
			if(!empty($nmbidang)){
				$QTmp="select count(*) as jml from ref_bidang where idbidang='{$idPop}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
			
				if ($jCount > 0)
				{$Qry="UPDATE ref_bidang SET nmbidang='{$nmbidang}', bidang='{$bidang}', updated_by='{$pupdated_by}', updated_date='{$pupdated_date}' WHERE  idbidang='{$idPop}';";}
				else
				{$Qry="INSERT INTO ref_bidang (nmbidang, bidang, created_by, created_date) VALUES ('{$nmbidang}', '{$bidang}', '{$pcreated_by}', '{$pcreated_date}');";}
				
				$Simpan=_mysql_query( $Qry );
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				echo "<script>setTimeout(function(){ Fm.Action.value='Lihat';Fm.submit(); }, 2000);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from ref_bidang where idbidang='".$idPop."'");
			$Readonly="readonly";
		break;
		case "Hapus":
			_mysql_query("delete from ref_bidang where idbidang='".$idPop."'");
			$Func->kosongkanData("ref_bidang");
			echo "<script>Fm.Action.value='BknSimpan';Fm.Mode.value='';Fm.submit();</script>";	
		break;
		default:
			if(empty($Aksi)){$Func->kosongkanData("ref_bidang");}
	}
	
	$Main->Isi="{$Pesan}
		<form name=Fm2 id=Fm2 method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$Mode}' enctype='multipart/form-data'>
			<input type='text' name='x' style='display:none;'>
			<table border=0>
			<tr>
				<td style='border:0px;color:red;'>Kode&nbsp;Bidang</td>
				<td>".$Func->txtField('bidang',$bidang,'15','15','text',"style='width:80%'")."</td>
			</tr>
			<tr>
				<td style='border:0px;color:red;'>Nama&nbsp;Bidang</td>
				<td>".$Func->txtField('nmbidang',$nmbidang,'','100','text',"style='width:80%'")."</td>
			</tr>
			<tr>
				<td style='border:0px'></td>
				<td style='border:0px'>
					<button type='button' class='btn btn-success btn-label rounded-pill' onclick=\"Fm2.Aksi.value='Simpan';submitForm('#Fm2', '#faceboxisi', Fm2.action);\"><i class='ri-check-double-line label-icon align-middle rounded-pill fs-16 me-2'></i> Simpan</button>
				</td>
			</tr>
			</table>
			".$Func->InfoUser($created_by,$created_date,$updated_by,$updated_date)."		
			".$Func->txtField('Mode',$Mode,'','','hidden')."
			".$Func->txtField('Aksi',$Aksi,'','','hidden')."
			".$Func->txtField('idPop',$idPop,'','','hidden')."
			".$Func->txtField('Pg',$Pg,'','','hidden')."
			".$Func->txtField('Pr',$Pr,'','','hidden')."
			".$Func->txtField('Sb',$Sb,'','','hidden')."
		</form>

		
	";
	if($Aksi!='Hapus'){
		$Main->Isi = $Func->Kotak($Main->MenuHeader,$Main->Isi,'100%');
	}else{
		$Main->Isi = $Func->Kotak($Main->MenuHeader,'<center><b>Melakukan Proses Hapus</b></center>','100%');
	}
?>