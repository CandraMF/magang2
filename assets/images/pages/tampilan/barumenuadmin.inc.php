<?php
$MenuAtas ="";

if ($sUserHak=="1" || $sUserHak=="2")
{	$LMenuAtas="";
	$link="";
	$QMenu=_mysql_query("select nama_menu, link, id_main from __v_menu where username='$sUserId' and membermenu='Y' group by link order by id_main");
	while($topM=_mysql_fetch_array($QMenu))
	{	$LSpan="";
		$QSpan=_mysql_query("select keterangan from __v_menu where username='$sUserId' and id_main='{$topM['id_main']}' and aktif='Y' group by keterangan order by id_sub");
		while($tSpan=_mysql_fetch_array($QSpan))
		{	$LDiv="";
			$QDiv=_mysql_query("select nama_sub, link_sub from __v_menu where username='$sUserId' and id_main='{$topM['id_main']}' and keterangan='{$tSpan['keterangan']}' and aktif='Y' order by id_sub");
			while($tDiv=_mysql_fetch_array($QDiv))
			{
				$LDiv.="<li  onclick=\"parent.location='{$tDiv['link_sub']}{$topM['link']}';\"><a href='#'>{$tDiv['nama_sub']}</a></li>";
			}
			$LSpan.=$LDiv;
		}
		$LMenuAtas.="
		<li >
			<a href='#' data-toggle='dropdown' class='dropdown-toggle'>
				<span>{$topM['nama_menu']}</span>
				<span class='caret'></span>
			</a>
			<ul class='dropdown-menu'>$LSpan</ul>
		</li>";
	}

	$MenuAtas=$LMenuAtas;
}	
	$Main->MenuAtas=$MenuAtas;
?>