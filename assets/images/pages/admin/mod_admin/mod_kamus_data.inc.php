<?php
	$Main->JsonIsi="";
	$Show = $Func->gFile("{$Main->Tema}/jsondata.html");
	$Show = str_replace("<!--JsonIsi-->","$Main->JsonIsi",$Show);

	header('Content-Type: application/json; charset=utf-8');
	if(!empty($cari_kamus)){
		$sql = "SELECT idkamus as category, concat(nmkamus,' adalah ',uraian) as label  from t_kamus_hukum where (lower(nmkamus) like '%{$cari_kamus}%' or lower(uraian) like '%{$cari_kamus}%') and stskamus='Diterima' and aktif='aktif'  ORDER BY nmkamus limit 20";
		
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