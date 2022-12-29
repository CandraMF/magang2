<?php
	$Modal="
		<div class='modal fade' tabindex='-1' id='kt_modal_1'>
		 <div class='modal-dialog modal-fullscreen'>
			<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title'>Form Isian</h5>
					
					<!--begin::Close-->
					<div class='btn btn-icon btn-sm btn-active-light-primary ms-2' data-bs-dismiss='modal' aria-label='Close'>
						<span class='svg-icon svg-icon-2x'></span>
					</div>
					<!--end::Close-->
				</div>

				<div class='modal-body'>					
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
					
				</div>

				<div class='modal-footer'>
					<button type='button' class='btn btn-light' data-bs-dismiss='modal'>Close</button>
					<button type='button' class='btn btn-primary' onclick=\"Fm.Action.value='Simpan';Fm.submit();\" >Save changes</button>
				</div>
			</div>
		</div>
	</div>
	";
?>