<?php
	header('Content-Type: application/json; charset=utf-8');
	

	include ("config.inc.php");
	if ($_GET){foreach($_GET as $key => $value){$$key = $Func->antiinjection($value);}}
	if ($_POST){foreach($_POST as $key => $value){$$key = $Func->antiinjection($value);}}
	if(!empty($cari_barang)){
		$sql = "SELECT a.nmbarang as label, b.nmkatbarang as category FROM ref_barang_obt AS a INNER JOIN ref_katbarang AS b ON a.idkatbarang=b.idkatbarang where a.nmbarang like '%".$cari_barang."%' or a.kdbarang like '%".$cari_barang."%' ORDER BY b.nmkatbarang, a.nmbarang limit 20";
	
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