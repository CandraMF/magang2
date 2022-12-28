<?php
	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$wh=!empty($ckata)?" and nmkamus like '%$ckata%'":""; 
	$Qry="SELECT * from t_kamus_hukum as a left join ref_bidang as b on a.idbidang=b.idbidang where a.idkamus > 0 $wh ORDER BY a.nmkamus "; 
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
	$StyleDisplay="";
	while($Isi=_mysql_fetch_array($Qry)){ 
		$wr = $i % 2 == 0 ? "style='background:$Main->BgRow'" : "style='background:$Main->BgRow2'"; 
		$wh = $i % 2 == 0 ? "$Main->BgRow" : "$Main->BgRow2"; 

		switch($Isi['stskamus']){
			case "Pengajuan":
				$StyleDisplay="";
			break;
			case "Ditolak":
				$StyleDisplay="style='display:none;'";
			break;
			case "Diterima":
				$StyleDisplay="style='display:none;'";
			break;
		}
		$ListModeFungsi="";
		if($Excel!='yes'){ 	
			$onclick_edit="onclick=\"javascript:parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}/detail/Lihat/{$Isi['kdregister']}';\"";
			$onclick_hapus="onclick=\"Cek=confirm('Apakah yakin akan menghapus data?');if(!Cek){return false;}else{parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}/detail/Hapus/{$Isi['kdregister']}';}\"";
			$ListModeFungsi=" 
				<td>
					<ul class='list-inline hstack gap-2 mb-0' {$StyleDisplay}>
						<li class='list-inline-item edit' data-bs-toggle='tooltip' data-bs-trigger='hover' data-bs-placement='top' title='Edit' >
							<a href='#showModal' data-bs-toggle='modal' class='text-primary d-inline-block edit-item-btn' {$onclick_edit}>
								<i class='ri-pencil-fill fs-16'></i>
							</a>
						</li>
						<li class='list-inline-item' data-bs-toggle='tooltip' data-bs-trigger='hover' data-bs-placement='top' title='Remove'>
							<a class='text-danger d-inline-block remove-item-btn' data-bs-toggle='modal' href='#deleteOrder' {$onclick_hapus}>
								<i class='ri-delete-bin-5-fill fs-16'></i>
							</a>
						</li>
					</ul>
				</td>"; 
		} 

		$ListMode.=" 
			<tr $wr  onmouseover=\"TG(this,'#FFCC33')\" onmouseout=\"TG(this,'$wh')\"> 
				<td align=center>$i.</td> 
				{$ListModeFungsi}
				<td>{$Isi['stskamus']}</td>
 				<td>{$Isi['aktif']}</td>
 				<td>{$Isi['nmbidang']}</td>
 				<td>{$Isi['kdregister']}</td>
 				<td>{$Isi['nmkamus']}</td>
 				<td>{$Isi['uraian']}</td>
			</tr> 
		";$i++; 
	} 
	//////////// TABLE LIST 
	$ListFungsi="";
	if($Excel!='yes'){ $ListFungsi="<th class='sort' data-sort='action' width='10%'>Action</th>"; } 
	$List="<table class='table table-nowrap align-middle' id='orderTable'>
			<thead class='text-muted table-light'>
				<tr class='text-uppercase'>
					
					<th class='sort' width='5%'>No.</th>
					{$ListFungsi}
					<th class='sort'>Status</th>
					<th class='sort'>Aktif</th>
					<th class='sort'>Bidang</th>
					<th class='sort'>No. Seri</th>
					<th class='sort'>Nama Usulan Kamus</th>
					<th class='sort'>Uraian</th>
					
	"; 

	

	$List.=" </tr></thead><tbody class='list form-check-all'>{$ListMode}</tbody></table> "; 
	 
	/////////// FORM 
	$Form="
		
		<div class='card-body border border-dashed border-end-0 border-start-0'>
			<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$LinkPageNavi}' enctype='multipart/form-data'> 
			".$Func->txtField('Pr',$Pr,'','','hidden')." 
			".$Func->txtField('Mode',$Mode,'','','hidden')." 
			".$Func->txtField('halaman',$halaman,'','','hidden')." 
			".$Func->txtField('Action',$Action,'','','hidden')." 
				<div class='row g-3'>
					<div class='col-xxl-8 col-sm-6'>
						<div class='search-box'>
							<input type='text' class='form-control search' placeholder='Pencarian Data' name='ckata'>
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
				
					<!--end col-->
					<div class='col-xxl-2 col-sm-2'>
						<div>
							<button type='button' class='btn btn-success add-btn w-100' data-bs-toggle='modal' id='create-btn' data-bs-target='#showModal' onclick=\"javascript:parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}/detail';\"><i class='ri-add-line align-bottom me-1'></i> Tambah Data</button>
						</div>
					</div>
					<!--end col-->
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