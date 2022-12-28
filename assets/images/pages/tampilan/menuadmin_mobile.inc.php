<?php
$MenuAtas ="";
$val_id_sub =!empty($val_id_sub)?$val_id_sub:"";
$val_id_main =!empty($val_id_main)?$val_id_main:"";
$MenuAtas ="";
if(!empty($Pr)){
	$Func->ambilData("select id_sub as val_id_sub , id_main as val_id_main  from __t_submenu where link_sub='".trim($Pr)."'");
}

	$LMenuAtas="";
	$link="";

	$QMenu=_mysql_query("SELECT b.nama_menu, b.link, a.id_main, b.urutan from __t_hak_akses AS a INNER JOIN __t_mainmenu AS b ON a.id_main=b.id_main WHERE a.idgroupakses='{$sUserHak}' AND b.membermenu='Y' and a.aktif='Y' group by b.nama_menu, b.link, a.id_main, b.urutan order BY b.urutan");
	while($topM=_mysql_fetch_array($QMenu)){
		$IdMain=strtolower($topM['nama_menu']);
		$IdMain=str_replace(" ","",$IdMain);
		$LSpan="";$LDiv="";
		$QDiv=_mysql_query("SELECT  b.nama_sub, b.link_sub, b.id_sub, b.urutan_submenu from __t_hak_akses AS a INNER JOIN __t_submenu AS b ON a.id_sub=b.id_sub WHERE a.idgroupakses='{$sUserHak}' AND a.id_main='{$topM['id_main']}' AND  b.aktif='Y' and a.aktif='Y' AND b.id_submain='0' group by b.nama_sub, b.link_sub, b.id_sub, b.urutan_submenu order BY b.urutan_submenu");
		while($tDiv=_mysql_fetch_array($QDiv)){
			$IdSubMain=strtolower($tDiv['nama_sub']);
			$IdSubMain=str_replace(" ","",$IdSubMain);
			$SubTogle="";$SubLDiv="";
			if($tDiv['link_sub']=="#"){
				$SubLSpan="";$SubLDiv="";
				$SubQDiv=_mysql_query("SELECT b.nama_sub, b.link_sub, b.id_sub, b.urutan_submenu from __t_hak_akses AS a INNER JOIN __t_submenu AS b ON a.id_sub=b.id_sub WHERE a.idgroupakses='{$sUserHak}' AND a.id_main='{$topM['id_main']}' AND  b.aktif='Y' and a.aktif='Y' AND b.id_submain='".$tDiv['id_sub']."' group by b.nama_sub, b.link_sub, b.id_sub, b.urutan_submenu order BY b.urutan_submenu");
				while($SubtDiv=_mysql_fetch_array($SubQDiv))
				{
					$SubLDiv.="
						<li class='nav-item' onclick=\"parent.location='{$Url->BaseMain}/".$Func->encrypt($Pg, ENCRYPTION_KEY)."/".$Func->encrypt($SubtDiv['link_sub'], ENCRYPTION_KEY)."';\">
							
							<a href='#sub_sidebar".$IdSubMain."' class='nav-link' data-key='t_".$IdSubMain."'> {$SubtDiv['nama_sub']} </a>
						</li>
					";
				}
				$SubLDiv="
					<div class='collapse menu-dropdown' id='sub_sidebar".$IdSubMain."'>
						<ul class='nav nav-sm flex-column'>
							".$SubLDiv."
						</ul>
					</div>
				";
				$SubTogle=" data-bs-toggle='collapse' role='button' aria-expanded='false' aria-controls='sub_sidebar".$IdSubMain."'";
			}
			//
			$LDiv.="
				<li class='nav-item'>
					<a href='#sub_sidebar".$IdSubMain."' class='nav-link' ".$SubTogle." data-key='t_{$tDiv['link_sub']}' onclick=\"parent.location='{$Url->BaseMain}/".$Func->encrypt($Pg, ENCRYPTION_KEY)."/".$Func->encrypt($tDiv['link_sub'], ENCRYPTION_KEY)."';\"> {$tDiv['nama_sub']} </a>
					".$SubLDiv."
				</li>
			";
		}
		$LSpan.=$LDiv;
		
		$ToggleMain="";$DivMain="";
		if($topM['link']=="#"){
			$ToggleMain="data-bs-toggle='collapse' role='button' aria-expanded='false' aria-controls='sidebar".$IdMain."'";
			$DivMain="
				<div class='collapse menu-dropdown' id='sidebar".$IdMain."'>
					<ul class='nav nav-sm flex-column'>
						".$LDiv."
					</ul>
				</div>
			";
			
		}
		
		if($topM['link']=="#"){
			$LinkHref="#sidebar".$IdMain."";
		}else{
			$LinkHref=$topM['link'];
		}
		
		$LMenuAtas.="		
		<li class='nav-item'>
			<a class='nav-link menu-link' href='".$LinkHref."' ".$ToggleMain." >
				<i class='bx bxs-dashboard'></i> <span data-key='t-dashboards'>".$topM['nama_menu']."</span>
			</a>
			".$DivMain."
		</li> 

		";
	}

	$MenuAtas="
		 <ul class='navbar-nav' id='navbar-nav' data-simplebar='init'>
			<li class='menu-title'><span data-key='t-menu'>Menu</span></li>
			<li class='nav-item'>
				<a class='nav-link menu-link' href='".$Url->BaseMain."'>
					<i class='bx bxs-dashboard'></i> <span data-key='t-dashboards'>Dashboards</span>
				</a>
			   
			</li>
            ".$LMenuAtas."    
         </ul>
	";

	$Main->MenuAtas=$Func->KotakHeader("",$MenuAtas,"100%","50");
?>