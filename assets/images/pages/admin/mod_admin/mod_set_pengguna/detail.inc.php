<?php
	$Show = $Func->gFile("{$Main->Tema}/kosong.html");	
	$TambahId=!empty($TambahId)?$TambahId:"";
	
	$KdUnit=!empty($KdUnit)?$KdUnit:'';
	$username=!empty($username)?$username:'';$iduser=!empty($iduser)?$iduser:'';$password=!empty($password)?$password:'';$nama_lengkap=!empty($nama_lengkap)?$nama_lengkap:'';$nomor_hp=!empty($nomor_hp)?$nomor_hp:'';$nomor_wa=!empty($nomor_wa)?$nomor_wa:'';$idgroupakses=!empty($idgroupakses)?$idgroupakses:'';$bagian=!empty($bagian)?$bagian:'';$blokir=!empty($blokir)?$blokir:'';$id_session=!empty($id_session)?$id_session:'';
  
	switch($Aksi)
	{
		case "Simpan";
			if(!empty($username)){
				$QTmp="select count(*) as jml from __t_users where username='{$idPop}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
				if(!empty($password)){
					
					$scrt="*&^~53r37";
					$pLogin= $Func->antiinjection(sha1($scrt.@$password.$scrt));
					$password=substr($Func->hex(addslashes($pLogin),82), 0, 31);	



					if ($jCount > 0){
						$Qry="UPDATE __t_users SET username='{$username}', password='{$password}', nama_lengkap='{$nama_lengkap}', nomor_hp='{$nomor_hp}', nomor_wa='{$nomor_wa}', idgroupakses='{$idgroupakses}',  blokir='{$blokir}' WHERE  username='{$idPop}';";
					}else{
						$Qry="INSERT INTO __t_users (username, password, nama_lengkap, nomor_hp, nomor_wa, idgroupakses, blokir) VALUES ('".htmlspecialchars($username)."', '".htmlspecialchars($password)."', '".htmlspecialchars($nama_lengkap)."', '".htmlspecialchars($nomor_hp)."', '".htmlspecialchars($nomor_wa)."', '".htmlspecialchars($idgroupakses)."', '".htmlspecialchars($blokir)."');";
					}
					
				}else{
					if ($jCount > 0){
						$Qry="UPDATE __t_users SET username='{$username}', nama_lengkap='{$nama_lengkap}', nomor_hp='{$nomor_hp}', nomor_wa='{$nomor_wa}', idgroupakses='{$idgroupakses}', blokir='{$blokir}' WHERE  username='{$idPop}';";
					}else{
						$scrt="*&^~53r37";
						$passwordsha1= $this->antiinjection(sha1($scrt.@$password.$scrt));
						$password=substr($this->hex(addslashes($passwordsha1),82), 0, 31);	

						$Qry="INSERT INTO __t_users (username, password, nama_lengkap, nomor_hp, nomor_wa, idgroupakses, blokir) VALUES ('".htmlspecialchars($username)."', '".htmlspecialchars($password)."', '".htmlspecialchars($nama_lengkap)."', '".htmlspecialchars($nomor_hp)."', '".htmlspecialchars($nomor_wa)."', '".htmlspecialchars($idgroupakses)."', '".htmlspecialchars($blokir)."');";
					}
				}
				
				$Simpan=_mysql_query( $Qry );
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				echo "<script>setTimeout(function(){ Fm.submit(); }, 2000);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from __t_users where username='".$idPop."'");
		break;
		case "Hapus":
			_mysql_query("delete from __t_users where username='".$idPop."'");
			$Func->kosongkanData("__t_users");
			echo "<script>Fm.submit();</script>";	
		break;
	}
	
	$Main->Isi="$Pesan	
		<form name=Fm2 id=Fm2 method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$Mode}' enctype='multipart/form-data'>
			
			<table border=0>
			<tr>
				<td style='border:0px;color:red;'>Username</td>
				<td>".$Func->txtField('username',$username,'50','50','text')."</td>
			</tr>
 			
 			<tr>
				<td>Password</td>
				<td>".$Func->txtField('password','','50','50','text')."</td>
			</tr>
 			<tr>
				<td>Nama Lengkap</td>
				<td>".$Func->txtField('nama_lengkap',$nama_lengkap,'50','50','text')."</td>
			</tr>
 			<tr>
				<td>Nomor HP</td>
				<td>".$Func->txtField('nomor_hp',$nomor_hp,'50','50','text')."</td>
			</tr>
 			<tr>
				<td>No Telp</td>
				<td>".$Func->txtField('nomor_wa',$nomor_wa,'50','50','text')."</td>
			</tr>
 			<tr>
				<td>Hak Akses</td>
				<td>".$Func->cmbQuery('idgroupakses',$idgroupakses,"SELECT * FROM __t_group_akses")."</td>
			</tr>
 		
			
 			<tr>
				<td>Blokir</td>
				<td>".$Func->cmbUmum('blokir',$blokir,array('Y','N'))."</td>
			</tr>
 	
 
			<tr>
				<td style='border:0px'></td>
				<td style='border:0px' align=right colspan='3'>
					<button type='button' class='btn btn-success btn-label rounded-pill' onclick=\"Fm2.Aksi.value='Simpan';submitForm('#Fm2', '#faceboxisi', Fm2.action);\"><i class='ri-check-double-line label-icon align-middle rounded-pill fs-16 me-2'></i> Simpan</button>
				</td>
			</tr>
			</table>
			".$Func->InfoUser($created_by,$created_date,$updated_by,$updated_date)."		
			".$Func->txtField('Mode',$Mode,'','','hidden')."
			".$Func->txtField('Aksi',$Aksi,'','','hidden')."
			".$Func->txtField('idPop',$idPop,'','','hidden')."
			".$Func->txtField('Pg',$Pg,'','','hidden')."
			".$Func->txtField('Pr',$Pr,'','','hidden')."
			".$Func->txtField('Sb',$Sb,'','','hidden')."
		</form>
	";
	if($Aksi!='Hapus'){
		$Main->Isi = $Func->Kotak($Main->MenuHeader,$Main->Isi,'100%');
	}else{
		$Main->Isi = $Func->Kotak($Main->MenuHeader,'<center><b>Melakukan Proses Hapus</b></center>','100%');
	}
?>