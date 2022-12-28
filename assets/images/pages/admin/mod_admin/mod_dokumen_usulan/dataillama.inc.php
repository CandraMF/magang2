<?php
	$tahap=!empty($tahap)?$tahap:"0";
	$kdregister=!empty($kdregister)?$kdregister:"0";
	$JmlTahapan=!empty($JmlTahapan)?$JmlTahapan:"0";

	switch($Action){
		case "next":
			$QTmp="select count(*) as jml from t_map_dokumen where kddokumen='{$pkddokumen}'";
		
			$Qry = _mysql_query( $QTmp );$Hasil=_mysql_fetch_array($Qry);	
			$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
			$ntahap=$tahap;
			$tahap=$tahap>=$jCount?$jCount-1:$tahap;
			
			$Func->ambilData("SELECT kdmap FROM t_map_dokumen WHERE kddokumen='{$pkddokumen}' LIMIT 1 OFFSET ".$tahap);
			$nourut_id=floatval($tahap);
			$kdmap=!empty($kdmap)?$kdmap:"000";
			_mysql_query("UPDATE t_prohuk set ntahap='{$ntahap}', tahap='".$nourut_id."', kdmap='".$kdmap."' where kdregister='".$kdregister."' and kddokumen='".$pkddokumen."'");
			$Func->ambilData("SELECT idmap, kddokumen FROM t_map_dokumen where kdmap='{$kdmap}'");
			$pkddokumen=$kddokumen;
		break;

		case "prev":

			$tahap=floatval($tahap);
			$ntahap=$tahap;
			$tahap=$tahap<0?0:$tahap;
			$Func->ambilData("SELECT kdmap FROM t_map_dokumen WHERE kddokumen='{$pkddokumen}' LIMIT 1 OFFSET ".$tahap);
			$nourut_id=floatval($tahap);
			$kdmap=!empty($kdmap)?$kdmap:"000";
			
			_mysql_query("UPDATE t_prohuk set ntahap='{$ntahap}', tahap='".$nourut_id."', kdmap='".$kdmap."' where kdregister='".$kdregister."' and kddokumen='".$pkddokumen."'");
			$Func->ambilData("SELECT idmap, kddokumen FROM t_map_dokumen where kdmap='{$kdmap}'");
			$pkddokumen=$kddokumen;
		break;
		case "ntahap":

			_mysql_query("UPDATE t_prohuk set ntahap='{$ntahap}' where kdregister='".$kdregister."' and kddokumen='".$pkddokumen."'");
			
		break;
	}


	$ntahap=!empty($ntahap)?$ntahap:$tahap;

	
	$idmap=!empty($idmap)?$idmap:"";
	$kddokumen=!empty($kddokumen)?$kddokumen:"";
	$pkddokumen=!empty($pkddokumen)?$pkddokumen:$kddokumen;

	$QTmp="select count(*) as jml from t_prohuk where noregister='{$idPop}'";
	$Qry = _mysql_query( $QTmp );	
	$Hasil=_mysql_fetch_array($Qry);	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
	$Func->ambilData("SELECT a.nmdokumen, a.kdkatdokumen FROM ref_dokumen as a where a.kddokumen='{$kddokumen}'");
	if ($jCount > 0){

		$Qry=_mysql_query("SELECT idmap, kdmap, idgroupakses, nourut, nmmap FROM t_map_dokumen where kddokumen='{$pkddokumen}' order by nourut asc"); 
		$JmlTahapan=_mysql_num_rows($Qry);
		$ListMap="";$i=0;
		while($Isi=_mysql_fetch_array($Qry)){ 
			if($tahap<$i){
				$active="disabled";
			}else{
				$active="";
			}
			if($ntahap!='-1'){
				if($ntahap==$JmlTahapan){
					$active="";
				}else{
					$active=$idmap==$Isi['idmap']?"active":$active;
				}
				
			}else{
				
				$active="disabled";
			}
			
			$style="";
			if($tahap==$i){
				if($idmap!=$Isi['idmap']){
					if($ntahap!=$JmlTahapan){
						$style="style='background-color:#13C56B;color:white;'";
					}
					
					
				}else{
					$idmap=$Isi['idmap'];
				}
			}

			$ListMap.="<button type='button' class='list-group-item list-group-item-action {$active}' {$style}  onclick=\"Fm.idmap.value='{$Isi['idmap']}';Fm.Sb.value='dok_proses';Fm.Action.value='ntahap';Fm.ntahap.value='".$tahap."';Fm.submit();\"><i class='ri-folders-line align-middle me-2'></i>{$Isi['nmmap']}</button>";
			$i++;
		}

		$ListMap.="
			<button type='button' class='list-group-item list-group-item-action {$active_2}' onclick=\"Fm.idmap.value='-2';Fm.Sb.value='dok_awal';Fm.Action.value='BknSimpan';Fm.submit();\"><i class=' ri-flag-line align-middle me-2'></i>Selesai</button>
		";

			}else{
		$ListMap="";
	}
	$Main->Isi = "";
	
	$Sb=$ntahap=='-1'?"dok_awal":$Sb;
	$idmap=$ntahap=='-1'?'-1':$idmap;
	

	
	
	if(!empty($kddokumen)&&($JmlTahapan>0)){
			$Sb=$ntahap==$JmlTahapan?"dok_finish":$Sb;
			$idmap=$ntahap==$JmlTahapan?'-2':$idmap;
		}



	$active_1=$idmap=='-1'?"active":"";
	
	$active_2=$idmap=='-2'?"active":"disabled";

	switch ($Sb){		
		case "dok_finish":
			include "{$Dir->ModAdmin}{$Pr}/dok_finish.inc.php";
		break;
		case "dok_proses":
			include "{$Dir->ModAdmin}{$Pr}/dok_proses.inc.php";
		break;
		default:
			include "{$Dir->ModAdmin}{$Pr}/dok_awal.inc.php";
			$Sb="dok_awal";
	}

	
	$Main->BottomIsi="
		<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$Mode}/{$Sb}' enctype='multipart/form-data'> 
		".$Func->txtField('Pr',$Pr,'','','hidden')." 
		".$Func->txtField('Sb',$Sb,'','','hidden')." 
		".$Func->txtField('tahap',$tahap,'','','hidden')."
		".$Func->txtField('ntahap',$ntahap,'','','hidden')."
		".$Func->txtField('Mode',$Mode,'','','hidden')." 
		".$Func->txtField('idmap',$idmap,'','','hidden')." 
		".$Func->txtField('halaman',$halaman,'','','hidden')." 
		".$Func->txtField('Action',$Action,'','','hidden')." 
		".$Func->txtField('kdregister',$kdregister,'','','hidden')." 
		".$Func->txtField('pkddokumen',$pkddokumen,'','','hidden')." 
		<div class='main-content' >

            <div class='page-content'>
                <div class='container-fluid'>

                    <!-- start page title -->
                    <div class='row'>
                        <div class='col-12'>
                            <div class='page-title-box d-sm-flex align-items-center justify-content-between'>
                                <h4 class='mb-sm-0'>Form Pengajuan Dokumen</h4>
							
								
                                <div class='page-title-right'>
                                    <ol class='breadcrumb m-0'>
                                        <li class='breadcrumb-item'><a href='javascript: void(0);'>Dokumen</a></li>
                                        <li class='breadcrumb-item active'>{$Main->MenuHeader}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class='row'>
						<div class='col-lg-4'>
                           
                            <div class='card'>
                                <div class='card-header'>
                                    <h5 class='card-title mb-0'>Informasi Tahapan Dokumen</h5>
									
                                </div>
                                <div class='card-body'>
                                    <div class='live-preview'>
                                        <div class='list-group'>
									
                                            <button type='button' class='list-group-item list-group-item-action {$active_1}' aria-current='true' onclick=\"Fm.idmap.value='-1';Fm.Sb.value='dok_awal';Fm.Action.value='BknSimpan';Fm.submit();\"><i class=' ri-function-line align-middle me-2'></i>Dokumen Pengajuan Awal</button>
                                            {$ListMap}
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->

                           
                        </div>
                        <!-- end col -->

                        <div class='col-lg-8'>
							{$ContentBottomIsi}
                        </div>
                        <!-- end col -->
                        
                    </div>
                    <!-- end row -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

        </div>
        <!-- end main content-->
		</form>
		
	";
	if($Aksi!='Hapus'){
		$Main->Isi = $Func->Kotak($Main->MenuHeader,$Main->Isi,'100%');
	}else{
		$Main->Isi = $Func->Kotak($Main->MenuHeader,'<center><b>Melakukan Proses Hapus</b></center>','100%');
	}
?>