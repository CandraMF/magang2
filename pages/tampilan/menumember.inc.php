<?php

if ($sUserHak=="2")
{
	$Main->MenuAtas="
	<div id='smoothmenu1' class='ddsmoothmenu'>
		<ul>
			<li><a href='#'>&nbsp;</a>
			  <ul>
				<li><a href='index.php?Pg=LogOut'>Keluar</a></li>
				<li><a href=\"javascript:ambilData('#isi','index.php?Pg=$Pg&Pr=gpwd')\">Ganti Password</a></li>
				<li><a href=\"javascript:ambilData('#isi','index.php?Pg=$Pg&Pr=editbiodata')\">Biodata</a></li>
			  </ul>
			</li>
			
			
			<li><a href='index.php'>Beranda</a></li>			
		</ul>
		<br style='clear: left' />
	</div>
	
	";
	
	$JudulMenu="";
	$Qry=_mysql_query("select a.kd_hak_akses, b.nm_hak_akses from t_hak_akses as a inner join r_hak_akses as b on a.kd_hak_akses = b.kd_hak_akses where a.username='{$_SESSION['sUserId']}'");
	while($Isi=_mysql_fetch_array($Qry))
	{
		$MenuUtama="";
		$QryMenu=_mysql_query("select c.id_main, c.nama_menu, c.link from r_hak_akses_detail as a inner join t_submenu as b on a.id_menu=b.id_sub inner join t_mainmenu as c on b.id_main = c.id_main where b.aktif ='Y' and c.membermenu ='Y' and a.kd_hak_akses ='{$Isi['kd_hak_akses']}'  group by c.id_main order by c.id_main");
		$i=1;
		while($IsiMenu=_mysql_fetch_array($QryMenu))
		{	
			$SubMenu="";
			$QrySubMenu=_mysql_query("select b.nama_sub, b.link_sub from r_hak_akses_detail as a inner join t_submenu as b on a.id_menu=b.id_sub inner join t_mainmenu as c on b.id_main = c.id_main where b.aktif ='Y' and c.membermenu ='Y' and a.kd_hak_akses ='{$Isi['kd_hak_akses']}' and c.id_main ='{$IsiMenu['id_main']}' group by b.id_sub");
			if(_mysql_num_rows($QrySubMenu)>0)
			{
				while($IsiSub=_mysql_fetch_array($QrySubMenu))
				{
					$SubMenu.="<li><a href=\"{$IsiSub['link_sub']}\">{$IsiSub['nama_sub']}</a></li>";
				}
				$SubMenu="<ul>$SubMenu</ul>";
			}
			$MenuUtama.="<li><a href=\"{$IsiMenu['link']}\">{$IsiMenu['nama_menu']}</a>$SubMenu</li>";
			$i++;			
		}
		$JudulMenu.="<li style='color:#666666;font-weight:bold;padding:5px;text-align:left;background:#F2F2F2;border-top:1px solid #E2E2E2;margin-top:2px;'>".ucwords(strtolower("GROUP {$Isi['nm_hak_akses']}"))."</li>$MenuUtama";

	}
	$Main->Menu="	
	<table width='210'>
	<tr>
		<td height='60'><img src='{$Dir->Images}/no_photo.jpg' height='60' STYLE='background-color: #fff;padding: 2px;margin: 3px 5px 3px 0;border: 1px solid #CCC;'></td>
		<td width='150' valign=top style='padding-top:10px;color:#3B5998;font-weight:bold;'>$sUserNm</td>
	</tr>
	</table>
	<br>
	<div id='smoothmenu2' class='ddsmoothmenu-v'>
	<ul>
		$JudulMenu
	<!-- <li><a href='#'>Informasi</a>
	  <ul>
	  <li><a href='#'>Berita Umum</a></li>
	  <li><a href='#'>Berita Intern</a></li>
	  <li><a href='#'>Surat Edaran</a></li>
	  <li><a href='#'>Berbagi Dokumen</a></li>
	  <li><a href='#'>Kirim File</a></li>
	  <li><a href='#'>Lihat Draft File</a></li>
	  <li><a href='#'>Forum</a></li>
	  </ul>
	</li>
	<li><a href='#'>LHB Tengah Semester</a>
	  <ul>
	  <li><a href='#'>Import LHB Tengah Semester</a></li>
	  <li><a href='#'>Entry LHB Tengah Semester</a></li>
	  <li><a href='#'>Cetak LHB Tengah Semester</a></li>
	  </ul>
	</li>
	<li><a href='#'>LHB Akhir Semester</a>
	  <ul>
	  <li><a href='#'>Import LHB Akhir Semester</a></li>
	  <li><a href='#'>Entry LHB Akhir Semester</a></li>
	  <li><a href='#'>Cetak LHB Akhir Semester</a></li>
	  </ul>
	</li>
	<li><a href='#'>Silabus</a>
	  <ul>
	  <li><a href='#'>Standar Kompetensi</a></li>
	  <li><a href='#'>Kompetensi Dasar</a></li>
	  <li><a href='#'>Indikator Pencapaian</a></li>
	  </ul>
	</li>
	<li><a href='#'>Proses Pembelajaran</a>
	  <ul>
	  <li><a href='#'>Materi Pembelajaran</a></li>
	  <li><a href='#'>Penugasan</a></li>
	  <li><a href='#'>Evaluasi Pembelajaran</a></li>
	  </ul>
	</li>
	<li><a href='#'>Accesories</a>
	  <ul>
	  <li><a href='#'>Kotak Saran</a></li>
	  <li><a href='#'>Artikel</a></li>
	  <li><a href='#'>Download Aplikasi</a></li>
	  <li><a href='#'>Hiburan</a></li>
	  </ul>
	</li> -->
	</ul>
	<br style='clear: right' />
	</div>
	<img src='{$Dir->Images}/obrolan.gif'>
	";
}

?>