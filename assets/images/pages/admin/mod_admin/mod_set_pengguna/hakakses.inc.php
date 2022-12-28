<?php
			$Show = $Func->gFile("{$Main->Tema}/kosong.html");
			
			$ListMode="";$i=1;$Pesan="";
			$Aksi=!empty($Aksi)?$Aksi:"";
			$idgroupakses=!empty($idgroupakses)?$idgroupakses:$idPop;
			$kd_hak_akses=!empty($kd_hak_akses)?$kd_hak_akses:"";

			switch($Aksi)
			{
				case "Simpan";
					foreach ($id_sub as $k=>$v) {						
						
						
						if($aktif[$k]=="Y")
						{
							
							$Qry=_mysql_query("select * from __t_hak_akses where idgroupakses='$idPop' and id_sub='$id_sub[$k]'");
							if(!_mysql_num_rows($Qry))
							{
							
								$QSimpan="INSERT INTO __t_hak_akses (idgroupakses, id_main, id_sub, aktif, pinsert, pupdate, pdelete) VALUES ('$idPop', '$id_main[$k]', '$id_sub[$k]', '{$aktif[$k]}', '$pinsert[$k]','$pupdate[$k]','$pdelete[$k]');";
								
								$Simpan = _mysql_query($QSimpan) or  $Func->ViewPesan("Gagal di simpan, "._mysql_error(),0);
								$Pesan = $Simpan?$Func->ViewPesan("Sudah di simpan"):$Func->ViewPesan("Gagal di simpan, "._mysql_error(),0);	
							}else{
								
								$QSimpan="update __t_hak_akses set  id_main='{$id_main[$k]}', aktif='{$aktif[$k]}', pinsert='{$pinsert[$k]}', pupdate='{$pupdate[$k]}', pdelete='{$pdelete[$k]}' where idgroupakses='$idPop' and id_sub='$id_sub[$k]'";
							

								$Simpan = _mysql_query($QSimpan) or  $Func->ViewPesan("Gagal di simpan, "._mysql_error(),0);
								$Pesan = $Simpan?$Func->ViewPesan("Sudah di simpan"):$Func->ViewPesan("Gagal di simpan, "._mysql_error(),0);			
							}
						}						
						else
						{
							_mysql_query("DELETE FROM __t_hak_akses WHERE  idgroupakses='$idPop' AND id_sub='$id_sub[$k]'");	
						}
					}				
					
					echo "<script>setTimeout(function(){ Fm.submit(); }, 2000);</script>";		
				break;
			}

			$ListMode="";$i=1;$z=1;
			$Kdid_main="";
			
			$Qry=_mysql_query("select a.id_sub, a.id_main, c.nama_menu, a.nama_sub, b.aktif, b.pinsert,b.pupdate,b.pdelete from __t_submenu AS a INNER JOIN __t_mainmenu AS c ON a.id_main=c.id_main left join (select aktif, id_sub,pinsert,pupdate,pdelete from __t_hak_akses where idgroupakses='{$idPop}' ) as b on a.id_sub=b.id_sub where a.aktif='Y' and c.aktif='Y' order by a.id_main, a.urutan_submenu");
			while($Isi=_mysql_fetch_array($Qry))
			{
				
				if(empty($Kdid_main) || $Kdid_main!=$Isi['id_main'] ){
					$Kdid_main=$Isi['id_main'];$z=1;
					$ListMode.=" 
						<tr onmouseover=\"TG(this,'#FFCC33')\" onmouseout=\"TG(this,'$wh')\" > 
							<td colspan=6 style='background-color:#339900;font-weight:bold;color:white;'>{$Isi['nama_menu']}</td>
						</tr> 
					";
				}
				$aktif=$Isi['aktif']=='Y'?'Y':'N';
				$ListMode.="
					<tr onmouseover=\"TG(this,'#FFCC33')\" onmouseout=\"TG(this,'$wh')\">
						<td align=center>{$z}.</td>
						<td>{$Isi['nama_sub']}</td>
						
						<td align=center>".$Func->rdAktifAkses("aktif[$i-1]",$aktif)."</td>
						<td align=center style='display:none'>".$Func->rdAktifAkses("pinsert[$i-1]",$Isi['pinsert'])."</td>
						<td align=center style='display:none'>".$Func->rdAktifAkses("pupdate[$i-1]",$Isi['pupdate'])."</td>
						<td align=center style='display:none'>".$Func->rdAktifAkses("pdelete[$i-1]",$Isi['pdelete'])."</td>
						
						".$Func->txtField("id_sub[$i-1]",$Isi['id_sub'],'','','hidden')."
					</tr>
					".$Func->txtField("id_main[$i-1]",$Isi['id_main'],'','','hidden')."
				";$i++;$z++;
			}
			$Func->ambilData("select * from __t_users where idgroupakses='$idPop'");
			$Main->Isi="
				$Pesan
				
				<form name=Fm2 id=Fm2 method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$Mode}' enctype='multipart/form-data'>	
					<table class='tablesorter2' align=right>
					<tr>
						<td></td>
						<td align=right><button type='button' class='btn btn-success btn-label rounded-pill' onclick=\"Fm2.Aksi.value='Simpan';submitForm('#Fm2', '#faceboxisi', Fm2.action);\"><i class='ri-check-double-line label-icon align-middle rounded-pill fs-16 me-2'></i> Simpan</button></td>
					</tr>
					</table>
					<br><br>
					".$Func->txtField('idPop',$idPop,'','','hidden')."
					".$Func->txtField('Pr',$Pr,'','','hidden')."
					".$Func->txtField('Mode',$Mode,'','','hidden')."
					".$Func->txtField('Aksi',$Aksi,'','','hidden')."
					<br>
					<div class='tableFixHead'>
					<table class='table table-bordered' id='dyntable' width=100% cellpadding=1 cellspacing=0 align=center>
					<thead>
						<tr>
							<th width=10 class='head0 center' >No.</th>
							<th class='head0 center'>Menu</th>
							<th class='head0 center'>Akses</th>
							
							<th class='head0 center' style='display:none'>Insert</th>
							<th class='head0 center' style='display:none'>Update</th>
							<th class='head0 center' style='display:none'>Delete</th>
						
											
						</tr>
						</thead>
						<tbody>$ListMode</tbody>
					</table>
					</div>
				</form>

			";
			$Main->Isi = $Func->Kotak("Hak Akses Member",$Main->Isi,'100%');
?>