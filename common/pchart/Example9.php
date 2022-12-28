<?php
	include("pChart/pData.class");
	include("pChart/pChart.class");
	
	function buatPieChart($arData = array(), $arKet = array(), $Judul = "", $Width = 420, $Height = 250, $MapID = 0)
	{
		global $Dir;
		$DataSet = new pData;
		$DataSet->AddPoint($arData,"Serie1");
		$DataSet->AddPoint($arKet,"Serie2");
		$DataSet->AddAllSeries();
		$DataSet->SetAbsciseLabelSerie("Serie2");

		// Initialise the graph
		$wFR = $Width - 5;
		$hFR = $Height - 5;
		$wRR = $Width - 2;
		$hRR = $Height - 2;
		$wChart = floor((30/100) * $Width);
		$xPos = ($wChart * 2) - 20;
		$yPos = 130;
		$Test = new pChart($Width,$Height);
		$Test->setImageMap(TRUE,$MapID);
		//$Test->drawFilledRoundedRectangle(5,5,$wFR,$hFR,5,240,240,240);
		$Test->drawRoundedRectangle(0,0,$wRR,$hRR,5,50,50,50);
		//$Test->createColorGradientPalette(195,204,56,223,110,41,5);

		// Draw the pie chart
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->AntialiasQuality = 0;
		$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),$xPos,$yPos,$wChart,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
		$Test->drawPieLegend(10,30,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);	

		// Write the title
		$Test->setFontProperties("Fonts/MankSans.ttf",10);
		$Test->drawTitle(10,20,$Judul,0,0,0);
		return $Test->Stroke();
	}
	if($_GET['chart']=="yes")
	{
	buatPieChart(array(200,300), $arKet = array("Laki-laki","Perempuan"), "Jumlah Jenis Kelamin", $Width = 420, $Height = 250, $MapID = 0);
	}

	echo "<img src='Example9.php?chart=yes'>dkdkdk";

?>