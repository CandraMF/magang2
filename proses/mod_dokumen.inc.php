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
					$wh=!empty($ckata)?" where lower(nmjudul) like '%".strtolower($ckata)."%'":""; 
					$Qry="select kdregister, noregister, tglregister, nmjudul, nmdokumen , uraian  from t_prohuk_valid $wh order by tglregister, created_date desc"; 
					$ParamDet="{$Pg}/{$Pr}/{$ckata}/{$Action}"; 
					$Param="{$Url->BaseMain}/".$ParamDet; 

					$Param="{$Url->BaseMain}/".$ParamDet; 
					 
					///// PAGE HALAMAN GRID 
					$PageNavi = new pageNavi; 
					$batas='5';

					$substrpos=@substr(@$REQUEST_URI,@$strpos);
					if(empty($strpos)){$halaman=1;}else{$halaman=str_replace("pagehal-","",$substrpos);}
					
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
							$QTmp="select count(*) as jmlhit, sum(case tglhit when '".$DateToday."' then 1 else 0 end) as jmlhittoday from t_prohuk_hit where kdregister='{$Isi['kdregister']}'";
							$QryTmp = _mysql_query( $QTmp );	
							$Hasil=_mysql_fetch_array($QryTmp);	
							$jmlhit=!empty($Hasil['jmlhit'])?floatval($Hasil['jmlhit']):0;
							$jmlhittoday=!empty($Hasil['jmlhittoday'])?floatval($Hasil['jmlhittoday']):0;

							$result['data'][$i-1]['noregister']=$Isi['noregister'];
							$result['data'][$i-1]['nmjudul']=$Isi['nmjudul'];
							$result['data'][$i-1]['uraian']=$Isi['uraian'];
							$result['data'][$i-1]['nmdokumen']=$Isi['nmdokumen'];
							$result['data'][$i-1]['tglregister']=$Func->TglAll($Isi['tglregister']);
							$result['data'][$i-1]['unduh']="{$Url->BasePrint}/{$Pg}/{$Pr}/publish_unduh/unduh/0/{$Isi['kdregister']}";
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