<?php
@session_start();
$Func->ambilData("select folder from __t_templates where judul='baru'");
$Main->Tema= $folder;
$Show = $Func->gFile("{$Main->Tema}/baseexcel.html");
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

	$tipe_check=!empty($tipe_check)?$tipe_check:2;
	$Main->Isi = "";
	$Main->Atas="<br>";	
	//include($Dir->Pages."/tampilan/menuadmin.inc.php");	
	$Main->Part=$uri->segment[2+$Main->SegmentId];
	$Mode=@$uri->segment[3+$Main->SegmentId];
	switch ($Main->Part)
	{				
		case "ganti_password":
			include("{$Dir->ModCetak}ganti_password.inc.php");
		break;			
		case "":default:			
			$url=trim($Main->Part);
			$QLinkAdm=_mysql_query("SELECT a.id_sub, a.link_sub, a.nama_sub from __t_submenu AS a INNER JOIN __t_hak_akses AS b ON a.id_sub=b.id_sub WHERE b.idgroupakses='{$sUserHak}' AND a.link_sub='{$url}'");		
			$Isi=_mysql_fetch_array($QLinkAdm);
			$Func->ambilData("SELECT pinsert as vpinsert, pupdate as vpupdate, pdelete as vpdelete from __t_hak_akses WHERE idgroupakses='{$sUserHak}' AND id_sub='".@$Isi['id_sub']."'");
			$Main->MenuHeader=@$Isi['nama_sub'];
			$Main->MInsert=$vpinsert;
			$Main->MUpdate=$vpupdate;
			$Main->MDelete=$vpdelete;

			if(_mysql_num_rows($QLinkAdm)>0)
			{				
				if (file_exists("{$Dir->ModCetak}{$Main->Part}.inc.php")) {
				   include("{$Dir->ModCetak}{$Main->Part}.inc.php");
				   if(empty($Mode)||$Mode=="Lihat"){
					   if(!empty($TipeAksi)){
					   include "{$Dir->ModCetak}blank/blank.inc.php";
					   }else{
							$noborder=@$Isi['id_sub']=='69'?'y':"n";
							$Main->Isi=$Main->Isi;						
					   }				   
				   }else{
						$ListMode="";$i=1;$Main->Isi="";$MJudul='';
						include "{$Dir->ModCetak}{$Pr}/{$Mode}.inc.php";
						$MJudul=!empty($MJudul)?$MJudul:strtoupper(str_replace('_',' ',$Mode));
						$MJudul=!empty($TMenuHeader)?$TMenuHeader:$MJudul;						
					}
				}else{
					$Main->Isi = $Func->Kotak("Perhatian","<font size=5 color=red><br>Maaf, Halaman ini belum tersedia.<br>Silahkan hubungi administrator anda</font>",'100%');
				}
			}
			else
			{
				$cekprint=substr($Main->Part,0,5);			
				if($cekprint=='print'){
					if (file_exists("{$Dir->ModCetak}{$Main->Part}.inc.php")) {

						include("{$Dir->ModCetak}{$Main->Part}.inc.php");
						$Judul=strtoupper(str_replace('_',' ',$Main->Part));
						$Main->Cetak=$Main->Isi;
						$Main->Isi = $Main->Isi;
					}
				}
					
				if(empty($Main->Isi)){
					$BulanStat=!empty($BulanStat)?$BulanStat:date('m');
					$Main->Isi="				
					Selamat datang di halaman member . Silahkan klik menu pilihan yang berada di bagian atas untuk mengelola data. 
					".$Func->TglAll(date('Y-m-d')).", ".date('h:i:s')." Wib<hr>
					";					
					$Main->Isi = $Func->Kotak("Halaman Utama",$Main->Isi,'85%');	
				}
				
			}
				
		break;
	}	

?>