<?php
	$Show = $Func->gFile("{$Main->Tema}/kosong.html");	
	$TambahId=!empty($TambahId)?$TambahId:"";
	$Readonly="";
	switch($Aksi)
	{
		case "Simpan";
			if(!empty($kdkatdokumen)&&!empty($kddokumen)&&!empty($nmdokumen)){
				$QTmp="select count(*) as jml from ref_dokumen where iddokumen='{$idPop}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
			
				if ($jCount > 0)
				{$Qry="UPDATE ref_dokumen SET kdkatdokumen='{$kdkatdokumen}', kddokumen='{$kddokumen}', nmdokumen='{$nmdokumen}', updated_by='{$pupdated_by}', updated_date='{$pupdated_date}' WHERE  iddokumen='{$idPop}';";}
				else
				{$Qry="INSERT INTO ref_dokumen (kdkatdokumen, kddokumen, nmdokumen, created_by, created_date) VALUES ('{$kdkatdokumen}', '{$kddokumen}', '{$nmdokumen}', '{$pcreated_by}', '{$pcreated_date}');";}
				
				$Simpan=_mysql_query( $Qry );
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				echo "<script>setTimeout(function(){ Fm.Action.value='Lihat';Fm.submit(); }, 2000);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from ref_dokumen where iddokumen='".$idPop."'");
			$Readonly="readonly";
		break;
		case "Hapus":
			_mysql_query("delete from ref_dokumen where iddokumen='".$idPop."'");
			$Func->kosongkanData("ref_dokumen");
			echo "<script>Fm.Action.value='BknSimpan';Fm.Mode.value='';Fm.submit();</script>";	
		break;
		default:
			if(empty($Aksi)){$Func->kosongkanData("ref_dokumen");}
	}
	
	$Main->Isi="{$Pesan}
		<form name=Fm2 id=Fm2 method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$Mode}' enctype='multipart/form-data'>
			<input type='text' name='x' style='display:none;'>
			<table border=0>
			<tr>
				<td style='border:0px;color:red;'>Kode</td>
				<td>".$Func->txtField('kddokumen',$kddokumen,'5','5','text',"style='width:35%'")."</td>
			</tr>
			<tr>
				<td style='border:0px;color:red;'>Kategori&nbsp;Dokumen</td>
				<td>".$Func->cmbQuery('kdkatdokumen',$kdkatdokumen,"SELECT kdkatdokumen, concat(kdkatdokumen,' ',nmkatdokumen) as nmkatdokumen FROM ref_katdokumen")."</td>
			</tr>
			<tr>
				<td style='border:0px;color:red;'>Nama&nbsp;Kategori</td>
				<td>".$Func->txtField('nmdokumen',$nmdokumen,'','100','text',"style='width:90%'")."</td>
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