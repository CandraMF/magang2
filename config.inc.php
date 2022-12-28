<?php
	define("ENCRYPTION_KEY", "!@#$%^&*");

	date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
	header('Expires: Mon, 1 Jul 1998 01:00:00 GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', FALSE);
	header('Pragma: no-cache');
	header("Last-Modified: " . gmdate("D, j M Y H:i:s") . " GMT" );

	//$_SESSION['token'] = !empty($_SESSION['token'])?$_SESSION['token']:bin2hex(rand());
	if (!isset($_SESSION['token'])) {
	
		$_SESSION['token'] = md5(uniqid(mt_rand(), true));
	}
	$wh=!empty($wh)?$wh:"";
	include "common/vars.inc.php";
	//include "{$Dir->Common}/conn.php";	
	//include "{$Dir->Common}/mysql.inc.php";

	include "{$Dir->Common}/conn.inc.php";	
	include "{$Dir->Common}/postgres.inc.php";

	include "{$Dir->Common}/func.inc.php";
	include "{$Dir->Common}/pageNavi.php";	
	

	$val = new jabarsoft;$Func = new jabarsoft;
	$PHP_SELF = isset($PHP_SELF)?$PHP_SELF:$_SERVER['PHP_SELF'];
	$SITE   = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).$SLASHDOMAIN;
	
	
	$Main->Tema				= "templates/login";
	
	$Main->GetUrl			= "index.php?Pg=Login&Pr=";
	$Main->URL				= $SITE;


	$Main->Css="<link rel='stylesheet' type='text/css' href='{$Dir->Css}/default.css'><link rel='stylesheet' type='text/css' href='{$Dir->Css}/pageNavi.css'>";

	
	$strPar = $_SERVER["REQUEST_URI"];
	$strFindMe = "?";
	$exists = strpos($strPar, $strFindMe);
	if ($exists == true) {
		$strFindMe = "=";
		$exists = strpos($strPar, $strFindMe);
		if ($exists == true) {
			header("Location:".$Url->BaseUrl."index.php/notfound");
		}else{
			header("Location:".$Url->BaseUrl."index.php/notfound");
		}
	}
	
	
?>