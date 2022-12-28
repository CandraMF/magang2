<?php
	$SegmentIdReg=$Func->decrypt(@$uri->segment[5+$Main->SegmentId], ENCRYPTION_KEY);
	$kdregister=$SegmentIdReg;
	$tdform="";
	$revisi_ke=0;
	$Func->ambilData("SELECT * FROM t_prohuk where kdregister='{$kdregister}';");
	$Qry=_mysql_query("select * from (
		select idmap, kdmap, idgroupakses, nourut, nmmap from t_map_master union
		select idmap, kdmap, idgroupakses, nourut, nmmap from t_map_dokumen where kddokumen='{$kddokumen}'  
		) as z order by z.nourut asc"); 
	$JmlTahapan=_mysql_num_rows($Qry);
	$ListMap="";$i=0;$z=0;

	$idmapSet="";
	while($Isi=_mysql_fetch_array($Qry)){ 
		$div="";
		switch($Isi['idmap']){
			case "800":
				$Func->ambilData("select * from t_prohuk as a left join ref_bidang as b on a.idbidang=b.idbidang where a.kdregister='".$kdregister."'");
				$div="
					<div class='d-flex'>
						<div class='flex-shrink-0'>
							<i class='ri-checkbox-circle-fill text-success'></i>
						</div>
						<div class='flex-grow-1 ms-2'>
							Kode :
							<span class='text-success'>{$kdregister}</span>
						</div>
					</div>
					<div class='d-flex'>
						<div class='flex-shrink-0'>
							<i class='ri-checkbox-circle-fill text-success'></i>
						</div>
						<div class='flex-grow-1 ms-2'>
							Tgl. Pengajuan :
							<span class='text-success'>".$Func->TglAll($tglpengajuan)."</span>
						</div>

					</div>
					<div class='d-flex'>
						<div class='flex-shrink-0'>
							<i class='ri-checkbox-circle-fill text-success'></i>
						</div>
						<div class='flex-grow-1 ms-2'>
							Bidang :
							<span class='text-success'>{$nmbidang}</span>
						</div>
					</div>
					<div class='d-flex'>
						<div class='flex-shrink-0'>
							<i class='ri-checkbox-circle-fill text-success'></i>
						</div>
						<div class='flex-grow-1 ms-2'>
							Judul Dokumen : 
							<span class='text-success'>{$nmjudul}</span> 
						</div>
					</div>
					<div class='d-flex'>
						<div class='flex-shrink-0'>
							<i class='ri-checkbox-circle-fill text-success'></i>
						</div>
						<div class='flex-grow-1 ms-2'>
							Uraian :
							<span class='text-success'>{$uraian}</span> 
						</div>
					</div>

				";
				$expanded="true";

			break;
			case "900":
				$Func->ambilData("select * from t_prohuk as a  where a.kdregister='".$kdregister."'");
				$div="
					<div class='d-flex'>
						<div class='flex-shrink-0'>
							<i class='ri-checkbox-circle-fill text-success'></i>
						</div>
						<div class='flex-grow-1 ms-2'>
							No. Register :
							<span class='text-success'>{$noregister}</span>
						</div>
					</div>
					<div class='d-flex'>
						<div class='flex-shrink-0'>
							<i class='ri-checkbox-circle-fill text-success'></i>
						</div>
						<div class='flex-grow-1 ms-2'>
							Tgl. Register :
							<span class='text-success'>".$Func->TglAll($tglregister)."</span>
						</div>
					</div>
				";
				$expanded="false";
			break;
			default:
				$Func->ambilData("select * from t_prohuk as a  where a.kdregister='".$kdregister."'");
				$expanded="false";
				$QryDiv="select a.mandatory, a.idmapform, a.nmmapform, a.kdmapform, a.level, b.nmform, a.arrdata, a.nmurl, a.catatan, a.aktif, c.text_value, c.num_value, c.date_value from t_map_form as a
				inner join ref_form as b on a.idform=b.idform 
				left join (select kdmapform, text_value, num_value, date_value  from t_prohuk_form where revisi_ke='".$revisi_ke."' and kdregister='".$kdregister."') as c on a.kdmapform=c.kdmapform
				where a.kdmap='{$Isi['kdmap']}'
				order by a.tr, a.kdmapform";
				$QryDiv=_mysql_query($QryDiv);$i=1; 
				while($IsiDiv=_mysql_fetch_array($QryDiv)){ 
					switch($IsiDiv['nmform']){
						case "textarea":
							$tdform=@$IsiDiv['text_value'];
						break;
						case "text":
							$tdform=@$IsiDiv['text_value'];
						break;
						case "file":
							if(!empty($IsiDiv['text_value'])){
								$tdform.="
									<button type='button' class='btn btn-danger position-relative p-0 avatar-xs rounded' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='Lihat Dokumen' onclick=\"window.open('{$Url->BasePrint}/{$Pg}/{$Pr}/readfile/unduh/0/{$IsiDiv['text_value']}', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=0,left=0,width=600,height=800');\">
										<span class='avatar-title bg-transparent'>
											<i class='bx ri-eye-2-line'></i>
										</span>
										
										</button>
									
									<a href='{$Url->BasePrint}/{$Pg}/{$Pr}/detail/unduh/0/{$IsiDiv['text_value']}' target='_blank'>
									<button type='button' class='btn btn-primary position-relative p-0 avatar-xs rounded' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='Unduh File'>
										<span class='avatar-title bg-transparent'>
											<i class='bx ri-download-cloud-line'></i>
										</span>
										
									</button>
									</a>
								";
							}
						break;
						case "numeric":
							if(@$IsiDiv['num_value']){
								$tdform=floatval(@$IsiDiv['num_value']);
							}else{
								$tdform="";
							}
							
						break;
						case "cmb":
							$tdform=@$IsiDiv['text_value'];
						break;
						case "date":
							$date_value=!empty($IsiDiv['date_value'])?$Func->TglAll($IsiDiv['date_value']):"";
							$tdform=@$date_value;
						break;
						case "href":
							$vtext_value=$IsiDiv['text_value'];
							if(!empty($vtext_value)){
								$tdform="<a href='".@$IsiDiv['nmurl']."' target='_blank' class='btn btn-success btn-sm' onclick=\"Fm.text_value{$i}.value='{$Url->BasePrint}/{$Pg}/{$Pr}/detail/unduh/0/".@$vtext_value."';\"><i class='ri-download-2-fill align-middle me-1'></i> Unduh</a>";
							}else{
								$tdform="";
							}
							
						break;
						case "href form":
							$Func->ambilData("SELECT text_value as vtext_value FROM t_prohuk_form where kdmapform='".@$IsiDiv['nmurl']."' and kdregister='".$kdregister."' and kddokumen='".$kddokumen."'");

							$tdform="<a href='{$Url->BasePrint}/{$Pg}/{$Pr}/detail/unduh/0/".@$vtext_value."'  target='_blank' class='btn btn-success btn-sm'  onclick=\"Fm.text_value{$i}.value='{$Url->BasePrint}/{$Pg}/{$Pr}/detail/unduh/0/".@$vtext_value."';\"><i class='ri-download-2-fill align-middle me-1'></i> Unduh</a>";
						break;
						default:
							$tdform="";
						
					}
					
					$div.="
						<div class='d-flex'>
							<div class='flex-shrink-0'>
								<i class='ri-checkbox-circle-fill text-success'></i>
							</div>
							<div class='flex-grow-1 ms-2'>
								{$IsiDiv['nmmapform']} :
								<span class='text-success'>{$tdform}</span>
							</div>
						</div>
					";	
					$i++;
				}
		}
		$active=$tahap<$z?"warning":"success";
		$ListMap.="
				<div class='accordion custom-accordionwithicon custom-accordion-border accordion-border-box accordion-{$active}' style='margin-bottom:3px;'>
					<div class='accordion-item '>
						<h2 class='accordion-header' id='Acc{$Isi['idmap']}1'><button class='accordion-button fw-semibold collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#BordAcc{$Isi['idmap']}1' aria-expanded='{$expanded}' aria-controls='BordAcc{$Isi['idmap']}1'>{$Isi['nmmap']}</button></h2>

						<div id='BordAcc{$Isi['idmap']}1' class='accordion-collapse collapse' aria-labelledby='Acc{$Isi['idmap']}1' data-bs-parent='#accordionBordered' style=''>
							<div class='accordion-body'>
								 <div class='tab-content text-muted'>
									
									<div class='tab-pane active' id='home-{$z}' role='tabpanel'>
										$div
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
		";
		$z++;
	}


	$Func->ambilData("select a.noregister, a.idprdh, a.kdregister,a.nmdokumen,a.kddokumen, a.nmjudul, a.kdmap, b.nourut ,a.tglpengajuan, a.tglvalid, a.created_date, a.uraian, c.nmbidang from t_prohuk as a left join t_map_dokumen as b on a.kdmap=b.kdmap and a.kddokumen=b.kddokumen left join ref_bidang as c on a.idbidang=c.idbidang where a.kdregister='{$kdregister}' order by a.created_date, a.idprdh desc");
	$divm="";
	switch($kdmap){
		case "00.00.000":
			$divm="<span class='badge rounded-pill bg-secondary'>Pengajuan</span>";
			$display="";
		break;
		case "99.99.999":
			
			if(!empty($tglvalid)){
				$divm="<span class='badge rounded-pill bg-success'>Sudah Disahkan</span>";
			}else{
				$divm="<span class='badge rounded-pill bg-warning'>Proses Pengesahan</span>";
			}
			
			$display="style='display:none;'";
		break;
		default:
			$imap=1;$num_map=0;
			$QryMap=_mysql_query("select nourut, nmmap, kdmap from t_map_dokumen where kddokumen='{$kddokumen}' order by nourut"); 
			while($IsiMap=_mysql_fetch_array($QryMap)){ 

				if(floatval($nourut)>=floatval($IsiMap['nourut'])){
					$StyleMap="btn-success";			
				}else{
					$StyleMap="btn btn-outline-success";
				}
				
				$divm.="
					<a href='javascript: void(0);' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='".$IsiMap['nmmap']."' ><button type='button' class='btn {$StyleMap}  btn-sm' style='margin:1px;'>".floatval($IsiMap['nourut'])."</button></a>

				
				";
				
			}
			$divm="
				<divm class='avatar-group' style='width:100%'>
					<center>$divm</center>
				</divm>
			";
			$display="style='display:none;'";
	}

	$Main->BottomIsi="
	<div class='main-content'>
		<div class='page-content'>
			<div class='container-fluid'>				
				<div class='row'>
					<div class='col-lg-12'>
						<div class='card pricing-box ribbon-box ribbon-fill text-center'>
							<div class='ribbon ribbon-primary'>New</div>
							<div class='row g-0'>
								<div class='col-lg-6'>
									<div class='card-body h-100'>
										<div>
											<h5 class='mb-1'>&nbsp;{$noregister}</h5>
											<h5 class='mb-1'>{$nmjudul}</h5>
											<p class='text-muted' align='justify'>{$uraian}</p>
										</div>


										<div class='text-center plan-btn mt-2'>
											<center>$divm</center>
										</div>
									</div>
								</div>
								<!--end col-->
								<div class='col-lg-6'>
									<div class='card-body border-start mt-4 mt-lg-0'>
										<div class='card-header bg-light'>
											<h5 class='fs-15 mb-0'>{$nmdokumen}</h5>
										</div>
										<div class='card-body pb-0'>
											<ul class='list-unstyled vstack gap-3 mb-0'>
												<li> <span class='text-success fw-semibold'>{$kdregister}</span></li>
												<li>Tgl.Pengajuan: <span class='text-success fw-semibold'>".$Func->TglAll($tglpengajuan)."</span></li>
												<li>Waktu: <span class='text-success fw-semibold'>".$Func->TglInd($created_date)." ".substr(substr($created_date,-12),0,6)."</span>
												</li>
												
											</ul>
										</div>
									</div>
								</div>
								<div class='card-footer'>
									
									<div class='hstack gap-2 justify-content-end'>
										<div class='col-lg-12'>
											<span class='text-success fw-semibold'>{$nmbidang}</span>
										</div>
										

										
									</div>
								</div>
								<!--end col-->
							</div>
							<!--end row-->
						</div>
					</div>
					<!--end row-->
				</div>
				<div class='row'>
					<div class='col-lg-12'>
						<div class='card'>
							<div class='card-header align-items-center d-flex'>
								<h4 class='card-title mb-0 flex-grow-1'>Rincian Proses Dokumen</h4>
								<div class='flex-shrink-0'>
									
								</div>
							</div>
							<!-- end card header -->
							<div class='card-body'>
								
								<div class='live-preview'>
									
										{$ListMap}
									
								</div>
							</div>
							<!-- end card-body --></div>
						<!-- end card --></div>
					</div>
				</div>
			</div>
	</div>
	";	 
//	$Main->Isi=$Form; 	
?>