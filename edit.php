<?php

//error_reporting(0);
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

include($Dir->Library."/library.inc.php");
include($Dir->Pages."/tampilan/menu.inc.php");
$Show = $Func->gFile("{$Main->Tema}/base.inc.php");


?>