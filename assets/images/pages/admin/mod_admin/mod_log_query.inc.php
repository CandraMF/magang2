<?php
	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$wh=!empty($ckata)?" and username like '%$ckata%'":""; 
	$Qry="select * from __log_aktifitas where username !='' $wh order by waktu desc"; 
	$ParamDet="{$Pg}/{$Pr}/{$ckata}/{$Action}"; 
	$Param="{$Url->BaseMain}/".$ParamDet; 

	$Param="{$Url->BaseMain}/".$ParamDet; 
	 
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
	
	///// LIST GRID 
	
	while($Isi=_mysql_fetch_array($Qry)){ 
		$wr = $i % 2 == 0 ? "style='background:$Main->BgRow'" : "style='background:$Main->BgRow2'"; 
		$wh = $i % 2 == 0 ? "$Main->BgRow" : "$Main->BgRow2"; 
		$ListMode.=" 
			<tr $wr  onmouseover=\"TG(this,'#FFCC33')\" onmouseout=\"TG(this,'$wh')\"> 
				<td align=center>$i.</td> 
 				<td>{$Isi['username']}</td>
 				<td>{$Isi['query']}</td>
 				<td>{$Isi['action']}</td>
 				<td>{$Isi['ipaddress']}</td>
 				<td>{$Isi['waktu']}</td>
			</tr> 
		";$i++; 
	} 
	//////////// TABLE LIST 
	$List="<table class='table table-nowrap align-middle' id='orderTable'>
			<thead class='text-muted table-light'>
				<tr class='text-uppercase'>
					<th class='sort' width='5%'>No.</th>
					<th class='sort'>Username</th>
					<th class='sort'>Query</th>
					<th class='sort'>Aksi</th>
					<th class='sort'>IP Address</th>
					<th class='sort'>Waktu</th>
				</tr>
			</thead>
			<tbody class='list form-check-all'>{$ListMode}</tbody></table> "; 
	 
	/////////// FORM 
	$Form="
		
		<div class='card-body border border-dashed border-end-0 border-start-0'>
			<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$LinkPageNavi}' enctype='multipart/form-data'> 
			".$Func->txtField('Pr',$Pr,'','','hidden')." 
			".$Func->txtField('Mode',$Mode,'','','hidden')." 
			".$Func->txtField('halaman',$halaman,'','','hidden')." 
			".$Func->txtField('Action',$Action,'','','hidden')." 
				<div class='row g-3'>
					<div class='col-xxl-10 col-sm-6'>
						<div class='search-box'>
							<input type='text' class='form-control search' placeholder='Pencarian Username' name='ckata'>
							<i class='ri-search-line search-icon'></i>
						</div>
					</div>
					
					<!--end col-->
					<div class='col-xxl-2 col-sm-2'>
						
						<div >
							<button type='button' class='btn btn-primary w-100' onclick=\"Fm.Action.value='BknSimpan';Fm.submit();\"> <i class='ri-equalizer-fill me-1 align-bottom' ></i>
								Cari
							</button>
						</div>
					</div>
				
				</div>
				<!--end row-->
			</form>
		</div>
		<div class='card-body pt-0'>
			<div>
				<br>
				<div class='table-responsive table-card mb-1'>
					{$List}
				</div>
			

				<div class='d-flex justify-content-end'>
					<div class='pagination-wrap hstack gap-2'>
						$link
					</div>
				</div>
			</div>
			
		</div>


	"; 
	 
	$Main->Isi=$Form; 	
?>