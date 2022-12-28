<?php
	$Show = $Func->gFile("{$Main->Tema}/kosong.html");	
	$TambahId=!empty($TambahId)?$TambahId:"";
	$tipe=!empty($tipe)?$tipe:"D";
	$catatan=!empty($catatan)?$catatan:"-";
	$kdmap=!empty($kdmap)?$kdmap:$idPopSub;
	$tr=!empty($tr)?$tr:1;
	$td=!empty($td)?$td:1;
	$idPop=!empty($idPop)?$idPop:0;
	$idform=!empty($idform)?$idform:1;
	$mandatory=!empty($mandatory)?$mandatory:'Y';
	$aktif=!empty($aktif)?$aktif:'Y';
	$Readonly="";
	
	switch($Aksi)
	{
		case "Simpan";
			if(!empty($kdmap)&&!empty($kdmapform)&&!empty($nmmapform)&&!empty($idform)){
				$QTmp="select count(*) as jml from t_map_form where idmapform='{$idPop}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
			
				if ($jCount > 0)
				{$Qry="UPDATE t_map_form SET nmmapform='{$nmmapform}', level='{$level}', idform='{$idform}', arrdata='{$arrdata}', nmurl='{$nmurl}', catatan='{$catatan}', tr='{$tr}', td='{$td}', aktif='{$aktif}', mandatory='{$mandatory}', updated_by='{$pupdated_by}', updated_date='{$pupdated_date}' WHERE  idmapform='{$idPop}';";}
				else
				{$Qry="INSERT INTO t_map_form (kdmap, kdmapform, nmmapform, level, idform, arrdata, nmurl, catatan, tr, td, aktif, mandatory, created_by, created_date) VALUES ('{$kdmap}', '{$kdmapform}', '{$nmmapform}', '{$level}', '{$idform}', '{$arrdata}', '{$nmurl}', '{$catatan}', '{$tr}', '{$td}', '{$aktif}', '{$mandatory}', '{$pcreated_by}', '{$pcreated_date}');";}
				
				$Simpan=_mysql_query( $Qry );
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				echo "<script>setTimeout(function(){ Fm.Action.value='Lihat';Fm.submit(); }, 2000);</script>";	
			}else{
				$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";
			}
		break;
		case "Lihat":
			$Func->ambilData("select * from t_map_form where idmapform='".$idPop."'");
			$Readonly="readonly";
		break;
		
		case "Hapus":
			_mysql_query("delete from t_map_form where idmapform='".$idPop."'");
			$Func->kosongkanData("t_map_form");
			echo "<script>Fm.Action.value='BknSimpan';Fm.Mode.value='';Fm.submit();</script>";	
		break;
		default:
			if(empty($Aksi)||($Aksi=="Baru")){$Func->kosongkanData("t_map_form");}
	}
	$FormArray="";
	if($idform=="5"){
		$FormArray.="			
			<td width='10%'>Array&nbsp;Data </td>
			<td>".$Func->txtField('arrdata',$arrdata,'','','text',"placeholder=\"'Normal','Tidak Normal'\" style='width:80%'")."</td>							
		";
	}else{
		$FormArray.="".$Func->txtField('arrdata','-','','','hidden')."";
	}
		
	

	

	//////////////////////
	$kdmap=!empty($kdmap)?$kdmap:$idPopSub;
	$idform=!empty($idform)?$idform:1;
	$aktif=!empty($aktif)?$aktif:'Y';
	$level=!empty($level)?$level:'D';
	$tr=!empty($tr)?$tr:1;
	$kdmapform=!empty($kdmapform)?$kdmapform:"{$kdmap}.XXX";
	$catatan=!empty($catatan)?$catatan:"-";

	if($idform=="9"){
		$FormArray.="			
			<td width='10%'>Url Form</td>
			<td>".$Func->cmbQuery('nmurl',$nmurl,"select a.kdmapform, a.nmmapform from t_map_form as a inner join t_map_dokumen as b on a.kdmap=b.kdmap where a.idform='7' and b.kddokumen in (select kddokumen from t_map_dokumen where kdmap='{$kdmap}') order by a.kdmapform")."</td>							
		";
	}else{
		if($idform=="6"){
			$FormArray.="			
				<td width='10%'>Url</td>
				<td>".$Func->txtField('nmurl',$nmurl,'','','text',"style='width:80%'")."</td>							
			";
		}else{
			$FormArray.="".$Func->txtField('nmurl','-','','','hidden')."";
		}
	}

	///////////////////

	$Main->Isi="{$Pesan}
		<form name=Fm2 id=Fm2 method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$Mode}' enctype='multipart/form-data' style='margin-top:3px;'>
			<input type='text' name='x' style='display:none;'>
			<table border=0>
		
			<tr>
				<td style='border:0px;color:red;'>Kode</td>
				<td>".$Func->txtField('kdmapform',$kdmapform,'50','50','text',"style='width:40%' {$Readonly}")."</td>
			</tr>
			<tr>
				<td style='border:0px;color:red;'>Deskripsi&nbsp;Form</td>
				<td>".$Func->txtField('nmmapform',$nmmapform,'','100','text',"style='width:80%'")."</td>
			</tr>
			<tr>
				<td style='border:0px;color:red;'>Level </td>
				<td>".$Func->cmb2D('level',$level,array(array('H','Header'),array('D','Detail')),"style='width:30%'")."</td>
			</tr>
			<tr>
				<td style='border:0px;color:red;'>Jenis&nbsp;Form </td>
				<td>
					".$Func->cmbQuery('idform',$idform,"SELECT idform, nmform FROM ref_form","style='width:40%' onchange=\"Fm2.Aksi.value='BknSimpan';submitForm('#Fm2', '#faceboxisi', Fm2.action);\"")."
				</td>
			</tr>
			<tr>
				{$FormArray}
			</tr>
			<tr>
				<td>Keterangan</td>
				<td>".$Func->txtField('catatan',$catatan,'','100','text',"style='width:80%'")."</td>
			</tr>
			<tr>
				<td>Urutan</td>
				<td>".$Func->txtField('tr',$tr,'2','2','text',"style='width:50px'")."</td>				
			</tr>
			<tr>
				<td>Mandatory</td>
				<td>
					<table width='50%'>
					<tr>
						<td>".$Func->cmb2D('mandatory',$mandatory,array(array('Y','Ya'),array('N','Tidak')),"style='width:100%'")."</td>	
						<td>Aktif</td>
						<td>".$Func->cmb2D('aktif',$aktif,array(array('Y','Aktif'),array('N','Tidak Aktif')),"style='width:100%'")."</td>
					</tr>
					</table>
				</td>
				
			</tr>
			<tr>
								
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
			".$Func->txtField('kdmap',$kdmap,'','','hidden')."
			".$Func->txtField('Sb',$Sb,'','','hidden')."
			".$Func->txtField('td',1,'','','hidden')."
		</form>

		
	";
	if($Aksi!='Hapus'){
		$Main->Isi = $Func->Kotak($Main->MenuHeader,$Main->Isi,'100%');
	}else{
		$Main->Isi = $Func->Kotak($Main->MenuHeader,'<center><b>Melakukan Proses Hapus</b></center>','100%');
	}
?>