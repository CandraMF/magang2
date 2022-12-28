<?php
	$revisi_ke=!empty($revisi_ke)?$$revisi_ke:0;
	switch($Action)
	{
		case "Simpan";
			if(!empty($kdregister)){
				foreach ($kdmapform as $k=>$v) {	
					
					if(!empty($kdmapform[$k])){
						switch($nmform[$k]){
							
							case "numeric":
								$insert_param="num_value, ";
								$insert_value="'{$num_value[$k]}', ";
								$update_param="num_value='{$num_value[$k]}', ";
							break;
							case "date":
								$insert_param="date_value, ";
								$insert_value="'{$date_value[$k]}', ";

								$update_param="date_value='{$date_value[$k]}', ";
							break;
							case "file":
								/*
															// Check file size
							if ($_FILES["fileToUpload"]["size"] > 500000) {
							  echo "Sorry, your file is too large.";
							  $uploadOk = 0;
							}

							// Allow certain file formats
							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
							&& $imageFileType != "gif" ) {
							  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
							  $uploadOk = 0;
							}

							*/
								$vcode=substr(date('Y'),-2).date('md').uniqid();
								$flname=$_FILES['text_value']['name'][$k];
								$namaFile = $vcode."_".$flname;
								$namaFile=str_replace(" ","_",$namaFile);
								$namaSementara = $_FILES['text_value']['tmp_name'][$k];
								$dirUpload = "./drive-data/dokumen-usulan/";
								$terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);

								$insert_param="text_value, ";
								$insert_value="'".@$namaFile."', ";

								$update_param="text_value='{$namaFile}', ";
							break;
							default:
								$insert_param="text_value, ";
								$insert_value="'{$text_value[$k]}', ";

								$update_param="text_value='{$text_value[$k]}', ";
							
						}

						
						$Func->ambilData("select kddokumen, nmdokumen from t_prohuk where kdregister='{$kdregister}'");
						$Func->ambilData("select kdmap, nmmapform from t_map_form WHERE kdmapform='{$kdmapform[$k]}'");
						
						$QCekStatus=_mysql_query("SELECT * FROM t_prohuk_status WHERE kdregister='{$kdregister}' AND kdmap='{$kdmap}';");
						
						if(!_mysql_num_rows($QCekStatus)){	
							
							_mysql_query("INSERT INTO t_prohuk_status (kdregister, kddokumen, nmdokumen, kdmap, revisi_ke, created_by, created_date) VALUES ('{$kdregister}', '{$kddokumen}', '{$nmdokumen}', '{$kdmap}', '{$revisi_ke}', '{$pcreated_by}', '{$pcreated_date}');");
						}
						if($nmform[$k]=="file"){
							if(!empty($flname)){
								$QCek=_mysql_query("SELECT * FROM t_prohuk_form WHERE kdregister='{$kdregister}' AND kdmapform='{$kdmapform[$k]}';");
								if(!_mysql_num_rows($QCek)){				
									  
									$Simpan=_mysql_query("INSERT INTO t_prohuk_form (kdregister, kddokumen, nmdokumen, kdmap, kdmapform, nmmapform, revisi_ke, {$insert_param} created_by, created_date) VALUES ('{$kdregister}', '{$kddokumen}', '{$nmdokumen}', '{$kdmap}', '{$kdmapform[$k]}', '{$nmmapform}', '{$revisi_ke}', {$insert_value} '{$pcreated_by}', '{$pcreated_date}');");
								}else{
									$Simpan=_mysql_query("UPDATE t_prohuk_form SET {$update_param} updated_by='{$pupdated_by}', updated_date='{$pupdated_date}' WHERE  kdregister='{$kdregister}' AND kdmapform='{$kdmapform[$k]}';");
								}
								$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";
							}
							
						}else{
							$QCek=_mysql_query("SELECT * FROM t_prohuk_form WHERE kdregister='{$kdregister}' AND kdmapform='{$kdmapform[$k]}';");
							if(!_mysql_num_rows($QCek)){				
								 
								$Simpan=_mysql_query("INSERT INTO t_prohuk_form (kdregister, kddokumen, nmdokumen, kdmap, kdmapform, nmmapform, revisi_ke, {$insert_param} created_by, created_date) VALUES ('{$kdregister}', '{$kddokumen}', '{$nmdokumen}', '{$kdmap}', '{$kdmapform[$k]}', '{$nmmapform}', '{$revisi_ke}', {$insert_value} '{$pcreated_by}', '{$pcreated_date}');");
							}else{
								$Simpan=_mysql_query("UPDATE t_prohuk_form SET {$update_param} updated_by='{$pupdated_by}', updated_date='{$pupdated_date}' WHERE  kdregister='{$kdregister}' AND kdmapform='{$kdmapform[$k]}';");
							}
							$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
						
						}
						
					}
				}
			}
			else
			{$Pesan = $Func->ViewPesan("Maaf, form warna merah wajib diisi");}
		break;
		case "Lihat":
			$Func->ambilData("select * from t_prohuk where kdregister='".$idPop."'");
			$Readonly="readonly";
		break;
	}
	$ParamDisable="";$ParamHiden="";
	if($idmapSet!=$idmap){
		$ParamDisable="disabled";
		$ParamHiden="style='display:none;'";
	}

	$Func->ambilData("SELECT a.kdmap, a.kddokumen, a.nourut, a.nmmap, a.tipe, b.nmdokumen, a.idgroupakses as pv_idgroupakses,  c.nmgroupakses from t_map_dokumen as a inner join ref_dokumen as b on a.kddokumen=b.kddokumen inner join __t_group_akses as c on a.idgroupakses=c.idgroupakses where a.idmap='".$idmap."' ORDER BY b.kddokumen, a.kdmap");
	
	$Func->ambilData("select idgroupakses as param_idgroupakses from __t_users where username='{$sUserId}'");
	switch($param_idgroupakses){
		case "1":
			
		break;
		default:
			if($param_idgroupakses!=$pv_idgroupakses){
				$ParamDisable="disabled";
				$ParamHiden="style='display:none;'";
			}
	}

	$Qry="select a.mandatory, a.idmapform, a.nmmapform, a.kdmapform, a.level, b.nmform, a.arrdata, a.nmurl, a.catatan, a.aktif, c.text_value, c.num_value, c.date_value from t_map_form as a
	inner join ref_form as b on a.idform=b.idform 
	left join (select kdmapform, text_value, num_value, date_value  from t_prohuk_form where revisi_ke='".$revisi_ke."' and kdregister='".$kdregister."') as c on a.kdmapform=c.kdmapform
	where a.kdmap='{$kdmap}'
	order by a.tr, a.kdmapform";
	$Qry=_mysql_query($Qry);$i=1; 
	while($Isi=_mysql_fetch_array($Qry)){ 
		$wrn=$Isi['mandatory']=='Y'?"color:red;":"";
		switch($Isi['level']){
			case "H":
				$css="style='font-weight:bold;border-bottom:1px dashed #D0D5DB;width:100%;{$wrn}'";
				
			break;
			case "D":
				$css="style='padding-left:5px;{$wrn}'";
				
			break;
			
			default:
				$css="";
		}

		switch($Isi['nmform']){
			case "textarea":
				$tdform=$Func->cKeditor("text_value[".($i-1)."]",@$Isi['text_value'],"{$ParamDisable}");
			break;
			case "text":
				$tdform=$Func->txtField("text_value[".($i-1)."]",@$Isi['text_value'],'','100','text',"{$ParamDisable} placeholder='{$Isi['catatan']}'");
			break;
			case "file":
				$tdform=$Func->txtField("text_value[".($i-1)."]",@$Isi['text_value'],'','100','file',"{$ParamDisable} placeholder='{$Isi['catatan']}'");
				if(!empty($Isi['text_value'])){
					$tdform.="
					<p align=right style='margin-top:3px;'>
						
							<button type='button' class='btn btn-danger position-relative p-0 avatar-xs rounded' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='Lihat Dokumen' onclick=\"window.open('{$Url->BasePrint}/{$Pg}/{$Pr}/readfile/unduh/0/{$Isi['text_value']}', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=0,left=0,width=600,height=800');\">
							<span class='avatar-title bg-transparent'>
								<i class='bx ri-eye-2-line'></i>
							</span>
							
							</button>
						
						<a href='{$Url->BasePrint}/{$Pg}/{$Pr}/detail/unduh/0/{$Isi['text_value']}' target='_blank'>
						<button type='button' class='btn btn-primary position-relative p-0 avatar-xs rounded' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='Unduh File'>
							<span class='avatar-title bg-transparent'>
								<i class='bx ri-download-cloud-line'></i>
							</span>
							
						</button>
						</a>
					</p>";
				}
			break;
			case "numeric":
				$tdform=$Func->txtNumber("num_value[".($i-1)."]",floatval(@$Isi['num_value']),'','100','text',"{$ParamDisable} placeholder='{$Isi['catatan']}'");
			break;
			case "cmb":
				$arrdata=$Isi['arrdata'];
				$arrdata=str_replace('"','',$arrdata);
				$arrdata=str_replace("'","",$arrdata);
				$arrdata=str_replace("&#039;","",$arrdata);
				$arrdata=str_replace("&quot;","",$arrdata);
				$arrdata=explode(",",$arrdata);
				$tdform=$Func->cmbUmum("text_value[".($i-1)."]",@$Isi['text_value'],$arrdata,"{$ParamDisable} style='width:100%;background:".$wh.";border-top:0px;border-left:0px;border-right:0px;'");
			break;
			case "date":
				$date_value=!empty($Isi['date_value'])?$Isi['date_value']:date('Y-m-d');
				$tdform=$Func->txtField("date_value[".($i-1)."]",@$date_value,'','100','date',"{$ParamDisable}");
			break;
			case "href":
				$tdform="<a href='".@$Isi['nmurl']."' target='_blank' class='btn btn-success btn-sm' onclick=\"Fm.text_value{$i}.value='{$Url->BasePrint}/{$Pg}/{$Pr}/detail/unduh/0/".@$vtext_value."';\"><i class='ri-download-2-fill align-middle me-1'></i> Unduh</a>";
				$tdform.=$Func->txtFieldId("text_value[".($i-1)."]",@$Isi['text_value'],'','100','hidden'," id='text_value{$i}'");
			break;
			case "href form":
				$Func->ambilData("SELECT text_value as vtext_value FROM t_prohuk_form where kdmapform='".@$Isi['nmurl']."' and kdregister='".$kdregister."' and kddokumen='".$kddokumen."'");

				$tdform="<a href='{$Url->BasePrint}/{$Pg}/{$Pr}/detail/unduh/0/".@$vtext_value."'  target='_blank' class='btn btn-success btn-sm'  onclick=\"Fm.text_value{$i}.value='{$Url->BasePrint}/{$Pg}/{$Pr}/detail/unduh/0/".@$vtext_value."';\"><i class='ri-download-2-fill align-middle me-1'></i> Unduh</a>";

				$tdform.=$Func->txtFieldId("text_value[".($i-1)."]",@$Isi['text_value'],'','100','hidden'," id='text_value{$i}'");
			break;
			default:
				$tdform="";
			
		}
		
	

		$ListMode.=" 
			<div class='row g-3 ' style='margin-bottom:10px;'>
				<div class='col-xxl-12 col-sm-6'>
					<div>
					
						<label for='valueInput' class='form-label' {$css} >{$Isi['nmmapform']}</label>
						".$Func->txtField("nmform[".($i-1)."]",@$Isi['nmform'],'','','hidden')." 
						".$Func->txtField("kdmapform[".($i-1)."]",@$Isi['kdmapform'],'','','hidden')." 
						".$Func->txtField("mandatory[".($i-1)."]",@$Isi['mandatory'],'','','hidden')." 
						{$tdform}
					</div>
				</div>
			</div>
		";$i++; 
	}
	
	$ContentBottomIsi="
		<div class='row'>
			<div class='col-xxl-12'>
				<div class='card'>
					<div class='card-body p-12'>
						<div>
							<div class='row'>
								<div class='col-lg-10'>
									<h6 class='text-muted text-uppercase fw-semibold mb-4'>Dokumen Informasi</h6>
								</div>
								<div class='col-lg-2' align=right>
									<a href='{$Url->BaseMain}/{$Pg}/{$Pr}' title='Kembali Ke Dokumen Usulan' >
										<i class='ri-reply-fill label-icon align-middle fs-16 me-2'  class='btn btn-primary btn-label text-muted'> </i>Kembali
									</a>
								</div>
							</div>
							
							<div class='table-responsive'>
								<table class='table mb-0 table-borderless'>
									<tbody>
										<tr>
											<th><span class='fw-medium'>Dokumen </span></th>
											<td class='contact-born text-muted mb-0'>{$nmdokumen}</td>
										</tr>
										<tr>
											<th><span class='fw-medium'>Aktor</span></th>
											<td class='contact-born text-muted mb-0'>{$nmgroupakses}</td>
										</tr>
									
										<tr>
											<th><span class='fw-medium'>Deskripsi</span></th>
											<td class='contact-born text-muted mb-0'>{$kdmap} {$nmmap}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		$Pesan
		<div class='card'>
			<div class='card-body'>
				<h6 class='text-muted text-uppercase fw-semibold mb-4'>Form Isian Data Pengajuan</h6>
				{$ListMode}
			</div>
		</div>

		<!-- end card -->

		<div class='row'>
			<div class='col-lg-9'>
				<button type='button' class='btn btn-warning w-sm' {$ParamHiden} onclick=\"Fm.pkddokumen.value='{$pkddokumen}';Fm.tahap.value='".($tahap-1)."';Fm.Sb.value='dok_proses';Fm.Action.value='prev';Fm.submit();\">Kembali </button>
				<button type='submit' class='btn btn-success w-sm' {$ParamHiden} onclick=\"Fm.pkddokumen.value='{$pkddokumen}';Fm.tahap.value='".($tahap+1)."';Fm.Sb.value='dok_proses';Fm.Action.value='next';Fm.submit();\">Selanjutnya</button>
			</div>
			<div class='col-lg-3' align=right>
				<button type='submit' class='btn btn-success w-sm' onclick=\"Fm.Action.value='Simpan';Fm.submit();\" {$ParamHiden}>Simpan</button>
			</div>
		</div>

	";
	
?>