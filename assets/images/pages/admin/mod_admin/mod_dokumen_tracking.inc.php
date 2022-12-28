<?php
	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	$ParamDet="{$Pg}/{$Pr}/{$ckata}/{$Action}"; 
	$Param="{$Url->BaseMain}/".$ParamDet; 
	$LinkPageNavi="";

	$ckdmap=!empty($ckdmap)?$ckdmap:"";
	$ckata=!empty($ckata)?$ckata:"";
	$ctglpengajuan=!empty($ctglpengajuan)?$ctglpengajuan:"";
	
	///// LIST GRID 
	
	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$wh=""; 
	$wh.=!empty($ckata)?" and (a.kdregister like '%$ckata%' or a.nmjudul like '%$ckata%'  or a.uraian like '%$ckata%') ":""; 
	$wh.=!empty($ctglpengajuan)?" and a.tglpengajuan='".$ctglpengajuan."' ":""; 
	$wh.=!empty($ckdmap)?" and a.kdmap='".$ckdmap."' ":""; 
	$Qry="select a.noregister, a.idprdh, a.kdregister,a.nmdokumen,a.kddokumen, a.nmjudul, a.kdmap, b.nourut ,a.tglpengajuan, a.tglvalid, a.created_date, a.uraian, c.nmbidang from t_prohuk as a left join t_map_dokumen as b on a.kdmap=b.kdmap and a.kddokumen=b.kddokumen left join ref_bidang as c on a.idbidang=c.idbidang where a.kdregister='{$ckata}' order by a.created_date, a.idprdh desc"; 
	$ParamDet="{$Pg}/{$Pr}/{$ckata}/{$Action}"; 
	$Param="{$Url->BaseMain}/".$ParamDet; 

//a.idprdh>0 {$wh}
	 
	///// PAGE HALAMAN GRID 
	$PageNavi = new pageNavi; 
	$batas='50';

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
	 
	
	$Qry=_mysql_query($Qry.$limit); 
	while($Isi=_mysql_fetch_array($Qry)){ 

		$div="";
		switch($Isi['kdmap']){
			case "00.00.000":
				$div="<span class='badge rounded-pill bg-secondary'>Pengajuan</span>";
				$display="";
			break;
			case "99.99.999":
				
				if(!empty($Isi['tglvalid'])){
					$div="<span class='badge rounded-pill bg-success'>Sudah Disahkan</span>";
				}else{
					$div="<span class='badge rounded-pill bg-warning'>Proses Pengesahan</span>";
				}
				
				$display="style='display:none;'";
			break;
			default:
				$imap=1;$num_map=0;
				$QryMap=_mysql_query("select nourut, nmmap, kdmap from t_map_dokumen where kddokumen='{$Isi['kddokumen']}' order by nourut"); 
				while($IsiMap=_mysql_fetch_array($QryMap)){ 

					if(floatval($Isi['nourut'])>=floatval($IsiMap['nourut'])){
						$StyleMap="btn-success";			
					}else{
						$StyleMap="btn btn-outline-success";
					}
					
					$div.="
						<a href='javascript: void(0);' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='".$IsiMap['nmmap']."' ><button type='button' class='btn {$StyleMap}  btn-sm' style='margin:1px;'>".floatval($IsiMap['nourut'])."</button></a>

					
					";
					
				}
				$div="
					<div class='avatar-group' style='width:100%'>
						<center>$div</center>
					</div>
				";
				$display="style='display:none;'";
		}

	
		$ListMode.=" 
			<div class='col-lg-12'>
				<div class='card pricing-box ribbon-box ribbon-fill text-center'>
					<div class='ribbon ribbon-primary'>New</div>
					<div class='row g-0'>
						<div class='col-lg-6'>
							<div class='card-body h-100'>
								<div>
									<h5 class='mb-1'>&nbsp;{$Isi['noregister']}</h5>
									<h5 class='mb-1'>{$Isi['nmjudul']}</h5>
									<p class='text-muted' align='justify'>".substr($Isi['uraian'],0,400)."</p>
								</div>


								<div class='text-center plan-btn mt-2'>
									$div
								</div>
							</div>
						</div>
						<!--end col-->
						<div class='col-lg-6'>
							<div class='card-body border-start mt-4 mt-lg-0'>
								<div class='card-header bg-light'>
									<h5 class='fs-15 mb-0'>{$Isi['nmdokumen']}</h5>
								</div>
								<div class='card-body pb-0'>
									<ul class='list-unstyled vstack gap-3 mb-0'>
										<li> <span class='text-success fw-semibold'>{$Isi['kdregister']}</span></li>
										<li>Tgl.Pengajuan: <span class='text-success fw-semibold'>".$Func->TglAll($Isi['tglpengajuan'])."</span></li>
										<li>Waktu: <span class='text-success fw-semibold'>".$Func->TglInd($Isi['created_date'])." ".substr(substr($Isi['created_date'],-12),0,6)."</span>
										</li>
										
									</ul>
								</div>
							</div>
						</div>
						<div class='card-footer'>
							
							<div class='hstack gap-2 justify-content-end'>
								<div class='col-lg-10'>
									<span class='text-success fw-semibold'>{$Isi['nmbidang']}</span>
								</div>
								<div class='col-lg-2'>
									<a href=\"{$Url->BaseMain}/{$Pg}/{$Pr}/detail/lihat/{$Isi['kdregister']}\" class='btn btn-primary btn-sm'>Selengkapnya</a>
								</div>

								
							</div>
						</div>
						<!--end col-->
					</div>
					<!--end row-->
				</div>
			</div>
			<!--end row-->

		";$i++; 
	} 
	//////////// TABLE LIST 
	$List="{$ListMode}"; 
	 
	/////////// FORM 
	$Form="
		<center>
			<br><h4 class='card-title mb-0 flex-grow-1'>Lacak Dokumen Pengajuan Anda</h4><br>
<span class='text-muted'>Untuk mengetahui dokumen rancangan peraturan yang anda ajukan, dapat dilihat dengan memasukkan nomor seri yang telah anda terima</span></center>
		<div class='card-body border border-dashed border-end-0 border-start-0'>
			<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$LinkPageNavi}' enctype='multipart/form-data'> 
			".$Func->txtField('Pr',$Pr,'','','hidden')." 
			".$Func->txtField('Mode',$Mode,'','','hidden')." 
			".$Func->txtField('halaman',$halaman,'','','hidden')." 
			".$Func->txtField('Action',$Action,'','','hidden')." 
				<div class='row g-3'>
					<div class='col-xxl-12'>
						<div class='search-box'>
							 <form>
								<div class='row g-3'>
									<div class='col-xxl-10 col-sm-12'>
										<div class='search-box'>
											<input type='text' name='ckata' id='ckata' class='form-control search' placeholder='Cari No.Seri' value='".$ckata."'>
											<i class='ri-search-line search-icon'></i>
										</div>
									</div>
									
								 
									<!--end col-->
									<div class='col-xxl-2 col-sm-4'>
										<div>
											<button type='button' class='btn btn-primary w-100' onclick=\"Fm.Action.value='BknSimpan';Fm.submit();\"> <i class='ri-equalizer-fill me-1 align-bottom'></i>
												Lacak
											</button>
										</div>
									</div>
									<!--end col-->
								</div>
								<!--end row-->
							</form>
						</div>
					</div>
					
					

					<!--end col-->
				</div>
				
				<!--end row-->
			</form>
			
		</div>
		<br>
		<div class='row ' >
			<div class='col-12'>
			$ListMode
			</div>
		</div>
	"; 
	///				<div class='card pricing-box text-center'>
//				<div class='card pricing-box ribbon-box ribbon-fill text-center'>
	$Main->BottomIsi="
		
	"; 
	$Main->Isi=$Form; 	
	/*
		<!--end col-->
									<div class='col-xxl-2 col-sm-6'>
										<div>
											<input type='date' name='ctglpengajuan'  value='".$ctglpengajuan."' id='ctglpengajuan' class='form-control' data-provider='flatpickr' data-date-format='d M, Y' data-range-date='true' id='demo-datepicker' placeholder='Select date'>
										</div>
									</div>
									<!--end col-->
									<div class='col-xxl-2 col-sm-4'>
										<div>
											".$Func->cmbQuery('ckdmap',$ckdmap,"select kddokumen, nmdokumen from ref_dokumen order by kddokumen")."
											
										</div>
									</div>
									<!--end col-->
	*/
?>