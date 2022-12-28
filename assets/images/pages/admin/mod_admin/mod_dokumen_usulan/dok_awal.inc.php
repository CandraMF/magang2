<?php
	
	$TambahId=!empty($TambahId)?$TambahId:"";
	$pkddokumen=!empty($pkddokumen)?$pkddokumen:"";
	
	$Readonly="";
	
	switch($Action)
	{
		case "Simpan";
	
			if(!empty($kdregister)&&!empty($idbidang)&&!empty($tglpengajuan)&&!empty($kddokumen)&&!empty($nmjudul)&&!empty($uraian)){
				$QTmp="select count(*) as jml from t_prohuk where kdregister='{$kdregister}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
				$Func->ambilData("SELECT a.nmdokumen, a.kdkatdokumen FROM ref_dokumen as a where a.kddokumen='{$kddokumen}'");
				if ($jCount > 0){
					$Qry="UPDATE t_prohuk SET kdregister='{$kdregister}', idbidang='{$idbidang}', tglpengajuan='{$tglpengajuan}', kdkatdokumen='{$kdkatdokumen}', kddokumen='{$kddokumen}', nmdokumen='{$nmdokumen}', nmjudul='{$nmjudul}', uraian='{$uraian}', updated_by='{$pupdated_by}', updated_date='{$pupdated_date}' WHERE  kdregister='{$kdregister}';";
				}else{	
					$tahap=0;$kdmap="00.00.000";$ntahap="0";
					$Qry="INSERT INTO t_prohuk (kdregister, idbidang, tglpengajuan, kdkatdokumen, kddokumen, nmdokumen, nmjudul, uraian, tahap, ntahap, kdmap, created_by, created_date) VALUES ('{$kdregister}', '{$idbidang}', '{$tglpengajuan}', '{$kdkatdokumen}', '{$kddokumen}', '{$nmdokumen}', '{$nmjudul}', '{$uraian}', '{$tahap}', '{$ntahap}', '{$kdmap}', '{$pcreated_by}', '{$pcreated_date}');";
				}
				
				$Simpan=_mysql_query( $Qry );
				
				

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
		
		default:
			if(empty($kdregister)){
			
				$Func->kosongkanData('t_prohuk');
				$kdregister=substr(date('Y'),-2).date('md').uniqid();
			}
			
	}
	$tglpengajuan=!empty($tglpengajuan)?$tglpengajuan:date('Y-m-d');

	$kddokumen=!empty($kddokumen)?$kddokumen:$pkddokumen;
	$Func->ambilData("select idprdh  from t_prohuk where kdregister='".$kdregister."'");$idPop=$idprdh;
	if(!empty($idPop)){
		$FormDok="
			".$Func->txtField('kddokumen',@$kddokumen,'','','hidden')." 
			<div class='mb-3'>
				<label class='form-label' for='project-title-input'  style='color:red;'>Dokumen</label>
				".$Func->cmbQuery('vkddokumen',@$kddokumen,'select kddokumen, nmdokumen from ref_dokumen',"disabled")."
			</div>
		";
	}else{
		$FormDok="
			<div class='mb-3'>
				<label class='form-label' for='project-title-input'  style='color:red;'>Dokumen</label>
				".$Func->cmbQuery('kddokumen',@$kddokumen,'select kddokumen, nmdokumen from ref_dokumen',"onchange=\"Fm.pkddokumen.value='';Fm.Action.value='BknSimpan';Fm.submit();\"")."
			</div>
		";
	}
	
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
	if($idmapSet!=$idmap){
		$ParamDisable="disabled";
		$ParamHiden="style='display:none;'";
	}
	
	
	$Func->ambilData("select idgroupakses as param_idgroupakses from __t_users where username='{$sUserId}'");
	

	switch($param_idgroupakses){
		case "1":
			
		break;
		case "2":
			
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
						<h6 class='text-muted text-uppercase fw-semibold mb-4'>Form Dokumen Pengajuan Awal</h6>
					</div>
					<div class='col-lg-2' align=right>
						<a href='{$Url->BaseMain}/{$Pg}/{$Pr}' title='Kembali Ke Dokumen Usulan' >
							<i class='ri-reply-fill label-icon align-middle fs-16 me-2'  class='btn btn-primary btn-label text-muted'> </i>Kembali
						</a>
					</div>
				</div>
				
				{$FormDok}
				<div class='row'>
					<div class='col-lg-3'>
						<div class='mb-2 mb-lg-0'>
						   <label class='form-label' for='project-title-input' style='color:red;'>No. Seri</label>
						   ".$Func->txtField('vkdregister',@$kdregister,'','100','text',"readonly {$ParamDisable}")."								   
						</div>
					</div>
					<div class='col-lg-2'>
						<div class='mb-3 mb-lg-0'>
							<label class='form-label' for='project-title-input'  style='color:red;'>Tgl. Pengajuan</label>
							".$Func->txtField('tglpengajuan',@$tglpengajuan,'','100','date'," {$ParamDisable}")."
						</div>
					</div>
					<div class='col-lg-7'>
						<div class='mb-3 mb-lg-0'>
							<label class='form-label' for='project-title-input' style='color:red;'>Bidang</label>
							".$Func->cmbQuery('idbidang',@$idbidang,'select idbidang, nmbidang from ref_bidang'," {$ParamDisable}")."
						</div>
					</div>
				</div>
				<div class='mb-3'>
					
				</div>
				<div class='mb-3'>
					<label class='form-label' for='project-title-input'  style='color:red;'>Judul Dokumen</label>
					".$Func->txtField('nmjudul',@$nmjudul,'','100','text'," {$ParamDisable}")."
				</div>
				<div class='mb-3'>
					<label class='form-label' for='project-title-input'  style='color:red;'>Uraian</label>
					".$Func->cKeditor("uraian",@$uraian," {$ParamDisable}")."
				</div>
		   

				
			</div>
			<!-- end card body -->
		</div>
		<!-- end card -->

		<div class='row'>
			<div class='col-lg-9'>
				<button type='submit' class='btn btn-success w-sm'  {$ParamHiden} onclick=\"Fm.pkddokumen.value='{$kddokumen}';Fm.tahap.value='".(floatval($tahap)+1)."';Fm.Sb.value='dok_proses';Fm.Action.value='next';Fm.submit();\" $hide>Selanjutnya</button>
			</div>
			<div class='col-lg-3' align=right>
				<!-- <button type='button' class='btn btn-warning w-sm'  onclick=\"javascript:parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}/detail';\">Baru</button> -->
				<button type='submit' class='btn btn-success w-sm' onclick=\"Fm.Action.value='Simpan';Fm.submit();\"  {$ParamHiden}>Simpan</button>
			</div>
		</div>
		<!-- end card -->
		<div class='text-end mb-4'>
			
		</div>

		
	";
	
?>