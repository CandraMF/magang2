<?php
	$Main->JsonIsi="";
	$Show = $Func->gFile("{$Main->Tema}/jsondata.html");
	$Show = str_replace("<!--JsonIsi-->","$Main->JsonIsi",$Show);

	header('Content-Type: application/json; charset=utf-8');
	if(!empty($cari_kamus)){
		$sql = "SELECT idkamus as category, nmkamus as label  from t_kamus_hukum where lower(nmkamus) like '%ab%' ORDER BY nmkamus";
		
		$result = _mysql_query($sql);
		//create an array
		$emparray = array();
		while($row =_mysql_fetch_array($result))
		{
			$emparray[] = $row;
		}
	}else{
		$emparray=array();
	}
	echo json_encode($emparray);
?>