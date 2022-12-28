<?php
	
	$TambahId=!empty($TambahId)?$TambahId:"";
	$pkddokumen=!empty($pkddokumen)?$pkddokumen:"";
	
	$Readonly="";
	
	switch($Action)
	{
		case "Simpan";
	
			if(!empty($kdregister)&&!empty($noregister)&&!empty($tglregister)){
				$QTmp="select count(*) as jml from t_prohuk where kdregister='{$kdregister}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
				$Func->ambilData("SELECT a.nmdokumen, a.kdkatdokumen FROM ref_dokumen as a where a.kddokumen='{$kddokumen}'");
				if ($jCount > 0){
					$Qry="UPDATE t_prohuk SET noregister='{$noregister}', tglregister='{$tglregister}', updated_by='{$pupdated_by}', updated_date='{$pupdated_date}' WHERE  kdregister='{$kdregister}';";
					$Simpan=_mysql_query( $Qry );
				}
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		

				$Func->ambilData("select idprdh  from t_prohuk where kdregister='".$kdregister."'");$idPop=$idprdh;
				
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from t_prohuk where kdregister='".$idPop."'");
			$Readonly="readonly";
		break;
		case "unvalidasi":
			_mysql_query("UPDATE t_prohuk SET tglvalid = null WHERE  kdregister='{$kdregister}';");
		break;
		case "validasi":
			_mysql_query("UPDATE t_prohuk SET tglvalid ='".$pupdated_date."' WHERE  kdregister='{$kdregister}';");
		break;
		
	}
	$tglregister=!empty($tglregister)?$tglregister:date('Y-m-d');

	
	$QTmp="select count(*) as jml from t_prohuk where kdregister='{$kdregister}'";
	$Qry = _mysql_query( $QTmp );	
	$Hasil=_mysql_fetch_array($Qry);	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
	$hide="";
	if ($jCount > 0){
		$Func->ambilData("select * from t_prohuk where kdregister='".$kdregister."'");
	}else{
		$hide="style='display:none;'";
	}
	

	$ParamDisable="";$ParamHiden="";
	if(!empty($tglvalid)){
		$ParamDisable="disabled";
		$ParamValidasi="unvalidasi";
		$ParamHiden="style='display:none;'";
		$ParamHidenDistribusi="";
	}else{
		$ParamValidasi="validasi";

		$ParamHidenDistribusi="style='display:none;'";
	}
	
	$i=1;$ListKirim="";
	$Qry=_mysql_query("select a.idgroupakses, b.nmgroupakses from t_map_dokumen as a inner join __t_group_akses as b on a.idgroupakses=b.idgroupakses where a.kddokumen='{$kddokumen}' group by a.idgroupakses, b.nmgroupakses"); 
	while($Isi=_mysql_fetch_array($Qry)){ 
		
		$ListKirim.=$Func->chkAkhir("kirimakses[".($i-1)."]",$Isi['idgroupakses'])."&nbsp;{$Isi['nmgroupakses']}&nbsp;";
		$i++;
	}
	
	$Func->ambilData("select idgroupakses as param_idgroupakses from __t_users where username='{$sUserId}'");
	switch($param_idgroupakses){
		case "1":
			
		break;
		case "4":
			
		break;
		default:
			$ParamDisable="disabled";
			$ParamHiden="style='display:none;'";
	}
	$ContentBottomIsi="
		$Pesan 
		<div class='card'>
			
			<div class='card-body'>
				<div class='row'>
					<div class='col-lg-10'>
						<h6 class='text-muted text-uppercase fw-semibold mb-4'>Form Dokumen Register Akhir</h6>
					</div>
					<div class='col-lg-2' align=right>
						<a href='{$Url->BaseMain}/{$Pg}/{$Pr}' title='Kembali Ke Dokumen Usulan' >
							<i class='ri-reply-fill label-icon align-middle fs-16 me-2'  class='btn btn-primary btn-label text-muted'> </i>Kembali
						</a>
					</div>
				</div>
				<div class='mb-3'>
					<label class='form-label' for='project-title-input'>ID KODE</label>
					".$Func->txtField('vkdregister',@$kdregister,'','100','text',"readonly ")."		
				</div>
				<div class='row'>
					<div class='col-lg-8'>
						<div class='mb-2 mb-lg-0'>
						   <label class='form-label' for='project-title-input'  style='color:red;'>No. Register</label>
						   ".$Func->txtField('noregister',@$noregister,'','100','text'," {$ParamDisable}")."								   
						</div>
					</div>
					<div class='col-lg-2'>
						<div class='mb-3 mb-lg-0'>
							<label class='form-label' for='project-title-input'  style='color:red;'>Tgl. Register</label>
							".$Func->txtField('tglregister',@$tglregister,'','100','date'," {$ParamDisable}")."
						</div>
					</div>
				
				   
				</div>
				
		   

				
			</div>
			<!-- end card body -->
		</div>
		<!-- end card -->

		<div class='row'>
			<div class='col-lg-8'>
				<button type='button' class='btn btn-warning w-sm' {$ParamHiden} onclick=\"Fm.pkddokumen.value='{$pkddokumen}';Fm.tahap.value='".($tahap-1)."';Fm.Sb.value='dok_proses';Fm.Action.value='prev';Fm.submit();\">Kembali </button>
			</div>
			<div class='col-lg-4' align=right>
				<!-- <button type='button' class='btn btn-warning w-sm'  onclick=\"javascript:parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}/detail';\">Baru</button> -->
				<button type='submit' class='btn btn-success w-sm' onclick=\"Fm.Action.value='Simpan';Fm.submit();\"  {$ParamHiden}>Simpan</button>
				<button type='submit' class='btn btn-secondary  w-sm' onclick=\"Fm.Action.value='".$ParamValidasi."';Fm.submit();\" >".strtoupper($ParamValidasi)."</button>
			</div>
		</div>
		<!-- end card --><br>
		<div class='card' {$ParamHidenDistribusi}>
			
			<div class='card-body'>
				<div class='row'>
					<div class='col-lg-10'>
						<h6 class='text-muted text-uppercase fw-semibold mb-4'>Publish Dokumen</h6>
					</div>
					<div class='col-lg-2' align=right>
							
					</div>
				</div>
				<div class='mb-3'>
					<label class='form-label' for='project-title-input'><strong>Broadcast Email Dan Whatsapp</strong></label><br>
					{$ListKirim}
				</div>
				<div class='mb-3'>
					<label class='form-label' for='project-title-input'><strong>Publish Beranda Portal Hukum</strong></label><br>
					".$Func->chkAkhir("publishberanda",@$publishberanda)." Publish
				</div>
				
			</div>
			<!-- end card body -->
		</div>

		<div class='row' {$ParamHidenDistribusi}>
			<div class='col-lg-8'>
				
			</div>
			<div class='col-lg-4' align=right>
				<button type='button' class='btn btn-success btn-label rounded-pill' onclick=\"Fm.Action.value='publish';Fm.submit();\"><i class='ri-check-double-line label-icon align-middle rounded-pill fs-16 me-2'></i> Publish</button>
			</div>
		</div>
	";
	
?>


