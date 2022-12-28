<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//session_save_path("./session");
ini_set('max_input_vars', 3000);

set_time_limit(0);

include ("config.inc.php");

$Pgx=@$uri->segment[1+@$Main->SegmentId];

if($Pgx=="api"){
	include ("proses.inc.php");
}else{
	include ("auth.inc.php");
}
?>