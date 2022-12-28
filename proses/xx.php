<?php
	header("Content-Type:application/json");


	date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
	header('Expires: Mon, 1 Jul 1998 01:00:00 GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', FALSE);
	header('Pragma: no-cache');
	header("Last-Modified: " . gmdate("D, j M Y H:i:s") . " GMT" );
	

	$header=apache_request_headers();
	$key=!empty($header['x-api-key'])?$header['x-api-key']:"";
	$keymaster="bpkh123!@#";
	$method=$_SERVER['REQUEST_METHOD'];
	 
	$result=array();
	if($key==$keymaster){
		if($method=='POST'){
			if(!empty($usrnm)){
				$Func->ambilData("select idgroupakses, idbidang from ___t_users as a inner join ref_bidang as b on a.bidang=b.bidang where username='{$usrnm}'");
				$idgroupakses=$idgroupakses==2?'8888':$idgroupakses;
				if(!empty($idgroupakses)){
					$result=[
						"result" =>"success",
						"code" => 200,
						"message" => 'Request Valid',
						"processId" => uniqid(),
						"processDate" => date('Y-m-d H:i:s')
					];
					$Qry="select z.jml, z.ketdok from (SELECT count(*) as jml, 'JmlDokVerif' as ketdok FROM t_prohuk as a inner join t_map_dokumen as b on a.kdmap=b.kdmap where a.kdmap not in (SELECT kdmap FROM t_map_master) and stsdok is null and b.idgroupakses='{$idgroupakses}' union SELECT count(*) as jml, 'JmlDokProses' as ketdok  FROM t_prohuk where kdmap not in (SELECT kdmap FROM t_map_master) and stsdok is null and idbidang ='{$idbidang}') as z order by z.ketdok asc";

				
					$Qry=_mysql_query($Qry); $i=1;
					while($Isi=_mysql_fetch_array($Qry)){ 
						
						$result['data'][$i-1]['Jml']=$Isi['jml'];
						$result['data'][$i-1]['KetDok']=$Isi['ketdok'];
						$i++;
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
			/*
				SELECT count(*) as dokproses FROM t_prohuk where kdmap not in (SELECT kdmap FROM t_map_master) and stsdok is null and idbidang ='3'
				
				SELECT count(*) as dokumenlist FROM t_prohuk as a inner join t_map_dokumen as b on a.kdmap=b.kdmap where a.kdmap not in (SELECT kdmap FROM t_map_master) and stsdok is null and b.idgroupakses='3'


				$wh.=!empty($ckata)?" and (lower(a.kdregister) like '%".strtolower($ckata)."%' or lower(a.nmjudul) like '%".strtolower($ckata)."%'  or lower(a.uraian) like '%".strtolower($ckata)."%') ":""; 
				select kdregister, noregister, tglregister, nmjudul, nmdokumen , uraian  from t_prohuk_valid $wh order by tglregister, created_date desc

			*/				
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