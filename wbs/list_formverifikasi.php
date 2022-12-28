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
	if($key==$keymaster){ 
		$result=array();
		if($method=='POST'){
			

			include "../common/vars.inc.php";
			include "../common/conn.inc.php";	
			include "../common/postgres.inc.php";	
			include "../common/func.inc.php";
			$Func = new jabarsoft;

			//////////////////// CONTENT 
			
			$Func->ambilData("select idgroupakses as param_idgroupakses from ___t_users where username='{$sUserId}'");
			 
			$param_idgroupakses=floatval($param_idgroupakses);
			switch($param_idgroupakses){
				case "1":
					$QTmp="select count(*) as jml from t_prohuk as a left join t_map_dokumen as b on a.kdmap=b.kdmap and a.kddokumen=b.kddokumen left join t_prohuk_valid as c on a.kdregister=c.kdregister and a.idbidang=c.idbidang where a.idprdh>0 and a.kdmap!='00.00.000' and a.kdregister='{$kdregister}'"; 
			
				break;
				case "4":
					$QTmp="select count(*) as jml from t_prohuk as a left join t_map_dokumen as b on a.kdmap=b.kdmap and a.kddokumen=b.kddokumen left join t_prohuk_valid as c on a.kdregister=c.kdregister and a.idbidang=c.idbidang where a.idprdh>0 and a.kdmap!='00.00.000' and (b.idgroupakses='{$param_idgroupakses}' or a.kdmap='99.99.999') and a.kdregister='{$kdregister}' "; 
				break;
				default:
					$QTmp="select count(*) as jml from t_prohuk as a left join t_map_dokumen as b on a.kdmap=b.kdmap and a.kddokumen=b.kddokumen left join t_prohuk_valid as c on a.kdregister=c.kdregister and a.idbidang=c.idbidang where a.idprdh>0 and a.kdmap!='00.00.000' and b.idgroupakses='{$param_idgroupakses}' and a.kdregister='{$kdregister}' "; 
				
			}
			
			$Qry = _mysql_query( $QTmp );	
			$Hasil=_mysql_fetch_array($Qry);	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
			if ($jCount > 0){

				$result['status']=[
					"code" => 200,
					"description" => 'Request Valid'
				];
				/////////////////// SUB ISI
				$revisi_ke=!empty($revisi_ke)?$revisi_ke:0;
				$Pesan2="";$StsError=0;$FormQryIsiError=0;
				
				$ParamDisable="";$ParamHiden="";
				
				$Func->ambilData("select kdmap, tahap, ntahap as vtahap, kddokumen as pkddokumen from t_prohuk as a where a.kdregister='".$kdregister."'");
				$Func->ambilData("select idmap as vidmap, kddokumen as pkddokumen from t_map_dokumen where kdmap='".$kdmap."'");
				$idmap=!empty($idmap)?$idmap:$vidmap;


				$ParamDisable="";$ParamHiden="";$ParamHiden2="";
				$Func->ambilData("SELECT a.kdmap, a.kddokumen, a.nourut, a.nmmap, a.tipe, b.nmdokumen, a.idgroupakses as pv_idgroupakses,  c.nmgroupakses from t_map_dokumen as a inner join ref_dokumen as b on a.kddokumen=b.kddokumen inner join __t_group_akses as c on a.idgroupakses=c.idgroupakses where a.idmap='".$idmap."' ORDER BY b.kddokumen, a.kdmap");
				
				$Func->ambilData("select idgroupakses as param_idgroupakses from ___t_users where username='{$sUserId}'");
				switch($param_idgroupakses){
					case "1":
						
					break;
					default:
						if($param_idgroupakses!=$pv_idgroupakses){
							$ParamDisable="disabled";
							$ParamHiden="style='display:none;'";
						}
				}
				
				$result['result']['kdregister']=$kdregister;
				$result['result']['kddokumen']=$kddokumen;
				$result['result']['Dokumen']=$nmdokumen;
				$result['result']['Aktor']=$nmgroupakses;
				$result['result']['revisi_ke']=$revisi_ke;
				$result['result']['kdmap']=$kdmap;
				$result['result']['Deskripsi']=$kdmap." ".$nmmap;

				$Qry="select a.mandatory, a.idmapform, a.nmmapform, a.kdmapform, a.level, b.nmform, a.arrdata, a.nmurl, a.catatan, a.aktif, c.text_value, c.num_value, c.date_value from t_map_form as a
				inner join ref_form as b on a.idform=b.idform 
				left join (select kdmapform, text_value, num_value, date_value  from t_prohuk_form where revisi_ke='".$revisi_ke."' and kdregister='".$kdregister."') as c on a.kdmapform=c.kdmapform
				where a.kdmap='{$kdmap}'
				order by a.tr, a.kdmapform";
				$Qry=_mysql_query($Qry);$i=1; 
				while($Isi=_mysql_fetch_array($Qry)){ 
					$result['result']["Form.Urut.Ke.".$i-1]['nourut']=$i;
					$result['result']["Form.Urut.Ke.".$i-1]['mandatory']=$Isi['mandatory'];
					//$result['result']["Form.Urut.Ke.".$i-1]['level']=$Isi['level'];
					$result['result']["Form.Urut.Ke.".$i-1]['kdmapform']=$Isi['kdmapform'];
					$result['result']["Form.Urut.Ke.".$i-1]['nmmapform']=$Isi['nmmapform'];
					$result['result']["Form.Urut.Ke.".$i-1]['nmform']=$Isi['nmform'];
					
					

					switch($Isi['nmform']){
						case "textarea":
							$result['result']["Form.Urut.Ke.".$i-1]['text_value']=$Isi['text_value'];

							$FormDataIsi=@$Isi['text_value'];
							if($Isi['mandatory']=='Y'){
								if(empty($FormDataIsi)){
										$FormQryIsiError++;
								}
							}
							
						break;
						case "text":
							$result['result']["Form.Urut.Ke.".$i-1]['text_value']=$Isi['text_value'];

							$FormDataIsi=@$Isi['text_value'];
							if($Isi['mandatory']=='Y'){
								if(empty($FormDataIsi)){
									$FormQryIsiError++;
								}
							}
						break;
						case "file":
							$result['result']["Form.Urut.Ke.".$i-1]['text_value']=$Isi['text_value'];

							$FormDataIsi=@$Isi['text_value'];
							if($Isi['mandatory']=='Y'){
								if(empty($FormDataIsi)){
									$FormQryIsiError++;
								}
							}
						break;
						case "numeric":
							$result['result']["Form.Urut.Ke.".$i-1]['num_value']=$Isi['num_value'];

							$FormDataIsi=@$Isi['num_value'];
							if($Isi['mandatory']=='Y'){
								if(empty($FormDataIsi)){
									$FormQryIsiError++;
								}
							}
						break;
						case "cmb":
							$arrdata=$Isi['arrdata'];
							$arrdata=str_replace('"','',$arrdata);
							$arrdata=str_replace("'","",$arrdata);
							$arrdata=str_replace("&#039;","",$arrdata);
							$arrdata=str_replace("&quot;","",$arrdata);

							$result['result']["Form.Urut.Ke.".$i-1]['text_value']=$Isi['text_value'];
							$result['result']["Form.Urut.Ke.".$i-1]['arrdata']=$Isi['arrdata'];

							

							$FormDataIsi=@$Isi['text_value'];
							if($Isi['mandatory']=='Y'){
								if(empty($FormDataIsi)){
									$FormQryIsiError++;
								}
							}
						break;
						case "date":
							$date_value=!empty($Isi['date_value'])?$Isi['date_value']:date('Y-m-d');
							
							$result['result']["Form.Urut.Ke.".$i-1]['date_value']=$date_value;

							$FormDataIsi=@$Isi['date_value'];
							if($Isi['mandatory']=='Y'){
								if(empty($FormDataIsi)){
									$FormQryIsiError++;
								}
							}
						break;
						case "href":
							
							$result['result']["Form.Urut.Ke.".$i-1]['text_value']=$Isi['text_value'];
							$FormDataIsi=@$Isi['text_value'];
							if($Isi['mandatory']=='Y'){
								if(empty($FormDataIsi)){
									$FormQryIsiError++;
								}
							}
						break;
						case "href form":
							$Func->ambilData("SELECT text_value as vtext_value FROM t_prohuk_form where kdmapform='".@$Isi['nmurl']."' and kdregister='".$kdregister."' and kddokumen='".$kddokumen."'");

							$result['result']["Form.Urut.Ke.".$i-1]['text_value']=$Isi['text_value'];
							$FormDataIsi=@$Isi['text_value'];
							if($Isi['mandatory']=='Y'){
								if(empty($FormDataIsi)){
									$FormQryIsiError++;
								}
							}
						break;
						default:
							$tdform="";
						
					}
					
				
					$result['result']["Form.Urut.Ke.".$i-1]['kdmapform']=$Isi['kdmapform'];

					$i++; 
				}
			}else{
				$result['status']=[
					"code" => 400,
					"description" => 'Request Not Valid ( Register Not Valid )'
				];
			}
		

			//////////////////// CONTENT 

		}else{
			$result['status']=[
				"code" => 400,
				"description" => 'Request Not Valid ( Method Not Valid )'
			];
		}
	}else{
		$result['status']=[
			"code" => 400,
			"description" => 'Request Not Valid ( Token Not Valid )'
		];
	}
	echo json_encode($result);
?>


