<?php
	
	$TambahId=!empty($TambahId)?$TambahId:"";
	$tglpengajuan=!empty($tglpengajuan)?$tglpengajuan:date("Y-m-d");
	$Readonly="";
	switch($Aksi)
	{
		case "Simpan";
			if(!empty($nmkamus)&&!empty($uraian)&&!empty($idbidang)){
				$QTmp="select count(*) as jml from t_kamus_hukum where kdregister='{$idPop}'";
				$Qry = _mysql_query( $QTmp );	
				$Hasil=_mysql_fetch_array($Qry);	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
			
				if ($jCount > 0)
				{$Qry="UPDATE t_kamus_hukum SET nmkamus='{$nmkamus}', uraian='{$uraian}', updated_by='{$pupdated_by}', updated_date='{$pupdated_date}' WHERE  kdregister='{$idPop}';";}
				else
				{
					$stskamus="Pengajuan";$aktif="Aktif";
					$Qry="INSERT INTO t_kamus_hukum (kdregister, idbidang, nmkamus, uraian, stskamus, aktif, created_by, created_date) VALUES ('{$kdregister}', '{$idbidang}', '{$nmkamus}', '{$uraian}', '{$stskamus}', '{$aktif}', '{$pcreated_by}', '{$pcreated_date}');";
				}
		
				$Simpan=_mysql_query( $Qry );
				
				$Pesan = $Simpan?"<div class='alert alert-success' role='alert'>Sudah di simpan</div>":"<div class='alert alert-danger mb-xl-0' role='alert'>Gagal di simpan</div>";		
				echo "<script>parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}';</script>";
			}
			else
			{$Pesan = "<div class='alert alert-danger mb-xl-0' role='alert'>Maaf, form warna merah wajib diisi</div>";}
		break;
		case "Lihat":
			$Func->ambilData("select * from t_kamus_hukum where kdregister='".$idPop."'");
			$Readonly="readonly";
		break;
		case "Hapus":
			_mysql_query("delete from t_kamus_hukum where kdregister='".$idPop."'");
			$Func->kosongkanData("t_kamus_hukum");
			echo "<script>parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}';</script>";	
		break;
		default:
			if(empty($Aksi)){
				$Func->kosongkanData("t_kamus_hukum");
				$kdregister=substr(date('Y'),-2).date('md').uniqid();
			}
	}
	$tglpengajuan=!empty($tglpengajuan)?$tglpengajuan:date("Y-m-d");
	$kdregister=!empty($kdregister)?$kdregister:$idPop;
	$Main->BottomIsi="
		<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$Mode}/{$Sb}' enctype='multipart/form-data'> 
		
		<div class='main-content' >

            <div class='page-content'><br>
                <div class='container-fluid'>

                    <!-- start page title -->
                    <div class='row'>
                        <div class='col-12'>
                            <div class='page-title-box d-sm-flex align-items-center justify-content-between'>
                                <h4 class='mb-sm-0'>Form Pengajuan Kamus Hukum</h4>
							
								
                                <div class='page-title-right'>
                                    <ol class='breadcrumb m-0'>
                                        <li class='breadcrumb-item'><a href='javascript: void(0);'> Dokumen</a></li>
                                        <li class='breadcrumb-item active'>{$Main->MenuHeader}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class='row'>
						<div class='col-lg-12'>
                           
                            <div class='card'>
                                <div class='card-header'>
                                    <h5 class='card-title mb-0'>Informasi Tahapan Kamus Hukum</h5>
									
                                </div>
                                <div class='card-body'>
									<div class='row'>
                                    {$Pesan}
	
										<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$Mode}/{$Sb}' enctype='multipart/form-data'> 
											<input type='text' name='x' style='display:none;'>
											<div class='row'>
												<div class='mb-2 mb-lg-3'>
												   <label class='form-label' for='project-title-input' style='color:red;'>No. Seri</label>
												   ".$Func->txtField('kdregister',@$kdregister,'','100','text',"readonly ")."								   
												</div>
											</div>
											<div class='row'>
												<div class='mb-3 mb-lg-3'>
													<label class='form-label' for='project-title-input'  style='color:red;'>Tgl. Pengajuan</label>
													".$Func->txtField('vtglpengajuan',@$tglpengajuan,'','100','date',"disabled")."
												</div>
											</div>
											<div class='row'>
												<div class='mb-3 mb-lg-3'>
													<label class='form-label' for='project-title-input' style='color:red;'>Bidang</label>
													".$Func->cmbQuery('idbidang',@$idbidang,'select idbidang, nmbidang from ref_bidang')."
												</div>
											</div>
											<div class='row'>
												<div class='mb-3 mb-lg-3'>
													<label class='form-label' for='project-title-input'  style='color:red;'>Nama&nbsp;Kamus</label>
													 ".$Func->txtField('nmkamus',@$nmkamus,'','100','text'," ")."			
												</div>
											</div>

											<div class='row'>
												<div class='mb-3 mb-lg-3'>
													<label class='form-label' for='project-title-input'  style='color:red;'>Uraian</label>
													".$Func->cKeditor("uraian",@$uraian,"")."
												</div>
											</div>
											<div class='row'>

												
											</div>
											
													
											".$Func->txtField('tglpengajuan',$tglpengajuan,'','','hidden')."
											".$Func->txtField('Mode',$Mode,'','','hidden')."
											".$Func->txtField('Aksi',$Aksi,'','','hidden')."
											".$Func->txtField('idPop',$idPop,'','','hidden')."
											".$Func->txtField('Pg',$Pg,'','','hidden')."
											".$Func->txtField('Pr',$Pr,'','','hidden')."
											".$Func->txtField('Sb',$Sb,'','','hidden')."
										</form>
	                                </div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
							<div class='row'>
								<div class='col-lg-9'>
									<button type='button' class='btn btn-warning w-sm'   onclick=\"parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}';\">Kembali</button>
								</div>
								<div class='col-lg-3' align=right>
									<button type='submit' class='btn btn-success w-sm' onclick=\"Fm.Aksi.value='Simpan';Fm.submit();\"  >Simpan</button>
								</div>
							</div>
                           
                        </div>
                        <!-- end col -->

                       
                        
                    </div>
                    <!-- end row -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

        </div>
        <!-- end main content-->
		</form>
		
	";
	if($Aksi!='Hapus'){
		$Main->Isi = $Func->Kotak($Main->MenuHeader,$Main->Isi,'100%');
	}else{
		$Main->Isi = $Func->Kotak($Main->MenuHeader,'<center><b>Melakukan Proses Hapus</b></center>','100%');
	}
?>