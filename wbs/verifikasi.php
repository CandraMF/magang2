<?php
	header("Content-Type:application/json");

	define("ENCRYPTION_KEY", "!@#$%^&*");

	date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
	header('Expires: Mon, 1 Jul 1998 01:00:00 GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', FALSE);
	header('Pragma: no-cache');
	header("Last-Modified: " . gmdate("D, j M Y H:i:s") . " GMT" );
	
	$revisi_ke=!empty($revisi_ke)?$revisi_ke:0;
	$Pesan2="";$StsError=0;$FormQryIsiError=0;
	
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
			
				/////////////// POST SIMPAN
				switch($Action){
					case "next":
						$QTmp="select count(*)+2 as jml from t_map_dokumen where kddokumen='{$kddokumen}'";
					
						$Qry = _mysql_query( $QTmp );$Hasil=_mysql_fetch_array($Qry);	
						$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
						$ntahap=$tahap;
						$tahap=$tahap>=$jCount?$jCount-1:$tahap;
						
						$Func->ambilData("select z.kdmap from ( 
							select kdmap, nourut from t_map_master union
							SELECT kdmap, nourut from t_map_dokumen where kddokumen='{$kddokumen}' 
						) as z order by z.nourut asc LIMIT 1 OFFSET ".$tahap);
						
						$nourut_id=floatval($tahap);
					
						$Simpan=_mysql_query("UPDATE t_prohuk set ntahap='{$ntahap}', tahap='".$nourut_id."', kdmap='".$kdmap."' where kdregister='".$kdregister."' and kddokumen='".$kddokumen."'");
					
						$Pesan = $Simpan?"Sudah di simpan":"Gagal di simpan";		

					break;

					case "prev":

						$tahap=floatval($tahap);
						$ntahap=$tahap;
						$tahap=$tahap<0?0:$tahap;
						
						$Func->ambilData("select z.kdmap from ( 
							select kdmap, nourut from t_map_master union
							select kdmap, nourut from t_map_dokumen where kddokumen='{$kddokumen}' 
						) as z order by z.nourut asc LIMIT 1 OFFSET ".$tahap);

						$nourut_id=floatval($tahap);
						
						$Simpan=_mysql_query("UPDATE t_prohuk set ntahap='{$ntahap}', tahap='".$nourut_id."', kdmap='".$kdmap."' where kdregister='".$kdregister."' and kddokumen='".$kddokumen."'");
						
						$Pesan = $Simpan?"Sudah di simpan":"Gagal di simpan";		
					
					break;

					case "verifikasi";
						if(!empty($kdregister)){
								if(!empty($kdmapform)){
									switch($nmform){
										case "numeric":
											$insert_param="num_value, ";
											$insert_value="'{$num_value}', ";
											$update_param="num_value='{$num_value}', ";
											$FormDataValue=$num_value;
										break;
										case "date":
											$insert_param="date_value, ";
											$insert_value="'{$date_value}', ";

											$update_param="date_value='{$date_value}', ";

											$FormDataValue=$date_value;
										break;
										case "file":
											$vcode=substr(date('Y'),-2).date('md').uniqid();
											$flname=$_FILES['text_value']['name'];
											$namaFile = $vcode."_".$flname;
											$namaFile=str_replace(" ","_",$namaFile);
											$namaSementara = $_FILES['text_value']['tmp_name'];
											$dirUpload = "./drive-data/dokumen-usulan/";


											$size        =$_FILES['text_value']['size'];
											$max_size    = 512000;
											if ($size > $max_size){
												$Pesan2.= "[ file maksimal 5 MB ]";
												$FormQryIsiError++;
											}else{
												$allowed = array('gif', 'png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx');
												$filename =$_FILES['text_value']['name'];
												$ext = pathinfo($filename, PATHINFO_EXTENSION);
												if (!in_array($ext, $allowed)) {
													$Pesan2.= "[ extension tidak sesuai ]";
													$insert_param="";
													$insert_value="";
													$update_param="";
													$FormQryIsiError++;
												}else{
													$terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);
													$insert_param="text_value, ";
													$insert_value="'".@$namaFile."', ";
													$update_param="text_value='{$namaFile}', ";
												}
											}
											
											if(!empty($flname)){
												$FormDataValue=@$flname;
											}else{
												$FormDataValue=@$hidden_text_value;
												if(!empty($FormDataValue)){
													$FormQryIsiError--;
												}
											}
											
										break;
										default:
											$insert_param="text_value, ";
											$insert_value="'{$text_value}', ";

											$update_param="text_value='{$text_value}', ";

											$FormDataValue=$text_value;
										
									}

									if($mandatory=="Y"){
										if(empty($FormDataValue)){
											$StsError++;
										}
									}

									$Func->ambilData("select kddokumen, nmdokumen from t_prohuk where kdregister='{$kdregister}'");
									$Func->ambilData("select kdmap, nmmapform from t_map_form WHERE kdmapform='{$kdmapform}'");
									
									$QCekStatus=_mysql_query("SELECT * FROM t_prohuk_status WHERE kdregister='{$kdregister}' AND kdmap='{$kdmap}';");
									
									if(!_mysql_num_rows($QCekStatus)){	
										
										_mysql_query("INSERT INTO t_prohuk_status (kdregister, kddokumen, nmdokumen, kdmap, revisi_ke, created_by, created_date) VALUES ('{$kdregister}', '{$kddokumen}', '{$nmdokumen}', '{$kdmap}', '{$revisi_ke}', '{$pcreated_by}', '{$pcreated_date}');");
									}
									
									if($nmform=="file"){
										if(!empty($flname)){
											$QCek=_mysql_query("SELECT * FROM t_prohuk_form WHERE kdregister='{$kdregister}' AND kdmapform='{$kdmapform}';");
											if(!_mysql_num_rows($QCek)){				
												  
												$Simpan=_mysql_query("INSERT INTO t_prohuk_form (kdregister, kddokumen, nmdokumen, kdmap, kdmapform, nmmapform, revisi_ke, {$insert_param} created_by, created_date) VALUES ('{$kdregister}', '{$kddokumen}', '{$nmdokumen}', '{$kdmap}', '{$kdmapform}', '{$nmmapform}', '{$revisi_ke}', {$insert_value} '{$pcreated_by}', '{$pcreated_date}');");
											}else{
												$Simpan=_mysql_query("UPDATE t_prohuk_form SET {$update_param} updated_by='{$pupdated_by}', updated_date='{$pupdated_date}' WHERE  kdregister='{$kdregister}' AND kdmapform='{$kdmapform}';");
											}
											$Pesan = $Simpan?"Sudah di simpan":"Gagal di simpan";
										}
										
									}else{
										$QCek=_mysql_query("SELECT * FROM t_prohuk_form WHERE kdregister='{$kdregister}' AND kdmapform='{$kdmapform}';");
										if(!_mysql_num_rows($QCek)){
											$Simpan=_mysql_query("INSERT INTO t_prohuk_form (kdregister, kddokumen, nmdokumen, kdmap, kdmapform, nmmapform, revisi_ke, {$insert_param} created_by, created_date) VALUES ('{$kdregister}', '{$kddokumen}', '{$nmdokumen}', '{$kdmap}', '{$kdmapform}', '{$nmmapform}', '{$revisi_ke}', {$insert_value} '{$pcreated_by}', '{$pcreated_date}');");
										}else{
											$Simpan=_mysql_query("UPDATE t_prohuk_form SET {$update_param} updated_by='{$pupdated_by}', updated_date='{$pupdated_date}' WHERE  kdregister='{$kdregister}' AND kdmapform='{$kdmapform}';");
										}
										$Pesan = $Simpan?"Sudah di simpan":"Gagal di simpan";		
									
									}
									
								}
							
								if($StsError>0){
									$Pesan="Maaf terdapat form yang berwarna belum teriisi ".$Pesan2.", silahkan cek kembali";	
									
								}

							$result['status']=[
								"code" => 200,
								"description" => $Pesan
							];
						}else{
							$result['status']=[
								"code" => 400,
								"description" => 'Request Not Valid ( Register Not Valid )'
							];
						}
					}
					else
					{$Pesan = "Maaf, form warna merah wajib diisi";}
				break;
				
			}

			///////////////////////////////////////////////

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