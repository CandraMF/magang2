<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	//session_save_path("./session");
	error_reporting  (E_ALL);
	ini_set('max_input_vars', 3000);

	set_time_limit(0);
	session_start();
	if ($_GET){foreach($_GET as $key => $value){$$key = $value;}}
	if ($_POST){foreach($_POST as $key => $value){$$key = $value;}}
	if ($_SESSION){foreach($_SESSION as $key => $value){$$key = $value;}}
	if ($_COOKIE){foreach($_COOKIE as $key => $value){$$key = $value;}}

	include ("config.inc.php");
	
	
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