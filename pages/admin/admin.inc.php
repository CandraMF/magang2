<?php
$MainJudul="";
$idSub=!empty($idSub)?$idSub:"0";
@session_start();
$Main->Tema= "templates/baru";
if($ScreenWidth<=720){
	$Show = $Func->gFile("{$Main->Tema}/mobile.html");
}else{
	$Show = $Func->gFile("{$Main->Tema}/base.html");
}
/*
include "timeout.php";

function cek_login(){
	$timeout=$_SESSION['timeout'];
	
	if(time()<$timeout){
		timer();		
		return true;
	}else{
		unset($_SESSION['timeout']);
		return false;
	}
}

if($_SESSION['login']==1){	
	if(!$Func->CekLogin()){
		$_SESSION['login'] = 0;
	}
}
*/


$pcreated_by=!EMPTY($pcreated_by)?$pcreated_by:$sUserId;
$pupdated_by=!EMPTY($pupdated_by)?$pupdated_by:$sUserId;
$pcreated_date=$TANGGAL_AKSES;
$pupdated_date=$TANGGAL_AKSES;
$DisKantor="";
if(!empty($sKdKantor)){$KDKANTOR=$sKdKantor;$DisKantor="style='display:none;'";}

if($_SESSION['login']==0){
  header('location:logout.php');
}
else
{
	
	$Main->SearchData="";
	$Main->Isi = "";
	$Main->Atas="<br>";	
	if (empty($_SESSION['sUserHak'])){header("Location:{$Url->BaseMain}");}
	
	include($Dir->Pages."/tampilan/menuadmin.inc.php");	
	
	switch ($sUserHak)
	{			
		case "2":
			$url=trim($Main->Part);
			
			$jnskotak=!empty($jnskotak)?$jnskotak:1;
			$MaxMenu=count($ArrMenuPer);
			$JArrMenu=1;
			while($MaxMenu>=$JArrMenu) {
		
				if($url==@$ArrMenuPer[$JArrMenu-1][2]){
					$JArrMenu=$MaxMenu;
					if (file_exists("{$Dir->ModAdmin}{$Main->Part}.inc.php")) {
					   include("{$Dir->ModAdmin}{$Main->Part}.inc.php");
					   if(empty($Mode)||$Mode=="Lihat"){
						   if(!empty($TipeAksi)){
						   include "{$Dir->ModAdmin}blank/blank.inc.php";
						   }else{

								$noborder=@$Isi['id_sub']=='69'?'y':"n";

								if($noborder=='y'){
									$Main->Isi=$Main->Isi;
								}else{
									if(!empty($Main->Isi)){
										$Main->Isi = $Func->Kotak($Main->MenuHeader,$Main->Isi,'100%',$jnskotak, $MainJudul);	
									}
									
								}
							
						   }
						   
						   
					   }else{
							$ListMode="";$i=1;$Main->Isi="";$MJudul='';
							include "{$Dir->ModAdmin}{$Pr}/{$Mode}.inc.php";
							
						}

					} else {

						$Main->Isi = $Func->Kotak("Perhatian","<font size=5 color=red><br>Maaf, Halaman ini belum tersedia.<br>Silahkan hubungi administrator anda</font>",'100%');
					}
				}else{
					include("{$Dir->ModAdmin}beranda.inc.php");		
				}

				$JArrMenu++;
		   }
		break;
		case "1":
			$url=trim($Main->Part);
			
			$jnskotak=!empty($jnskotak)?$jnskotak:1;
			$MaxMenu=count($ArrMenuAdm);
			$JArrMenu=1;
			while($MaxMenu>=$JArrMenu) {
		
				if($url==@$ArrMenuAdm[$JArrMenu-1][2]){
					$JArrMenu=$MaxMenu;
					if (file_exists("{$Dir->ModAdmin}{$Main->Part}.inc.php")) {
					   include("{$Dir->ModAdmin}{$Main->Part}.inc.php");
					   if(empty($Mode)||$Mode=="Lihat"){
						   if(!empty($TipeAksi)){
						   include "{$Dir->ModAdmin}blank/blank.inc.php";
						   }else{

								$noborder=@$Isi['id_sub']=='69'?'y':"n";

								if($noborder=='y'){
									$Main->Isi=$Main->Isi;
								}else{
									if(!empty($Main->Isi)){
										$Main->Isi = $Func->Kotak($Main->MenuHeader,$Main->Isi,'100%',$jnskotak, $MainJudul);	
									}
									
								}
							
						   }
						   
						   
					   }else{
							$ListMode="";$i=1;$Main->Isi="";$MJudul='';
							include "{$Dir->ModAdmin}{$Pr}/{$Mode}.inc.php";
							
						}

					} else {

						$Main->Isi = $Func->Kotak("Perhatian","<font size=5 color=red><br>Maaf, Halaman ini belum tersedia.<br>Silahkan hubungi administrator anda</font>",'100%');
					}
				}else{
					include("{$Dir->ModAdmin}beranda.inc.php");		
				}

				$JArrMenu++;
		   }
		break;
	}	
}

if($ActionJson=="GetJson"){
	include("{$Dir->ModAdmin}{$Pr}/json_mbarang.inc.php");
}
?>