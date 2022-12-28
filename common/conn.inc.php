<?php
	$servername = "localhost";
	$username = "postgres";
	$password = "kampret123";
	$dbname = "bpkh";

	$dsn = "pgsql:host=$servername;port=5432;dbname=$dbname;";
	$GLOBALS['conn'] = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]);
	//$GLOBALS['conn'] = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
?>