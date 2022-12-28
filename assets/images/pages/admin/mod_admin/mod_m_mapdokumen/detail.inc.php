<?php
	$Show = $Func->gFile("{$Main->Tema}/kosong.html");	
	$TambahId=!empty($TambahId)?$TambahId:"";
	$tipe="D";
	$Readonly="";
	$idPop=!empty($idPop)?$idPop:0;
	$idPopSub=!empty($idPopSub)?$idPopSub:0;
	

	switch($Aksi)
	{
		case "Simpan";
			if(!empty($kddokumen)&&!empty($kdmap)&&!empty($nourut)&&!empty($nmmap)&&!empty($idgroupakses)){
				$QTmp="select count(*) as jml from t_map_dokumen where idmap='{$idPop}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
			
				if ($jCount > 0)
				{$Qry="UPDATE t_map_dokumen SET kdmap='{$kdmap}', kddokumen='{$kddokumen}', idgroupakses='{$idgroupakses}', nourut='{$nourut}', nmmap='{$nmmap}', tipe='{$tipe}', updated_by='{$pupdated_by}', updated_date='{$pupdated_date}' WHERE  idmap='{$idPop}';";}
				else
				{$Qry="INSERT INTO t_map_dokumen (kdmap, kddokumen, idgroupakses, nourut, nmmap, tipe, created_by, created_date) VALUES ('{$kdmap}', '{$kddokumen}', '{$idgroupakses}', '{$nourut}', '{$nmmap}', '{$tipe}', '{$pcreated_by}', '{$pcreated_date}');";}
				
				
				$Simpan=_mysql_query( $Qry );
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				echo "<script>setTimeout(function(){ Fm.Action.value='Lihat';Fm.submit(); }, 2000);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from t_map_dokumen where idmap='".$idPop."'");
			$Readonly="readonly";
		break;
		case "Hapus":
			_mysql_query("delete from t_map_dokumen where idmap='".$idPop."'");
		
			$Func->kosongkanData("t_map_dokumen");
			echo "<script>Fm.Action.value='BknSimpan';Fm.Mode.value='';Fm.submit();</script>";	
		break;
		default:
			if(empty($Aksi)||$Aksi=="Baru"){$Func->kosongkanData("t_map_dokumen");}
	}
	
	$kddokumen=!empty($kddokumen)?$kddokumen:$idPopSub;

	$Main->Isi="{$Pesan}
		<form name=Fm2 id=Fm2 method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$Mode}' enctype='multipart/form-data'>
			<input type='text' name='x' style='display:none;'>
			<table border=0>
			
			<tr>
				<td style='border:0px;color:red;'>Jenis&nbsp;Dokumen</td>
				<td>".$Func->cmbQuery('xkddokumen',$kddokumen,"SELECT kddokumen, concat(kddokumen,' ',nmdokumen) as nmdokumen FROM ref_dokumen order by kddokumen","disabled")."</td>
			</tr>
			<tr>
				<td style='border:0px;color:red;'>Kode</td>
				<td>".$Func->txtField('kdmap',$kdmap,'10','10','text',"style='width:35%'")."</td>
			</tr>
			<tr>
				<td style='border:0px;color:red;'>No.&nbsp;Urut</td>
				<td>".$Func->txtField('nourut',$nourut,'10','10','text',"style='width:35%'")."</td>
			</tr>
			<tr>
				<td style='border:0px;color:red;'>Deskripsi</td>
				<td>".$Func->txtField('nmmap',$nmmap,'','100','text',"style='width:90%'")."</td>
			</tr>
			<tr>
				<td style='border:0px;color:red;'>Aktor</td>
				<td>".$Func->cmbQuery('idgroupakses',$idgroupakses,"SELECT idgroupakses, nmgroupakses FROM __t_group_akses")."</td>
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
			".$Func->txtField('tipe',$tipe,'','','hidden')."
			".$Func->txtField('kddokumen',$kddokumen,'','','hidden')."
		</form>

		
	";
	if($Aksi!='Hapus'){
		$Main->Isi = $Func->Kotak($Main->MenuHeader,$Main->Isi,'100%');
	}else{
		$Main->Isi = $Func->Kotak($Main->MenuHeader,'<center><b>Melakukan Proses Hapus</b></center>','100%');
	}
?>