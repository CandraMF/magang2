<?php
	include($Dir->Library."/library.inc.php");
include($Dir->Pages."/tampilan/menu.inc.php");
$Show = $Func->gFile("{$Main->Tema}/base.inc.php");
if ($_GET){foreach($_GET as $key => $value){$$key = $Func->antiinjection($value);}}
if ($_POST){foreach($_POST as $key => $value){$$key = $Func->antiinjection($value);}}
if ($_SESSION){foreach($_SESSION as $key => $value){$$key = $Func->antiinjection($value);}}
if ($_COOKIE){foreach($_COOKIE as $key => $value){$$key = $Func->antiinjection($value);}}


$Tema=$Main->Tema;
/// templates Administrator

if(!empty($sUserId)){
	$Pg=$Func->decrypt(@$uri->segment[1+$Main->SegmentId], ENCRYPTION_KEY);

	$Pr=$Func->decrypt(@$uri->segment[2+$Main->SegmentId], ENCRYPTION_KEY);
	$Mode=$Func->decrypt(@$uri->segment[3+$Main->SegmentId], ENCRYPTION_KEY);
	$REQUEST_URI=$_SERVER['REQUEST_URI'];
	$strpos=strpos($REQUEST_URI,"pagehal-");
	
	$Mode=empty($strpos)?$Mode:"";

	if(!empty($Mode)){
		$Aksi=!empty($Aksi)?$Aksi:$Func->decrypt(@$uri->segment[4+$Main->SegmentId], ENCRYPTION_KEY);
		$idPop=!empty($idPop)?$idPop:$Func->decrypt(@$uri->segment[5+$Main->SegmentId], ENCRYPTION_KEY);
		$idPopSub=!empty($idPopSub)?$idPopSub:@$uri->segment[6+$Main->SegmentId];

		$idPop=!empty($idPop)?$idPop:0;
		$idPopSub=!empty($idPopSub)?$idPopSub:0;
	}
}else{
	if(@$uri->segment[1+$Main->SegmentId]=="failed"){
		$Main->Page="failed";
	}else{
		$Pg=!empty($Pg)?$Pg:"";
		$Pr=!empty($Pr)?$Pr:"";
	}
	
}

if (($Pg=="login") && empty($sUserId))
{	

	$uToken= trim($Func->antiinjection(@$_POST['uToken']));
	
	if (!$uToken || $uToken !== $_SESSION['token']) {
		
		header("Location:".$Url->BaseUrl."index.php/notfound");
		
	}else{
		$Func->Login();
		
	}
}
global $sUserId,$sUserHak,$sUserNm;
$sUserHak=!empty($sUserHak)?$sUserHak:"";
$sUserId=!empty($sUserId)?$sUserId:"";
$sUserNm=!empty($sUserNm)?$sUserNm:"";
$sUserHak = isset($_SESSION['sUserHak'])?$_SESSION['sUserHak']:$sUserHak;
$sUserId = isset($_SESSION['sUserId'])?$_SESSION['sUserId']:$sUserId;
$sUserNm = isset($_SESSION['sUserNm'])?$_SESSION['sUserNm']:$sUserNm;

if (@$uri->segment[1+$Main->SegmentId]=="logOut")
{
	

	$sUserId="";$sUserNm="";$sUserHak="";$uLogin="";$pLogin="";
	unset($_SESSION['sUserId']);
	session_destroy();
	$Pg="";$Pr="";$Main->Page="";$Main->Part="";

//	echo "<script>parent.location='".$Url->BaseUrl."index.php';</scipt>";
	header("Location:".$Url->BaseUrl);
}

if (!$Func->CekLogin())
{$HomeAdmin="";}
else
{
	if (empty($Pg))
	{$Pg = "login";}
	$Main->Page=$Pg;
	$Main->Part=$Pr;
}
$PrmBaru=@$uri->segment[1+@$Main->SegmentId];
if($PrmBaru=="login"){
	$Main->Page=$Main->Page;
}else{
	$Main->Page=$Main->Page;
}
if(empty($sUserId)){
switch ($PrmBaru)
{
	case "login":
		$Main->Page=$Main->Page;
	break;
	case "logOut":
		$Main->Page=$Main->Page;
	break;
	default:
		$Main->Page=$PrmBaru;
}
}
switch ($Main->Page)
{		
		case "home":	
			include($Dir->Pages."/home.inc.php");		
		break;
		case "prosedur":	
			include($Dir->Pages."/prosedur.inc.php");		
		break;
		case "daftar":	
			include($Dir->Pages."/daftar.inc.php");		
		break;
		case "masuk":	
			include($Dir->Pages."/masuk.inc.php");		
		break;
		
		case "login":	
			include($Dir->Pages."/login.inc.php");		
		break;
		case "failed":	
			$Show="";
			include("templates/login/failed.inc.php");		
		break;
		default:
			$SegmentId=@$uri->segment[1+$Main->SegmentId];
	
			if(!empty($SegmentId)){
				$Show="";
				include("templates/login/notfound.inc.php");		
			}else{
				include($Dir->Pages."/home.inc.php");		
			}
}

$TanggalInfo=$Func->TglHari($Waktu);

$display_verif=!empty($display_verif)?$display_verif:"";
$display_verif_list=!empty($display_verif_list)?$display_verif_list:"";
$Show = str_replace("<!--display_verif-->","$display_verif",$Show);
$Show = str_replace("<!--display_verif_list-->","$display_verif_list",$Show);
$Show = str_replace("<!--JudulApp-->","$Main->JudulApp",$Show);
$Show = str_replace("<!--desaintema-->","$Tema",$Show);
$Show = str_replace("<!--MainJudul-->","$Main->MainJudul",$Show);
$Show = str_replace("<!--Judul-->","$Main->Judul",$Show);
$Show = str_replace("<!--JavaScript-->","$Main->Script",$Show);
$Show = str_replace("<!--JavaScript2-->","$Main->Script2",$Show);
$Show = str_replace("<!--Css-->","$Main->Css",$Show);
$Show = str_replace("<!--Atas-->","$Main->Atas",$Show);
$Show = str_replace("<!--Menu-->","$Main->Menu",$Show);
$Show = str_replace("<!--MenuAtas-->","$Main->MenuAtas",$Show);
$Show = str_replace("<!--MenuAdmin-->","$Main->MenuAdmin",$Show);
$Show = str_replace("<!--HeadIsi-->","$Main->HeadIsi",$Show);
$Show = str_replace("<!--Isi-->","$Main->Isi",$Show);
$Show = str_replace("<!--SearchData-->","$Main->SearchData",$Show);
$Show = str_replace("<!--BottomIsi-->","$Main->BottomIsi",$Show);
$Show = str_replace("<!--Cetak-->","$Main->Cetak",$Show);
$Show = str_replace("<!--Bawah-->","$Main->Bawah",$Show);
$Show = str_replace("<!--ParamBulan-->","$Main->Param",$Show);


$Show = str_replace("<!--Bawah-->","$Main->Bawah",$Show);
$Show = str_replace("<!--TanggalInfo-->","$TanggalInfo",$Show);
$Show = str_replace("<!--sUserNm-->","$sUserNm",$Show);
$Show = str_replace("{--utoken--}",@$_SESSION['token'],$Show);
$Show = str_replace("{BaseUrl}",$Url->BaseUrl,$Show);
$Show = str_replace("{BaseMain}",$Url->BaseMain,$Show);
$Show = str_replace("	", "", $Show);
$proses_json=!empty($proses_json)?$proses_json:"";
if(!empty($proses_json)){
	if(empty($tipe_json)){
		header('Content-type:application/json;charset=utf-8');
	}
	
	$CREATED_BY=$sUserId;
	$UPDATED_BY=$sUserId;
	$TANGGAL_AKSES= date("Y-m-d h:i:s");
	$CREATED_DATE=$TANGGAL_AKSES;
	$UPDATED_DATE=$TANGGAL_AKSES;
	$DATE_CREATED=$TANGGAL_AKSES;
	$DATE_UPDATED=$TANGGAL_AKSES;
	$Main->Page=$Pg;
	$Main->Part=$Pr;
	switch ($Main->Page)
	{
		case "Login":	
			
			if (file_exists("{$Dir->Proses}{$Main->Part}.inc.php")) {
				include "{$Dir->Proses}{$Main->Part}.inc.php";
			}
		break;
	}
}else{
	echo trim($Show);
}

?>