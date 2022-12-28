<?php
	include ("config.inc.php");
	if(isset($_GET['image_id'])) {
		switch($_GET['jenis']){
			case "mbarang":
				$sql = "SELECT GAMBARYPE as imageType, GAMBAR as imageData FROM mbarang WHERE NOPART='" . $_GET['image_id']."'";			

			break;
		}

		$result = mysql_query("$sql") or die("<b>Error:</b> Problem on Retrieving Image BLOB<br/>" . mysql_error());
		$row = mysql_fetch_array($result);
		header("Content-type: " . $row["imageType"]);
		echo $row["imageData"];
	}

?>