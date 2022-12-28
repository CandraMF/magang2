<?php
	header("Content-Type:application/json");

	define("ENCRYPTION_KEY", "!@#$%^&*");

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
			

			include "../common/vars.inc.php";
			include "../common/conn.inc.php";	
			include "../common/postgres.inc.php";	
			include "../common/func.inc.php";
			$Func = new jabarsoft;

			$result['status']=[
				"code" => 200,
				"description" => 'Request Valid'
			];

			$Func->ambilData("select idgroupakses as param_idgroupakses from ___t_users where username='{$sUserId}'");
			if(!empty($param_idgroupakses)){
				switch($param_idgroupakses){
					case "1":
						$Qry="select a.idprdh, a.kdregister,a.nmdokumen,a.kddokumen, a.nmjudul, a.kdmap, b.nourut ,a.tglpengajuan, c.tglvalid, a.created_date, a.uraian from t_prohuk as a left join t_map_dokumen as b on a.kdmap=b.kdmap and a.kddokumen=b.kddokumen left join t_prohuk_valid as c on a.kdregister=c.kdregister and a.idbidang=c.idbidang where a.idprdh>0 and a.kdmap!='00.00.000' {$wh} order by a.created_date desc"; 
				
					break;
					case "4":
						$Qry="select a.idprdh, a.kdregister,a.nmdokumen,a.kddokumen, a.nmjudul, a.kdmap, b.nourut ,a.tglpengajuan, c.tglvalid, a.created_date, a.uraian from t_prohuk as a left join t_map_dokumen as b on a.kdmap=b.kdmap and a.kddokumen=b.kddokumen left join t_prohuk_valid as c on a.kdregister=c.kdregister and a.idbidang=c.idbidang where a.idprdh>0 and a.kdmap!='00.00.000' and (b.idgroupakses='{$param_idgroupakses}' or a.kdmap='99.99.999') {$wh} order by a.created_date desc"; 
					break;
					default:
						$Qry="select a.idprdh, a.kdregister,a.nmdokumen,a.kddokumen, a.nmjudul, a.kdmap, b.nourut ,a.tglpengajuan, c.tglvalid, a.created_date, a.uraian from t_prohuk as a left join t_map_dokumen as b on a.kdmap=b.kdmap and a.kddokumen=b.kddokumen left join t_prohuk_valid as c on a.kdregister=c.kdregister and a.idbidang=c.idbidang where a.idprdh>0 and a.kdmap!='00.00.000' and b.idgroupakses='{$param_idgroupakses}' {$wh} order by a.created_date desc"; 
					
				}
				$Qry=_mysql_query($Qry); $i=1;
				while($Isi=_mysql_fetch_array($Qry)){ 
					$div="";

					switch($Isi['kdmap']){
						case "00.00.000":
							$div="Pengajuan";
						break;
						case "99.99.999":
							if(!empty($Isi['tglvalid'])){
								$div="Sudah Disahkan";
							}else{
								$div="Proses Pengesahan";
							}
						break;
						default:
							$Func->ambilData("select nourut, nmmap, kdmap from t_map_dokumen where kdmap='{$Isi['kdmap']}' order by nourut");
							$div=$nmmap;
					}

					$result['result'][$i-1]['NoSeri']=$Isi['kdregister'];
					$result['result'][$i-1]['Judul']=$Isi['nmjudul'];
					$result['result'][$i-1]['TglPengajuan']=$Func->TglAll($Isi['tglpengajuan']);
					$result['result'][$i-1]['TglPembuatan']=$Func->TglAll($Isi['created_date']);
					$result['result'][$i-1]['WktPembuatan']=substr(substr($Isi['created_date'],-12),0,6);
					$result['result'][$i-1]['Uraian']=$Isi['uraian'];
					$result['result'][$i-1]['Status']=$div;
					
					$i++; 
				}
			}else{
					$result['status']=[
					"code" => 400,
					"description" => 'Request Not Valid'
				];
			}

		}else{
			$result['status']=[
				"code" => 400,
				"description" => 'Request Not Valid'
			];
		}
	}else{
		$result['status']=[
			"code" => 400,
			"description" => 'Request Not Valid'
		];
	}
	echo json_encode($result);
?>