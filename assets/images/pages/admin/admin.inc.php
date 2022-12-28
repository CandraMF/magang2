<?php
@session_start();
$Func->ambilData("select folder from __t_templates where judul='baru'");
$Main->Tema= $folder;
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
	$ipaddress=$Func->get_client_ip();
	$link_url="{$Url->BaseMain}/{$Pg}/{$Pr}/".@$Mode."/".@$Aksi."/".@$idPop."/".@$idPopSub;
	$link_url=str_replace("///","",$link_url);
	$link_url=str_replace("//","",$link_url);
	$link_url=str_replace("http:","http://",$link_url);
	if($Pr!='assets'){
		if (stripos($link_url, "choicesjs") !== false) {
		}else{
			if (stripos($link_url, "flatpickr") !== false) {
			}else{
				_mysql_query("INSERT INTO __log_server (ipaddress, username, link_url, link_sub, waktu) VALUES ('".$ipaddress."', '".$sUserId."', '".$link_url."', '".$Pr."','".$TANGGAL_AKSES."');");
			}
			
		}
		
		
		
	}
	

	$Main->SearchData="
		<input type='text' name='cari_kamus' id='cari_kamus'  class='form-control' placeholder='Pencarian Kamus Hukum...' autocomplete='off'>
		<script>auto_kamus('#cari_kamus','#FmCari', '{$Url->BaseMain}/{$Pg}/kamus_data');</script>
	";
	$Main->Isi = "";
	$Main->Atas="<br>";	
	if (empty($_SESSION['sUserHak'])){header("Location:{$Url->BaseMain}");}
	
	if($ScreenWidth<=720){
		include($Dir->Pages."/tampilan/menuadmin_mobile.inc.php");	
	}else{
		include($Dir->Pages."/tampilan/menuadmin.inc.php");	
	}

	switch ($Main->Part)
	{				
		case "ganti_password":
			include("{$Dir->ModAdmin}ganti_password.inc.php");
		break;	
		case "kamus_data":
			include("{$Dir->ModAdmin}kamus_data.inc.php");
		break;	
		case "setting_bulan":
			include("{$Dir->ModAdmin}setting_bulan.inc.php");
			$ListMode="";$i=1;$Main->Isi="";$MJudul='';
			$Mode="detail";
			include "{$Dir->ModAdmin}{$Pr}/{$Mode}.inc.php";

			$Main->Isi = $Func->KotakPopUp("Seting Parameter Bulan Dan Tahun",$Main->Isi,'100%');
		break;	
		case "":default:
			$url=trim($Main->Part);
			$QLinkAdm=_mysql_query("SELECT a.id_sub, a.link_sub, a.nama_sub, a.jnskotak, c.nama_menu, d.nama_sub as nama_sub_main from __t_submenu AS a INNER JOIN __t_hak_akses AS b ON a.id_sub=b.id_sub inner join __t_mainmenu as c on a.id_main=c.id_main left join __t_submenu as d on d.id_submain=a.id_sub WHERE b.idgroupakses='{$sUserHak}' AND a.link_sub='{$url}'");			
			$Isi=_mysql_fetch_array($QLinkAdm);

			$Func->ambilData("SELECT pinsert as vpinsert, pupdate as vpupdate, pdelete as vpdelete from __t_hak_akses WHERE idgroupakses='{$sUserHak}' AND id_sub='".floatval(@$Isi['id_sub'])."'");

			$Main->MenuHeader=@$Isi['nama_sub'];


			$JudulSubMain=!empty($Isi['nama_sub_main'])?"<li class='breadcrumb-item'><a href='javascript: void(0);'>".@$Isi['nama_sub_main']."</a></li>":"";
			$jnskotak=floatval(@$Isi['jnskotak']);
			$MainJudul="<li class='breadcrumb-item'><a href='javascript: void(0);'>".@$Isi['nama_menu']."</a></li>
						".$JudulSubMain."
						<li class='breadcrumb-item active'>".$Main->MenuHeader."</li>";



			$Main->MInsert=$vpinsert;
			$Main->MUpdate=$vpupdate;
			$Main->MDelete=$vpdelete;

			if(_mysql_num_rows($QLinkAdm)>0)
			{				
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
						$MJudul=!empty($MJudul)?$MJudul:strtoupper(str_replace('_',' ',$Mode));
						$MJudul=!empty($TMenuHeader)?$TMenuHeader:$MJudul;
						$MJudul=$MJudul=="DETAIL"?"{$Main->MenuHeader}":$MJudul;
						if(empty($Main->BottomIsi)){
							$Main->Isi = $Func->KotakPopUp($MJudul,$Main->Isi,'100%');
						}
					}

				} else {

					$Main->Isi = $Func->Kotak("Perhatian","<font size=5 color=red><br>Maaf, Halaman ini belum tersedia.<br>Silahkan hubungi administrator anda</font>",'100%');
				}
			}
			else
			{
				$cekprint=substr($Main->Part,0,5);
			
				if($cekprint=='print'){
					
					if (file_exists("{$Dir->ModAdmin}{$Main->Part}.inc.php")) {

						include("{$Dir->ModAdmin}{$Main->Part}.inc.php");
						$Judul=strtoupper(str_replace('_',' ',$Main->Part));
						$Main->Cetak=$Main->Isi;
						$Main->Isi = $Func->Kotak($Judul,$Main->Isi,'100%');
					}
				}
					
				if(empty($Main->Isi)){
					
					include("{$Dir->ModAdmin}beranda.inc.php");				
						
				}
				
			}
				
		break;
	}	
}

if($ActionJson=="GetJson"){
	include("{$Dir->ModAdmin}{$Pr}/json_mbarang.inc.php");
}
?>