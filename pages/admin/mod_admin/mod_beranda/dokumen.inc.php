<?php
	$i=1;
	

	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$wh=!empty($ckata)?" where lower(nmjudul) like '%".strtolower($ckata)."%'":""; 
	$Qry="select kdregister, noregister, tglregister, nmjudul, nmdokumen , uraian  from t_prohuk_valid $wh order by tglregister, created_date desc"; 
	$ParamDet="{$Pg}/{$Pr}/{$ckata}/{$Action}"; 
	$Param="{$Url->BaseMain}/".$ParamDet; 

	$Param="{$Url->BaseMain}/".$ParamDet; 
	 
	///// PAGE HALAMAN GRID 
	$PageNavi = new pageNavi; 
	$batas='50';

	$substrpos=@substr(@$REQUEST_URI,@$strpos);
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
	
	///// LIST GRID 
	$DateToday=date('Y-m-d');
	while($Isi=_mysql_fetch_array($Qry)){ 
	
		$QTmp="select count(*) as jmlhit, sum(case tglhit when '".$DateToday."' then 1 else 0 end) as jmlhittoday from t_prohuk_hit where kdregister='{$Isi['kdregister']}'";
		$QryTmp = _mysql_query( $QTmp );	
		$Hasil=_mysql_fetch_array($QryTmp);	
		$jmlhit=!empty($Hasil['jmlhit'])?floatval($Hasil['jmlhit']):0;
		$jmlhittoday=!empty($Hasil['jmlhittoday'])?floatval($Hasil['jmlhittoday']):0;

		$listdok.="
			<div class='col-md-4' onclick=\"parent.location='{$Url->BaseMain}/login/dokumen_usulan/dokumen_detail/{$Isi['kdregister']}';\">
					<div class='card card-animate'>
						<div class='card-body'>
							<div class='d-flex justify-content-between'>
								<div>
									<p class='fw-medium mb-0 text-danger'><strong>{$Isi['noregister']}</strong></p>
									<p class='mt-4 ff-secondary fw-semibold text-muted'>
										<h5>{$Isi['nmjudul']}</h5>
										<code>{$Isi['uraian']}</code>
										<footer class='blockquote-footer mt-0'> <cite title='{$Isi['nmdokumen']}'>{$Isi['nmdokumen']}</cite></footer>
									</p>
									<p class='mb-0 text-muted'>
										<span class='badge bg-light text-success mb-0'>
											<i class='ri-timer-line align-middle'></i> {$Isi['tglregister']}
										   
										</span> 
										<i class='ri-eye-line align-middle'></i> Hari ini {$jmlhittoday} x dilihat - Total [{$jmlhit}]
									</p>
								</div>
								<div>
									<div class='avatar-sm flex-shrink-0'>
										 <span class='avatar-title bg-soft-warning rounded fs-3'>
											<i class='ri-file-text-line text-warning'></i>
										</span>
										
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div> <!-- end card-->
				</div> <!-- end col-->
		";$i++; 
	}



	
	$ListDok="
		<div class='card-header p-0' style='margin-bottom:3px;'>
			<div class='alert alert-warning alert-solid alert-label-icon border-0 rounded-0 m-0 d-flex align-items-center' role='alert'>
				<i class=' ri-newspaper-line label-icon'></i>
				<div class='flex-grow-1 text-truncate'>
					Dokumen Portal Hukum Terbaru
				</div>
				<div class='flex-shrink-0'>
					<a href='pages-pricing.html' class='text-muted '><b>".$Func->TglHari(date('Y-m-d'))."</b></a>
				</div>
			</div>
		</div>
		<div class='row'>
			{$listdok}
		</div>
		<div class='card-body pt-0'>
			<div>
				<div class='d-flex justify-content-end'>
					<div class='pagination-wrap hstack gap-2'>
						$link
					</div>
				</div>
			</div>
			
		</div>
	";
?>