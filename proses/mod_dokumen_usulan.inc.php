<?php
	header("Content-Type:application/json");


	date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
	header('Expires: Mon, 1 Jul 1998 01:00:00 GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', FALSE);
	header('Pragma: no-cache');
	header("Last-Modified: " . gmdate("D, j M Y H:i:s") . " GMT" );
	

	//$header=apache_request_headers();
	//$key=!empty($header['x-api-key'])?$header['x-api-key']:"";
	$keymaster="bpkh123!@#";
	$key="bpkh123!@#";
	$method=$_SERVER['REQUEST_METHOD'];
	 
	$result=array();
	if($key==$keymaster){
		if($method=='POST'){
			if(!empty($usrnm)){
				$Func->ambilData("select idgroupakses, idbidang from ___t_users as a inner join ref_bidang as b on a.bidang=b.bidang where username='{$usrnm}'");
				$idgroupakses=$idgroupakses==2?'8888':$idgroupakses;
				if(!empty($idgroupakses)){

					////////////////////////////////////////////////////////////////////////////////////////
					///// PARAMETER AND QUERY GRID 
					$wh=!empty($ckata)?" and (lower(a.kdregister) like '%".strtolower($ckata)."%' or lower(a.nmjudul) like '%".strtolower($ckata)."%'  or lower(a.uraian) like '%".strtolower($ckata)."%') ":""; 
					$Qry="select a.stsdok, a.idprdh, a.kdregister,a.nmdokumen,a.kddokumen, a.nmjudul, a.kdmap, b.nourut ,a.tglpengajuan, c.tglvalid, a.created_date, a.uraian from t_prohuk as a left join t_map_dokumen as b on a.kdmap=b.kdmap and a.kddokumen=b.kddokumen left join t_prohuk_valid as c on a.kdregister=c.kdregister and a.idbidang=c.idbidang where a.kdmap not in (SELECT kdmap FROM t_map_master) and a.stsdok is null and a.idbidang ='{$idbidang}' $wh order by a.created_date desc"; 
					$ParamDet="{$Pg}/{$Pr}/{$ckata}/{$Action}"; 
					$Param="{$Url->BaseMain}/".$ParamDet; 

					$Param="{$Url->BaseMain}/".$ParamDet; 
					 
					///// PAGE HALAMAN GRID 
					$PageNavi = new pageNavi; 
					$batas='5';

					///$substrpos=@substr(@$REQUEST_URI,@$strpos);
					//if(empty($strpos)){$halaman=1;}else{$halaman=str_replace("pagehal-","",$substrpos);}
					$halaman=floatval($halaman);
					$halaman=!empty($halaman)?$halaman:1;
					
					$posisi = $PageNavi->cariPosisi($batas);$i=$posisi+1; 
					
					if(empty($ckata)){$limit=" limit $batas OFFSET  $posisi";}else{$halaman=1;$i=1;}		
					
					$LinkPageNavi="pagehal-{$halaman}";

					$jmldata = _mysql_num_rows(_mysql_query($Qry)); 
					$jmlhalaman = $PageNavi->jumlahHalaman($jmldata, $batas); 
					$linkHalaman = $PageNavi->navHalaman($halaman, $jmlhalaman, $Param); 
					$link=""; 
					 
					$Qry=_mysql_query($Qry.$limit); 
					
					///// LIST GRID 
					////////////////////////////////////////////////////////////////////////////////////////
					if($jmlhalaman >= $halaman){
						$result=[
							"result" =>"success",
							"code" => 200,
							"message" => 'Request Valid',
							"processId" => uniqid(),
							"processDate" => date('Y-m-d H:i:s'),
							"CountRows" => $jmldata,
							"InfoPage" => $halaman."/".$jmlhalaman
						];
						$DateToday=date('Y-m-d');
						$i=1;
						while($Isi=_mysql_fetch_array($Qry)){ 
							
							////////////////////////////////////////////////////////////////////////////
							$div="";
							switch($Isi['kdmap']){
								case "00.00.000":
									
								break;
								case "99.99.999":
									
								break;
								default:
									$imap=1;$num_map=0;
									$QryMap=_mysql_query("select a.nourut, a.nmmap, a.kdmap, b.nmgroupakses, c.pcreated_date from t_map_dokumen as a inner join __t_group_akses as b on a.idgroupakses=b.idgroupakses left join (SELECT kdmap, min(created_date) as pcreated_date	FROM t_prohuk_form where kdregister='{$Isi['kdregister']}' group by kdmap) as c on a.kdmap=c.kdmap where a.kddokumen='{$Isi['kddokumen']}' order by a.nourut");$z=1;
									while($IsiMap=_mysql_fetch_array($QryMap)){ 
										
										if(floatval($Isi['nourut'])>=floatval($IsiMap['nourut'])){
											if(!empty($IsiMap['pcreated_date'])){
												$result_sub['data-rinc'][$z-1]['dok-status']='Active';
											}else{
												$result_sub['data-rinc'][$z-1]['dok-status']='InActive';
											}
											
										}else{
											$result_sub['data-rinc'][$z-1]['dok-status']='InActive';
										
										}

										$result_sub['data-rinc'][$z-1]['dok-nourut']=$IsiMap['nourut'];
										$result_sub['data-rinc'][$z-1]['dok-deskripsi']=$IsiMap['nmmap'];
										$result_sub['data-rinc'][$z-1]['dok-aktor']=$IsiMap['nmgroupakses'];
										$result_sub['data-rinc'][$z-1]['dok-created_date']=$IsiMap['pcreated_date'];
									//	$result_sub['data-rinc'][$z-1]['dok-created_date']=$created_date;
										
										
										$z++;
									}
									
							}
									

							
							$displayp="";
							if($Isi['stsdok']==1){
								$result_sub="Dokumen Ditolak";
							}
							$classsla="";
							////////////////////////////////////////////////////////////////////////////

							$result['data'][$i-1]['kdregister']=$Isi['kdregister'];
							$result['data'][$i-1]['nmdokumen']=$Isi['nmdokumen'];
							$result['data'][$i-1]['nmjudul']=$Isi['nmjudul'];
							$result['data'][$i-1]['tglpengajuan']=$Isi['tglpengajuan'];
							$result['data'][$i-1]['created_date']=$Isi['created_date'];
							$result['data'][$i-1]['stsdok']=$result_sub;
							$i++;
						}
					}else{
						$result=[
							"result" => "failed",
							"code" => 400,
							"message" => 'Request Paging Not Valid',
							"processId" => uniqid(),
							"processDate" => date('Y-m-d H:i:s')
						];
					}
				}else{
					$result=[
						"result" => "failed",
						"code" => 400,
						"message" => 'Request Group Access Not Valid',
						"processId" => uniqid(),
						"processDate" => date('Y-m-d H:i:s')
					];
				}
			}else{
				$result=[
					"result" => "failed",
					"code" => 400,
					"message" => 'Request User Not Valid',
					"processId" => uniqid(),
					"processDate" => date('Y-m-d H:i:s')
				];
			}
					
		}else{
			$result=[
				"result" => "failed",
				"code" => 400,
				"message" => 'Request Method Not Valid',
				"processId" => uniqid(),
				"processDate" => date('Y-m-d H:i:s')
			];
		}
	}else{
		$result=[
			"result" => "failed",
			"code" => 400,
			"message" => 'Request Token Not Valid',
			"processId" => uniqid(),
			"processDate" => date('Y-m-d H:i:s')	
		];
	}
	echo json_encode($result, JSON_NUMERIC_CHECK);
?>