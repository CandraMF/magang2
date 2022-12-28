<?php
	$ListMode="";$i=1; 
	$PopUpWidth="'750','200'"; 
	///// PARAMETER AND QUERY GRID 
	$vkddokumen=!empty($vkddokumen)?$vkddokumen:"0";
	$Qry="SELECT * from t_map_dokumen as a inner join ref_dokumen as b on a.kddokumen=b.kddokumen inner join __t_group_akses as c on a.idgroupakses=c.idgroupakses where a.kddokumen='".$vkddokumen."' $wh ORDER BY b.kddokumen, a.kdmap "; 
	$ParamDet="{$Pg}/{$Pr}/{$ckata}/{$Action}"; 
	$Param="{$Url->BaseMain}/".$ParamDet; 
	
	$Qry=_mysql_query($Qry); 
	
	///// LIST GRID 
	
	while($Isi=_mysql_fetch_array($Qry)){ 
		$wr = $i % 2 == 0 ? "style='background:$Main->BgRow'" : "style='background:$Main->BgRow2'"; 
		$wh = $i % 2 == 0 ? "$Main->BgRow" : "$Main->BgRow2"; 
		$ListMode.=" 
			<tr $wr  onmouseover=\"TG(this,'#FFCC33')\" onmouseout=\"TG(this,'$wh')\"> 
				<td align=center>$i.</td> 
 				<td>{$Isi['kdmap']}</td>
 				<td>{$Isi['nourut']} {$Isi['nmmap']}</td>
 				<td>{$Isi['nmgroupakses']}</td>
 				<td>
					<a href=\"{$Url->BaseMain}/{$Pg}/{$Pr}/design_form/cek/{$Isi['idmap']}\" target='_blank'><button type='button' class='btn btn-secondary' data-bs-toggle='offcanvas' href='#offcanvasExample'><i class='ri-share-forward-2-line me-1'></i> </button></a>


				</td>
 				
 		"; 
		if($Excel!='yes'){ 	
			$onclick_edit="onclick=\"javascript:showPopUp(".$PopUpWidth.");ambilData('#faceboxisi', '{$Url->BaseMain}/{$Pg}/{$Pr}/detail/Lihat/{$Isi['idmap']}')\"";
			$onclick_hapus="onclick=\"Cek=confirm('Apakah yakin akan menghapus data?');if(!Cek){return false;}else{javascript:showPopUp(".$PopUpWidth.");ambilData('#faceboxisi', '{$Url->BaseMain}/{$Pg}/{$Pr}/detail/Hapus/{$Isi['idmap']}')}\"";
			$ListMode.=" 
				<td>
					<ul class='list-inline hstack gap-2 mb-0'>
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
			</tr> 
		";$i++; 
	} 
	//////////// TABLE LIST 
	$List="<table class='table table-nowrap align-middle' id='orderTable'>
			<thead class='text-muted table-light'>
				<tr class='text-uppercase'>
					<th class='sort' width='5%'>No.</th>
					<th class='sort'>Kode</th>
					<th class='sort'>Deskripsi</th>
					<th class='sort'>Aktor</th>
					<th class='sort'>Design Form</th>
					
	"; 

	if($Excel!='yes'){ $List.="<th class='sort' data-sort='action' width='10%'>Action</th>"; } 

	$List.=" </tr></thead><tbody class='list form-check-all'>{$ListMode}</tbody></table> "; 
	 
	/////////// FORM 
	$Form="
		
		<div class='card-body border border-dashed border-end-0 border-start-0'>
			<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}' enctype='multipart/form-data'> 
			".$Func->txtField('Pr',$Pr,'','','hidden')." 
			".$Func->txtField('Mode',$Mode,'','','hidden')." 
			".$Func->txtField('halaman',$halaman,'','','hidden')." 
			".$Func->txtField('Action',$Action,'','','hidden')." 
				<div class='row g-3'>
					<div class='col-xxl-8 col-sm-6'>
						<div class='search-box'>
							".$Func->cmbQuery('vkddokumen',@$vkddokumen,"SELECT kddokumen, concat(kddokumen,' ',nmdokumen) as nmdokumen FROM ref_dokumen order by kddokumen","style='padding-left:30px;'")."
							<i class='ri-search-line search-icon' ></i>
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
							<button type='button' class='btn btn-success add-btn w-100' data-bs-toggle='modal' id='create-btn' data-bs-target='#showModal' onclick=\"javascript:showPopUp(".$PopUpWidth.");ambilData('#faceboxisi', '{$Url->BaseMain}/{$Pg}/{$Pr}/detail/Baru/0/{$vkddokumen}')\"><i class='ri-add-line align-bottom me-1'></i> Tambah Data</button>
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
			

				
			</div>
			
		</div>


	"; 
	 
	$Main->Isi=$Form; 	
?>