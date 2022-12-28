<?php

	$Func->ambilData("SELECT a.kdmap, a.kddokumen, a.nourut, a.nmmap, a.tipe, b.nmdokumen,  c.nmgroupakses from t_map_dokumen as a inner join ref_dokumen as b on a.kddokumen=b.kddokumen inner join __t_group_akses as c on a.idgroupakses=c.idgroupakses where a.idmap='".$idPop."' ORDER BY b.kddokumen, a.kdmap");
	
	$Qry="select a.idmapform, a.nmmapform, a.kdmapform, a.level, b.nmform, a.arrdata, a.nmurl, a.catatan, a.aktif, a.mandatory   from t_map_form as a
	inner join ref_form as b on a.idform=b.idform where a.kdmap='{$kdmap}'
	order by a.tr, a.kdmapform";
	$Qry=_mysql_query($Qry); 
	while($Isi=_mysql_fetch_array($Qry)){ 
		$wrn=$Isi['mandatory']=='Y'?"color:red;":"";

		switch($Isi['level']){
			case "H":
				$css="style='font-weight:bold;border-bottom:1px dashed #D0D5DB;padding:5px;width:100%;{$wrn}'";
				
			break;
			case "D":
				$css="style='padding-left:15px;{$wrn}'";
				
			break;
			
			default:
				$css="";
		}

		switch($Isi['nmform']){
			case "textarea":
				$tdform=$Func->cKeditor("text_value[$i-1]",@$Isi['text_value']);
			break;
			case "text":
				$tdform=$Func->txtField("text_value[$i-1]",@$Isi['text_value'],'','100','text',"placeholder='{$Isi['catatan']}'");
			break;
			case "file":
				$tdform=$Func->txtField("text_value[$i-1]",@$Isi['text_value'],'','100','file',"placeholder='{$Isi['catatan']}'");
			break;
			case "numeric":
				$tdform=$Func->txtNumber("num_value[$i-1]",floatval(@$Isi['num_value']),'','100','text',"placeholder='{$Isi['catatan']}'");
			break;
			case "cmb":
				$arrdata=$Isi['arrdata'];
				$arrdata=str_replace('"','',$arrdata);
				$arrdata=str_replace("'","",$arrdata);
				$arrdata=str_replace("&#039;","",$arrdata);
				$arrdata=str_replace("&quot;","",$arrdata);
				$arrdata=explode(",",$arrdata);
				$tdform=$Func->cmbUmum("text_value[$i-1]",@$Isi['text_value'],$arrdata,"style='width:100%;background:".$wh.";border-top:0px;border-left:0px;border-right:0px;'");
			break;
			case "date":
				$tdform=$Func->txtField("date_value[$i-1]",@$Isi['date_value'],'','100','date');
			break;
			case "href":
				$tdform="<a href='".@$Isi['nmurl']."' target='_blank'>Unduh</a>";
			break;
			case "href form":
				$tdform="<a href='#' >Unduh</a>";
			break;
			default:
				$tdform="";
			
		}
		
		$onclick_edit="onclick=\"javascript:showPopUp(".$PopUpWidth.");ambilData('#faceboxisi', '{$Url->BaseMain}/{$Pg}/{$Pr}/form/Lihat/{$Isi['idmapform']}')\"";
		$onclick_hapus="onclick=\"Cek=confirm('Apakah yakin akan menghapus data?');if(!Cek){return false;}else{javascript:showPopUp(".$PopUpWidth.");ambilData('#faceboxisi', '{$Url->BaseMain}/{$Pg}/{$Pr}/form/Hapus/{$Isi['idmapform']}')}\"";
		
		$ListMode.=" 
			<div class='row g-3 ' style='margin-bottom:10px;'>
				<div class='col-xxl-12'>
					<div>
						 
						<label for='valueInput' class='form-label' {$css} {$onclick_edit}>{$Isi['nmmapform']}</label>
						<div style='position:absolute;left:-15px;top:0px;' {$onclick_hapus}>
							<a href='javascript:void(0);' class='link-danger fs-15'><i class='ri-delete-bin-line'></i></a>
						</div>

						<div style='position:absolute;right:10px;top:0px;'  >
							<span class='contact-born text-muted mb-0'>Kode : {$Isi['kdmapform']} | Level  : {$Isi['level']} | Aktif  : {$Isi['aktif']}</span>
						</div>
						{$tdform}
					</div>
				</div>
			</div>
		";$i++; 
	}

	$li="";
	$Qry="SELECT * from t_map_dokumen as a inner join ref_dokumen as b on a.kddokumen=b.kddokumen inner join __t_group_akses as c on a.idgroupakses=c.idgroupakses where a.kddokumen='{$kddokumen}' ORDER BY b.kddokumen, a.kdmap "; 
	$Qry=_mysql_query($Qry); 
	while($Isi=_mysql_fetch_array($Qry)){ 
		$style="";$style2="";$text_muted="text-muted";
		if($Isi['kdmap']==$kdmap){
			$style="style='background-color:#ff9900;color:white;'";
			$style2="style='color:white;'";
			$text_muted="";
		}
		$click="onclick=\"parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}/design_form/cek/{$Isi['idmap']}';\"";
		$li.="
			<li class='list-group-item' data-id='{$Isi['nourut']}' {$style} {$click}>
				<div class='d-flex align-items-start'>
					<div class='flex-grow-1 overflow-hidden'>
						<h5 class='contact-name fs-13 mb-1'><a href='#' class='link text-dark' {$style2}>{$Isi['kdmap']}</a></h5>
						<p class='contact-born ".$text_muted." mb-0' >{$Isi['nmmap']} </p>
					</div>

					<div class='flex-shrink-0 ms-2'>
						<div class='fs-11 ".$text_muted."'>{$Isi['nmgroupakses']}</div>
					</div>
				</div>
			</li>
		";
	}
	$Main->Isi="
	
		<style>
			.page-content{
				background-color:#F3F6F9;
			}
			.fw-medium{
				font-weight:bold;
			}
			.row g-3{
				margin-bottom:10px;
			}
		</style>
		<div class='vertical-overlay'></div>
		<div class='main-content'>

            <div class='page-content'>
                <div class='container-fluid'>

                    <!-- start page title -->
                    <div class='row'>
                        <div class='col-12'>
                            <div class='page-title-box d-sm-flex align-items-center justify-content-between'>
                                <h4 class='mb-sm-0'>Design Form</h4>

                                <div class='page-title-right'>
                                    <ol class='breadcrumb m-0'>
                                        <li class='breadcrumb-item'><a href='#'>Master</a></li>
                                        <li class='breadcrumb-item active'>Maping Dokumen</li>
                                        <li class='breadcrumb-item active'>Design Form</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class='row'>
                        <div class='col-xxl-3'>
                            <div class='card'>
                                <div class='card-body p-4'>
                                    <div>
                                        <h6 class='text-muted text-uppercase fw-semibold mb-4'>Dokumen Informasi</h6>
                                        <div class='table-responsive'>
                                            <table class='table mb-0 table-borderless'>
                                                <tbody>
													<tr>
                                                        <th><span class='fw-medium'>Dokumen</span></th>
                                                        <td class='contact-born text-muted mb-0'>{$nmdokumen}</td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class='fw-medium'>Aktor</span></th>
                                                        <td class='contact-born text-muted mb-0'>{$nmgroupakses}</td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class='fw-medium'>Kode</span></th>
                                                        <td class='contact-born text-muted mb-0'>{$kdmap}</td>
                                                    </tr>
													<tr>
                                                        <th ><span class='fw-medium' colspan=2>Deskripsi</span></th>
                                                    </tr>
                                                    <tr>
                                                        <td colspan=2 class='contact-born text-muted mb-0'>{$nourut} {$nmmap}</td>
                                                    </tr>
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-body-->
                                <div class='card-body border-top border-top-dashed p-4'>
									 <h6 class='text-muted text-uppercase fw-semibold mb-4'>Deskripsi Dokumen</h6>
									<div data-simplebar style='height: 242px;' class='mx-n3'>
										<ul class='list list-group list-group-flush mb-0'>
											{$li}											
										</ul>
										<!-- end ul list -->
									</div>
								</div>
                                <div class='card-body border-top border-top-dashed p-4'>
                                </div>    
                                <!--end card-body-->
                                
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->

                        <div class='col-xxl-9'>
                            <div class='card'>
                                <div class='card-header border-0 align-items-center d-flex'>
                                    <h4 class='card-title mb-0 flex-grow-1'>Daftar Form</h4>
                                     <div>
										<button type='button' class='btn btn-success add-btn w-100' data-bs-toggle='modal' id='create-btn' data-bs-target='#showModal' onclick=\"javascript:showPopUp(".$PopUpWidth.");ambilData('#faceboxisi', '{$Url->BaseMain}/{$Pg}/{$Pr}/form/Baru/0/{$kdmap}')\"><i class='ri-add-line align-bottom me-1'></i> Tambah Form</button>
                                    </div>
                                </div><!-- end card header -->

								<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/design_form/cek/{$idPop}' enctype='multipart/form-data' style='margin:10px;' class='card-body border-top border-top-dashed p-4'> 
									<div class='card-header p-0 border-0 bg-soft-light '>
										
										{$ListMode}

										".$Func->txtField('Pr',$Pr,'','','hidden')." 
										".$Func->txtField('Mode',$Mode,'','','hidden')." 
										".$Func->txtField('halaman',$halaman,'','','hidden')." 
										".$Func->txtField('Action',$Action,'','','hidden')." 
										
									   
									</div><!-- end card header -->
								</form>
                              
                            </div><!-- end card -->

                          

                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

          
        </div>
	";
	if($Aksi!='Hapus'){
		$Main->Isi = $Func->Kotak($Main->MenuHeader,$Main->Isi,'100%');
	}else{
		$Main->Isi = $Func->Kotak($Main->MenuHeader,'<center><b>Melakukan Proses Hapus</b></center>','100%');
	}
?>