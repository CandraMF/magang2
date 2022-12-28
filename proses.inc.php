<?php

	if ($_GET){foreach($_GET as $key => $value){$$key = $value;}}
	if ($_POST){foreach($_POST as $key => $value){$$key = $value;}}
	if ($_SESSION){foreach($_SESSION as $key => $value){$$key = $value;}}
	if ($_COOKIE){foreach($_COOKIE as $key => $value){$$key = $value;}}

	
	
	$CREATED_BY=$sUserId;
	$UPDATED_BY=$sUserId;
	$TANGGAL_AKSES= date("Y-m-d h:i:s");
	$CREATED_DATE=$TANGGAL_AKSES;
	$UPDATED_DATE=$TANGGAL_AKSES;
	$DATE_CREATED=$TANGGAL_AKSES;
	$DATE_UPDATED=$TANGGAL_AKSES;
	$Pg=$Func->decrypt(@$uri->segment[1+$Main->SegmentId], ENCRYPTION_KEY);
	$Pr=$Func->decrypt(@$uri->segment[2+$Main->SegmentId], ENCRYPTION_KEY);
	$Main->Page=$Pg;
	$Main->Part=$Pr;
	$REQUEST_URI=$_SERVER['REQUEST_URI'];
	$strpos=strpos($REQUEST_URI,"pagehal-");
	$dt = new stdClass();
	
	switch ($Main->Page)
	{
		case "api":	
			
			if (file_exists("{$Dir->Proses}{$Main->Part}.inc.php")) {
			
				include "{$Dir->Proses}{$Main->Part}.inc.php";
			}
		break;
	}

	
?>