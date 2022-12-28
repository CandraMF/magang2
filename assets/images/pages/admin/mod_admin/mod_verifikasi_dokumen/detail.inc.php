<?php
	
	$tahap=!empty($tahap)?$tahap:"0";
	$kdregister=!empty($kdregister)?$kdregister:"0";

	$SegmentAksi=$Func->decrypt(@$uri->segment[4+$Main->SegmentId], ENCRYPTION_KEY);
	$SegmentIdReg=$Func->decrypt(@$uri->segment[5+$Main->SegmentId], ENCRYPTION_KEY);
	$kdregister=$kdregister!=0?$kdregister:$SegmentIdReg;
	

	$JmlTahapan=!empty($JmlTahapan)?$JmlTahapan:"0";
	
	$idmap=!empty($idmap)?$idmap:"";
	switch($Action){
		case "next":
			$QTmp="select count(*)+2 as jml from t_map_dokumen where kddokumen='{$pkddokumen}'";
		
			$Qry = _mysql_query( $QTmp );$Hasil=_mysql_fetch_array($Qry);	
			$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
			$ntahap=$tahap;
			$tahap=$tahap>=$jCount?$jCount-1:$tahap;
			
			$Func->ambilData("select z.kdmap from ( 
				select kdmap, nourut from t_map_master union
				SELECT kdmap, nourut from t_map_dokumen where kddokumen='{$pkddokumen}' 
			) as z order by z.nourut asc LIMIT 1 OFFSET ".$tahap);
			
			$nourut_id=floatval($tahap);
		
			_mysql_query("UPDATE t_prohuk set ntahap='{$ntahap}', tahap='".$nourut_id."', kdmap='".$kdmap."' where kdregister='".$kdregister."' and kddokumen='".$pkddokumen."'");
			$Func->ambilData("select * from (
				select idmap, kdmap, idgroupakses from t_map_master union
				SELECT idmap, kdmap, idgroupakses FROM t_map_dokumen where kddokumen='{$pkddokumen}' 
			) as z where kdmap='{$kdmap}'");

		break;

		case "prev":

			$tahap=floatval($tahap);
			$ntahap=$tahap;
			$tahap=$tahap<0?0:$tahap;
			
			$Func->ambilData("select z.kdmap from ( 
				select kdmap, nourut from t_map_master union
				select kdmap, nourut from t_map_dokumen where kddokumen='{$pkddokumen}' 
			) as z order by z.nourut asc LIMIT 1 OFFSET ".$tahap);

			$nourut_id=floatval($tahap);
			
			_mysql_query("UPDATE t_prohuk set ntahap='{$ntahap}', tahap='".$nourut_id."', kdmap='".$kdmap."' where kdregister='".$kdregister."' and kddokumen='".$pkddokumen."'");
		
			$Func->ambilData("select * from (
				select idmap, kdmap, idgroupakses from t_map_master union
				SELECT idmap, kdmap, idgroupakses FROM t_map_dokumen where kddokumen='{$pkddokumen}' 
			) as z where kdmap='{$kdmap}'");
		
		break;
		case "ntahap":

			_mysql_query("UPDATE t_prohuk set ntahap='{$ntahap}' where kdregister='".$kdregister."' and kddokumen='".$pkddokumen."'");
			
		break;
	}


	$ntahap=!empty($ntahap)?$ntahap:$tahap;

	
	
	$kddokumen=!empty($kddokumen)?$kddokumen:"";
	$pkddokumen=!empty($pkddokumen)?$pkddokumen:$kddokumen;

	$QTmp="select count(*) as jml from t_prohuk where kdregister='{$kdregister}'";
	$Qry = _mysql_query( $QTmp );$Hasil=_mysql_fetch_array($Qry);	
	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
	if($jCount>0){
	
		$Func->ambilData("select kdmap, tahap, ntahap as vtahap, kddokumen as pkddokumen from t_prohuk as a where a.kdregister='".$kdregister."'");
		$ntahap=floatval($vtahap);
		$tahap=floatval($tahap);
		$settahap=$tahap;
	}else{
		$settahap=0;
		$kdmap="00.00.000";
	}
	
	switch($kdmap){
		case "00.00.000":
			$idmap="800";
		break;
		case "99.99.999":
			$idmap=!empty($idmap)?$idmap:"900";
		break;
		default:
			
			$Func->ambilData("select idmap as vidmap, kddokumen as pkddokumen from t_map_dokumen where kdmap='".$kdmap."'");
			$idmap=!empty($idmap)?$idmap:$vidmap;
	}

	$Qry=_mysql_query("select * from (
		select idmap, kdmap, idgroupakses, nourut, nmmap from t_map_master union
		select idmap, kdmap, idgroupakses, nourut, nmmap from t_map_dokumen where kddokumen='{$pkddokumen}'  
		) as z order by z.nourut asc"); 
	$JmlTahapan=_mysql_num_rows($Qry);
	$ListMap="";$i=0;

	$idmapSet="";
	while($Isi=_mysql_fetch_array($Qry)){ 
		
		$active=$settahap<$i?"disabled":"";
		$style="";
		if($ntahap==$i){
			$style="style='background-color:#13C56B;color:white;'";
			$idmapSet=$Isi['idmap'];
		}
		
		$active=$idmap==$Isi['idmap']?"active":$active;
		switch($Isi['nourut']){
			case "000":
				$SbVal="dok_awal";
			break;
			case "999":
				$SbVal="dok_finish";
			break;
			default:
				$SbVal="dok_proses";
		}

		$ListMap.="<button type='button' class='list-group-item list-group-item-action {$active}' {$style} onclick=\"Fm.idmap.value='{$Isi['idmap']}';Fm.Sb.value='{$SbVal}';Fm.Action.value='ntahap';Fm.ntahap.value='".$tahap."';Fm.submit();\"><i class='ri-folders-line align-middle me-2'></i> {$Isi['nmmap']}</button>";
		$i++;
	}


	
		
	$Main->Isi = "";
	
	
	switch ($idmap){		
		case "800":
			$Sb="dok_awal";
		break;
		case "900":
			$Sb="dok_finish";
		break;
		default:
			$Sb="dok_proses";
	}
	
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
		".$Func->txtField('idmapSet',$idmapSet,'','','hidden')." 
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
                                        <li class='breadcrumb-item'><a href='javascript: void(0);'> Dokumen</a></li>
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