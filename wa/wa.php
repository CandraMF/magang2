<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$url = 'http://mashery.bpkh.go.id/v1/whatsapp/send/notification';	
	$ch = curl_init($url);
	$data = array(
		'recipientNumber' => '6285224566209',
		'appName' => 'PORTAL HUKUM',
		'about' => 'Permohonan ABC - Perlu Approval',
		'description' => 'Permohonan ABC Perihal XYZ'
	);


	$JsonBody =  json_encode($data);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $JsonBody);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'api_key:36w2kh7van3eb7yg9j8hh2u6'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	echo $result;
	curl_close($ch);
?>