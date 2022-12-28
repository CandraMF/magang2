<?php
	$Main->Isi="";
	if(isset($idPop))
	{
		//Read the filename
		$filename = "./drive-data/dokumen-usulan/".$idPopSub;
		if(file_exists($filename)) {

			//Define header information
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Cache-Control: no-cache");
			header("Pragma: no-cache");
			header('Content-Disposition: attachment; filename="'.basename($filename).'"');
			header('Content-Length: ' . filesize($filename));

			//Clear system output buffer
			flush();

			//Read the size of the file
			readfile($filename);

			//Terminate from the script
			die();
		}
		else{
			echo "File does not exist.";
		}
	
	}
	else{
		echo "Filename is not defined.";
	}
?>