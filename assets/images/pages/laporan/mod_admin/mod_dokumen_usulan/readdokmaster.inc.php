<?php
	$Main->Isi="";
	if(isset($idPop))
	{
		//Read the filename
		$filename = $Url->BaseUrl."/drive-data/dokumen-master/".$idPopSub;
		$filenamecek = "./drive-data/dokumen-master/".$idPopSub;
		if(file_exists($filenamecek)) {

			echo "
				 <iframe width='100%'  height='100%' src='https://docs.google.com/gview?url=".basename($filename)."&embedded=true'>
				<p>Your browser does not support iframes.</p>
			  </iframe>
			";

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