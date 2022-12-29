<?php
	$MainJudul="";
	$Main->MainJudul="Master Data";
	$Main->Judul="Data Daerah";
	$recruitment_id=$idPop;
	$Pesan="";
	$ParamAksi="";
	switch($Aksi)
	{
		case "Simpan";
			if(!empty($name)){
				$QTmp="select count(*) as jml from magang.person_tm where person_id='{$person_id}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	
				$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;			
				if ($jCount > 0)
				{	
					$Qry="UPDATE magang.person_tm SET title_pre='{$title_pre}', name='{$name}', title_post='{$title_post}', identity_id='{$identity_id}', tax_id='{$tax_id}', driving_a='{$driving_a}', driving_b='{$driving_b}', driving_c='{$driving_c}', birth_place='{$birth_place}', birth_date='{$birth_date}', religion_id='{$religion_id}', blood_type='{$blood_type}', marital_status_id='{$marital_status_id}', ethnicity_id='{$ethnicity_id}', email='{$email}', mobile='{$mobile}', mobile_alt='{$mobile_alt}', address='{$address}', region_id='{$region_id}', region='{$region}', region_id_home='{$region_id_home}', zip='{$zip}', address_home='{$address_home}', region_home='{$region_home}', zip_home='{$zip_home}' WHERE  person_id='{$person_id}';";}
				else
				{
					$Qry="INSERT INTO magang.person_tm (title_pre, name, title_post, identity_id, tax_id, driving_a, driving_b, driving_c, birth_place, birth_date, religion_id, blood_type, marital_status_id, ethnicity_id, email, mobile, mobile_alt, region_id, address, person_id, region, zip, address_home, person_id_home, region_home, zip_home, region_id_home) VALUES ('{$title_pre}', '{$name}', '{$title_post}', '{$identity_id}', '{$tax_id}', '{$driving_a}', '{$driving_b}', '{$driving_c}', '{$birth_place}', '{$birth_date}', '{$religion_id}', '{$blood_type}', '{$marital_status_id}', '{$ethnicity_id}', '{$email}', '{$mobile}', '{$mobile_alt}', '{$region_id}', '{$address}', '{$person_id}', '{$region}', '{$zip}', '{$address_home}', '{$person_id_home}', '{$region_home}', '{$zip_home}', '{$region_id_home}');";
				}
				
				$Simpan=_mysql_query( $Qry );
				
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				//echo "<script>setTimeout(function(){ Fm.Action.value='';Fm.submit(); }, 100);</script>";	
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
	
		
		case "baru":
			
			$Func->ambilData("select * from magang.person_tm where email='".$sUserId."'");
		break;
		default:
			if(empty($Action)){$Func->kosongkanData("magang.person_tm");}
	}

	$Func->ambilData("select * from magang.person_tm where email='".$sUserId."'");
	$Main->Isi = "
	<form name=Fm2 id=Fm2 method=post Aksi='{$Url->BaseMain}/{$Pg}/{$Pr}/{$Mode}' enctype='multipart/form-data'> 
	".$Func->txtField('Pr',$Pr,'','','hidden')." 
	".$Func->txtField('Mode',$Mode,'','','hidden')." 
	".$Func->txtField('Aksi',$Aksi,'','','hidden')." 
	".$Func->txtField('idPop',$idPop,'','','hidden')." 
	".$Func->txtField('idPopSub',$idPopSub,'','','hidden')." 
	".$Func->txtField('person_id',$person_id,'','','hidden')." 
		<div class='py-10'>
			<div class='card-header card-header-stretch'>
			
				<div class='card-toolbar'>
					<ul class='nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0'>
						<li class='nav-item' onclick=\"Fm.statusid.value='';Fm.Action.value='BknSimpan';Fm.submit();\">
							<a class='nav-link ' href='{$Url->BaseMain}/{$Pg}/{$Pr}/data_diri/baru'>Data Diri</a>
						</li>
						<li class='nav-item' onclick=\"Fm.statusid.value='';Fm.Action.value='BknSimpan';Fm.submit();\">
							<a class='nav-link ' href='{$Url->BaseMain}/{$Pg}/{$Pr}/pendidikan/baru'>Pendidikan</a>
						</li>
						<li class='nav-item' onclick=\"Fm.statusid.value='';Fm.Action.value='BknSimpan';Fm.submit();\">
							<a class='nav-link ' href='{$Url->BaseMain}/{$Pg}/{$Pr}/keluarga/baru'>Keluarga</a>
						</li>
						<li class='nav-item' onclick=\"Fm.statusid.value='';Fm.Action.value='BknSimpan';Fm.submit();\">
							<a class='nav-link ' href='{$Url->BaseMain}/{$Pg}/{$Pr}/pekerjaan/baru'>Pekerjaan</a>
						</li>
						<li class='nav-item' onclick=\"Fm.statusid.value='';Fm.Action.value='BknSimpan';Fm.submit();\">
							<a class='nav-link ' href='{$Url->BaseMain}/{$Pg}/{$Pr}/organisasi/baru'>Organisasi</a>
						</li>
						<li class='nav-item' onclick=\"Fm.statusid.value='';Fm.Action.value='BknSimpan';Fm.submit();\">
							<a class='nav-link active' href='{$Url->BaseMain}/{$Pg}/{$Pr}/berkas/baru'>Berkas</a>
						</li>
					</ul>
				</div>
			</div><br>
			{$Pesan}
			<table width='100%'>
			<tr>
				<td width='50%' valign=top>
					<table width='100%'>
					<tr>
						<td>Nama&nbsp;Lengkap</td>
					</tr>
					<tr>
						<td>".$Func->txtField('name',@$name,'','','text',"style='width:100%'")."</td>	
					</tr>
					<tr>
						<td>Email</td>
					</tr>
					<tr>
						<td>".$Func->txtField('email',@$email,'','','text',"style='width:100%'")."</td>	
					</tr>
					<tr>
						<td colspan=2>
							<table width='100%'>
							<tr>
								<td>Gelar Awal</td>										
								<td>Gelar Akhir</td>													
							</tr>
							<tr>
								<td>".$Func->txtField('title_pre',@$title_pre,'','','text',"style='width:100%'")."</td>	
								<td>".$Func->txtField('title_post',@$title_post,'','','text',"style='width:100%'")."</td>	
							</tr>
							<tr>
								<td>Nomor KTP</td>
								<td>NPWP</td>
							</tr>
							<tr>										
								<td>".$Func->txtField('identity_id',@$identity_id,'','','text',"style='width:100%'")."</td>	
								<td>".$Func->txtField('tax_id',@$tax_id,'','','text',"style='width:100%'")."</td>
							</tr>
							<tr>
								<td>Nomor SIM A</td>
								<td>Nomor SIM B</td>
							</tr>
							<tr>										
								<td>".$Func->txtField('driving_a',@$driving_a,'','','text',"style='width:100%'")."</td>
								<td>".$Func->txtField('driving_b',@$driving_b,'','','text',"style='width:100%'")."</td>
							</tr>
							<tr>
								<td>Nomor SIM C</td>
							</tr>
							<tr>
								<td colspan=2>".$Func->txtField('driving_c',@$driving_c,'','','text',"style='width:100%'")."</td>
							</tr>
							<tr>
								<td>Tempat Lahir</td>
								<td>Tgl. Lahir</td>
							</tr>
							<tr>
								<td>".$Func->txtField('birth_place',@$birth_place,'','','text',"style='width:100%'")."</td>
								<td>".$Func->txtField('birth_date',@$birth_date,'','','date',"style='width:100%'")."</td>
							</tr>
							<tr>
								<td>Gol. Darah</td>
								<td>Status Pernikahan</td>
							</tr>
							<tr>										
								<td>".$Func->cmbUmum('blood_type',@$blood_type,array("A","B","AB","O"))."</td>
								<td>".$Func->cmbQuery('marital_status_id',@$marital_status_id,"select status_id, name from magang.status_tr where type='Status Pernikahan'")."</td>
							</tr>
							</table>
						</td>							
					</tr>							
					</table>	
				</td>
				<td width='50%' valign=top style='padding-left:30px;'>
					<table width='100%'>
					<tr>
						<td>Kab/Kota Asal</td>
					</tr>
					<tr>
						<td>".$Func->cmbQuery('region_id',@$region_id,"select region_id, name from magang.region_tr")."</td>
					</tr>
					<tr>
						<td>Alamat Asal</td>
					</tr>
					<tr>
						<td><textarea name='address' style='width:100%;height:100px;' class='form-control'>{$address}</textarea></td>
					</tr>
					
					<tr>
						<td>
							<table width='100%'>
							<tr>
								<td>Domisili Asal</td>
								<td>Kode POS Asal</td>
							</tr>
							<tr>
								<td>".$Func->txtField('region',@$region,'','','text',"style='width:100%'")."</td>	
								<td>".$Func->txtField('zip',@$zip,'','','text',"style='width:100%'")."</td>	
							</tr>
							</table>
						</td>	
					</tr>							
					<tr>
						<td><hr></td>
					</tr>
					<tr>
						<td>Kab/Kota Tinggal</td>
					</tr>
					<tr>
						<td>".$Func->cmbQuery('region_id_home',@$region_id_home,"select region_id, name from magang.region_tr")."</td>
					</tr>
					<tr>
						<td>Alamat Tinggal</td>
					</tr>
					<tr>
						<td>
							<textarea name='address_home' style='width:100%;height:100px;' class='form-control'>{$address_home}</textarea>
						</td>	
					</tr>
					<tr>
						<td>
							<table width='100%'>
							<tr>
								<td>Domisili Tinggal</td>
								<td>Kode Pos Tinggal</td>
							</tr>
							<tr>
								<td>".$Func->txtField('region_home',@$region_home,'','','text',"style='width:100%'")."</td>	
								<td>".$Func->txtField('zip_home',@$zip_home,'','','text',"style='width:100%'")."</td>	
							</tr>
							</table>
						</td>	
					</tr>
					<tr>
						<td colspan=2>
							<table width='100%'>
							<tr>
								<td>No Ponsel</td>
								<td>No Ponsel Alternatif</td>
							</tr>	
							<tr>										
								<td>".$Func->txtField('mobile',@$mobile,'','','text',"style='width:100%'")."</td>	
								<td>".$Func->txtField('mobile_alt',@$mobile_alt,'','','text',"style='width:100%'")."</td>
							</tr>
							<tr>
								<td>Etnis</td>
								<td>Agama</td>
							</tr>
							<tr>
								<td>".$Func->cmbQuery('ethnicity_id',@$ethnicity_id,"select status_id, name from magang.status_tr where type='Suku/Etnis'")."</td>
								<td>".$Func->cmbQuery('religion_id',@$religion_id,"select status_id, name from magang.status_tr where type='Agama'")."</td>
							</tr>
							</table>
						</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>	
			<div class='modal-footer'>
				<button type='button' class='btn btn-light' onclick=\"parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}/';\" >Kembali</button>
				<button type='button' class='btn btn-primary' onclick=\"Fm2.Aksi.value='Simpan';Fm2.submit();\" >Save changes</button>
			</div>	
		</div>
		
		
	</form>
	

	
	";
	//$Main->Isi = $Func->Kotak('Halaman Utama',$Main->Isi,'85%');
?>