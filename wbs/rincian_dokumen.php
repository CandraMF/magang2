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
			////////////////////////////////////////////////////////////
			$Func->ambilData("select d.noregister, a.idprdh, a.kdregister,a.nmdokumen,a.kddokumen, a.nmjudul, a.kdmap, b.nourut ,a.tglpengajuan, d.tglvalid, a.created_date, a.uraian, c.nmbidang from t_prohuk as a left join t_map_dokumen as b on a.kdmap=b.kdmap and a.kddokumen=b.kddokumen left join ref_bidang as c on a.idbidang=c.idbidang left join t_prohuk_valid as d on a.kdregister=d.kdregister where a.kdregister='{$kdregister}' order by a.created_date, a.idprdh desc");
			$divm="";
			$result['result']['kdmap']=$kdmap;
			switch($kdmap){
				case "00.00.000":
					$result['result']['stsmap']="Pengajuan";
				break;
				case "99.99.999":
					
					if(!empty($tglvalid)){
						$divm="Sudah Disahkan";
					}else{
						$divm="Proses Pengesahan";
					}
					$result['result']['stsmap']=$divm;
				
				break;
				default:
					$Func->ambilData("select nourut, nmmap, kdmap from t_map_dokumen where kdmap='{$kdmap}'");
					$result['result']['stsmap']=$nmmap;
			}
			$result['result']['kdregister']=$kdregister;
			$result['result']['noregister']=$noregister;
			$result['result']['nmjudul']=$nmjudul;
			$result['result']['uraian']=$uraian;
			$result['result']['nmbidang']=$nmbidang;
			$result['result']['tglpengajuan']=$Func->TglAll($tglpengajuan);
			$result['result']['Waktu']=$Func->TglInd($created_date)." ".substr(substr($created_date,-12),0,6);
			
			////////////////////////////////////////////////////////////
			$tdform="";
			$revisi_ke=0;
			$Func->ambilData("SELECT * FROM t_prohuk where kdregister='{$kdregister}';");
			$Qry=_mysql_query("select * from (
				select idmap, kdmap, idgroupakses, nourut, nmmap from t_map_master union
				select idmap, kdmap, idgroupakses, nourut, nmmap from t_map_dokumen where kddokumen='{$kddokumen}'  
				) as z order by z.nourut asc"); 
			$JmlTahapan=_mysql_num_rows($Qry);
			$ListMap="";$i=0;$z=0;

			$idmapSet="";
			while($Isi=_mysql_fetch_array($Qry)){ 
				$div="";
				switch($Isi['idmap']){
					case "800":
						$Func->ambilData("select * from t_prohuk as a left join ref_bidang as b on a.idbidang=b.idbidang where a.kdregister='".$kdregister."'");
						$i++;
					break;
					case "900":
						$Func->ambilData("select * from t_prohuk as a  where a.kdregister='".$kdregister."'");
						$Func->ambilData("select noregister, tglregister from t_prohuk_valid as a  where a.kdregister='".$kdregister."'");

						$result['result'][$i-1]['noregister']=$noregister;
						$result['result'][$i-1]['tglregister']=$Func->TglAll($tglregister);
						$i++;
					break;
					default:
						$Func->ambilData("select * from t_prohuk as a  where a.kdregister='".$kdregister."'");
						$expanded="false";
						$QryDiv="select a.mandatory, a.idmapform, a.nmmapform, a.kdmapform, a.level, b.nmform, a.arrdata, a.nmurl, a.catatan, a.aktif, c.text_value, c.num_value, c.date_value from t_map_form as a
						inner join ref_form as b on a.idform=b.idform 
						left join (select kdmapform, text_value, num_value, date_value  from t_prohuk_form where revisi_ke='".$revisi_ke."' and kdregister='".$kdregister."') as c on a.kdmapform=c.kdmapform
						where a.kdmap='{$Isi['kdmap']}'
						order by a.tr, a.kdmapform";
						$QryDiv=_mysql_query($QryDiv);
						while($IsiDiv=_mysql_fetch_array($QryDiv)){ 

							$result['result'][$i-1]['nmmapform']=$IsiDiv['nmmapform'];
							$result['result'][$i-1]['nmform']=$IsiDiv['nmform'];

							switch($IsiDiv['nmform']){
								case "textarea":
									$tdform=@$IsiDiv['text_value'];
									$result['result'][$i-1]['text_value']=$tdform;
								break;
								case "text":
									$tdform=@$IsiDiv['text_value'];
									$result['result'][$i-1]['text_value']=$tdform;
								break;
								case "file":
									$result['result'][$i-1]['text_value']=$IsiDiv['text_value'];
									
								break;
								case "numeric":
									if(@$IsiDiv['num_value']){
										$tdform=floatval(@$IsiDiv['num_value']);
									}else{
										$tdform="";
									}
									$result['result'][$i-1]['num_value']=$tdform;
								break;
								case "cmb":
									$tdform=@$IsiDiv['text_value'];
									$result['result'][$i-1]['text_value']=$tdform;
								break;
								case "date":
									$date_value=!empty($IsiDiv['date_value'])?$Func->TglAll($IsiDiv['date_value']):"";
									$tdform=@$date_value;
									$result['result'][$i-1]['date_value']=$tdform;
								break;
								case "href":
									$vtext_value=$IsiDiv['text_value'];
									if(!empty($vtext_value)){
										$tdform="{$Url->BasePrint}/{$Pg}/{$Pr}/detail/unduh/0/".@$vtext_value."";
									}else{
										$tdform="";
									}
									$result['result'][$i-1]['text_value']=$tdform;
								break;
								case "href form":
									$Func->ambilData("SELECT text_value as vtext_value FROM t_prohuk_form where kdmapform='".@$IsiDiv['nmurl']."' and kdregister='".$kdregister."' and kddokumen='".$kddokumen."'");

									$tdform="{$Url->BasePrint}/{$Pg}/{$Pr}/detail/unduh/0/".@$vtext_value."";
									$result['result'][$i-1]['text_value']=$tdform;

								break;
								default:
									$tdform="";
								
							}
							
							
							$i++;
						}
				}
				
				$z++;
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