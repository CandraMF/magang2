<?php
	$LinkPageNavi="";

	switch($Action){
		case "Hapus":
			_mysql_query( "DELETE FROM t_prohuk WHERE idprdh='".$idprdh."'" );
		break;

	}

	$ckata=!empty($ckata)?$ckata:"";
	$ctglpengajuan=!empty($ctglpengajuan)?$ctglpengajuan:"";
	$ckdmap=!empty($ckdmap)?$ckdmap:"";

	$Qry = _mysql_query( "select count(*) as jmlajuan, sum(case when tglvalid isnull then case when kdmap='99.99.999' then 1 else 0 end else 0 end) as jmlproses_sah, sum(case when tglvalid is not null then 1 else 0 end) as jmlterbit from t_prohuk" );	
	$Hasil=_mysql_fetch_array($Qry);	
	$jmlajuan=!empty($Hasil['jmlajuan'])?floatval($Hasil['jmlajuan']):0;
	$jmlproses_sah=!empty($Hasil['jmlproses_sah'])?floatval($Hasil['jmlproses_sah']):0;
	$jmlterbit=!empty($Hasil['jmlterbit'])?floatval($Hasil['jmlterbit']):0;
	$jmlproses=$jmlajuan-$jmlproses_sah-$jmlterbit;

	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	///// PARAMETER AND QUERY GRID 
	$wh=""; 
	$wh.=!empty($ckata)?" and (a.kdregister like '%$ckata%' or a.nmjudul like '%$ckata%'  or a.uraian like '%$ckata%') ":""; 
	$wh.=!empty($ctglpengajuan)?" and a.tglpengajuan='".$ctglpengajuan."' ":""; 
	$wh.=!empty($ckdmap)?" and a.kdmap='".$ckdmap."' ":""; 
	$jfilterdok=!empty($jfilterdok)?$jfilterdok:"";
	switch($jfilterdok){
		case "2":
			$wh.=" and a.kdmap not in('99.99.999') and (a.noregister !='' or noregister is null) "; 
		break;
		case "3":
			$wh.=" and a.kdmap='99.99.999' and  noregister is null "; 
		break;
		case "4":
			$wh.=" and noregister !=''"; 
		break;
		default:
			$jfilterdok="";
			
	}
	
	

	$Qry="select a.idprdh, a.kdregister,a.nmdokumen,a.kddokumen, a.nmjudul, a.kdmap, b.nourut ,a.tglpengajuan, a.tglvalid, a.created_date, a.uraian from t_prohuk as a left join t_map_dokumen as b on a.kdmap=b.kdmap and a.kddokumen=b.kddokumen where a.idprdh>0 {$wh} order by a.created_date desc"; 
	$ParamDet="{$Pg}/{$Pr}/{$ckata}/{$Action}"; 
	$Param="{$Url->BaseMain}/".$ParamDet; 

	$Param="{$Url->BaseMain}/".$ParamDet; 
	 
	///// PAGE HALAMAN GRID 
	$PageNavi = new pageNavi; 
	$batas='50';

	$substrpos=substr($REQUEST_URI,$strpos);
	if(empty($strpos)){$halaman=1;}else{$halaman=str_replace("pagehal-","",$substrpos);}
	
	$posisi = $PageNavi->cariPosisi($batas);$i=$posisi+1; 
	if(empty($Excel)){
		if(empty($ckata)){$limit=" limit $batas OFFSET  $posisi";}else{$halaman=1;$i=1;}		
	} 
	$LinkPageNavi="pagehal-{$halaman}";

	$jmldata = _mysql_num_rows(_mysql_query($Qry)); 
	$jmlhalaman = $PageNavi->jumlahHalaman($jmldata, $batas); 
	$linkHalaman = $PageNavi->navHalaman($halaman, $jmlhalaman, $Param); 
	$link="
				<div class='gridjs-pagination'>
					<div class='gridjs-pages'>
						$linkHalaman
					</div>
				</div>
			"; 
	 
	
	$Qry=_mysql_query($Qry.$limit); 
	while($Isi=_mysql_fetch_array($Qry)){ 
		$wr = $i % 2 == 0 ? "style='background:$Main->BgRow'" : "style='background:$Main->BgRow2'"; 
		$wh = $i % 2 == 0 ? "$Main->BgRow" : "$Main->BgRow2"; 
		

		$div="";
		switch($Isi['kdmap']){
			case "00.00.000":
				$div="<span class='badge rounded-pill bg-secondary'>Pengajuan</span>";
				$display="";
			break;
			case "99.99.999":
				
				if(!empty($Isi['tglvalid'])){
					$div="<span class='badge rounded-pill bg-success'>Sudah Disahkan</span>";
				}else{
					$div="<span class='badge rounded-pill bg-warning'>Proses Pengesahan</span>";
				}
				
				$display="style='display:none;'";
			break;
			default:
				$imap=1;$num_map=0;
				$QryMap=_mysql_query("select nourut, nmmap, kdmap from t_map_dokumen where kddokumen='{$Isi['kddokumen']}' order by nourut"); 
				while($IsiMap=_mysql_fetch_array($QryMap)){ 

					if(floatval($Isi['nourut'])>=floatval($IsiMap['nourut'])){
						$StyleMap="bg-success";			
					}else{
						$StyleMap="bg-info";
					}
					
					$div.="
						<div class='avatar-group-item'>
							<a href='javascript: void(0);' data-bs-toggle='tooltip' data-bs-placement='top' title='' data-bs-original-title='".$IsiMap['nmmap']."'>
								<div class='avatar-xxs'>
									<span class='avatar-title ".$StyleMap." rounded-circle  text-white'>
										".floatval($IsiMap['nourut'])."
									</span>
								</div>
							</a>
						</div>
					";
					
				}
				$div="
					<div class='avatar-group'>
						$div
					</div>
				";
				$display="style='display:none;'";
		}
				

		

		$ListMode.=" 
			<tr $wr  onmouseover=\"TG(this,'#FFCC33')\" onmouseout=\"TG(this,'$wh')\"> 
				
				<td class='id'><a href='#' class='fw-medium link-primary'>{$Isi['kdregister']}</a></td>
				<td class='customer_name'>
					{$Isi['nmdokumen']}<br>
					<span class='text-muted'>{$Isi['nmjudul']}</span>
				</td>
				<td class='date'>".$Func->TglAll($Isi['tglpengajuan'])."</td>
				<td class='date'>".$Func->TglAll($Isi['created_date'])."<small class='text-muted'>".substr(substr($Isi['created_date'],-12),0,6)."</small></td>
			  
				<td>{$Isi['uraian']}</td>
				<td class='status'>
					$div
				</td>
				<td>
					<ul class='list-inline hstack gap-2 mb-0'>
						<li class='list-inline-item' data-bs-toggle='tooltip' data-bs-trigger='hover' data-bs-placement='top' title='View/Edit' onclick=\"javascript:parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}/detail/lihat/{$Isi['kdregister']}';\">
							<a href='#' class='text-primary d-inline-block'>
								<i class='ri-eye-fill fs-16'></i>
							</a>
						</li>
					   
						<li class='list-inline-item' data-bs-toggle='tooltip' data-bs-trigger='hover' data-bs-placement='top' title='Remove' {$display} onclick=\"Fm.idprdh.value='{$Isi['idprdh']}';\">
							<a class='text-danger d-inline-block remove-item-btn' data-bs-toggle='modal' href='#deleteOrder'>
								<i class='ri-delete-bin-5-fill fs-16'></i>
							</a>
						</li>
					</ul>
				</td>
			</tr> 
		";$i++; 
	}

	$Main->BottomIsi="

	<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$LinkPageNavi}' enctype='multipart/form-data'> 
		".$Func->txtField('jfilterdok',$jfilterdok,'','','hidden')." 
		
		".$Func->txtField('Pr',$Pr,'','','hidden')." 
		".$Func->txtField('Mode',$Mode,'','','hidden')." 
		".$Func->txtField('halaman',$halaman,'','','hidden')." 
		".$Func->txtField('Action',$Action,'','','hidden')." 
		".$Func->txtField('idprdh',@$idprdh,'','','hidden')." 
		<div class='main-content'>

            <div class='page-content'>
                <div class='container-fluid'>

                    <!-- start page title -->
                    <div class='row'>
                        <div class='col-12'>
                            <div class='page-title-box d-sm-flex align-items-center justify-content-between'>
                                <h4 class='mb-sm-0'>{$Main->MenuHeader}</h4>

                                <div class='page-title-right'>
                                    <ol class='breadcrumb m-0'>
                                        <li class='breadcrumb-item'><a href='javascript: void(0);'>Dokumen</a></li>
                                        <li class='breadcrumb-item active'>{$Main->MenuHeader}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

					<div class='row'>
						<div class='col-xl-3 col-md-6'>
							<!-- card -->
							<div class='card card-animate' onclick=\"Fm.jfilterdok.value='1';Fm.Action.value='BknSimpan';Fm.submit();\">
								<div class='card-body'>
									<div class='d-flex align-items-center'>
										<div class='flex-grow-1 overflow-hidden'>
											<p class='text-uppercase fw-medium text-muted text-truncate mb-0'>
												Dokumen Yang Diusulkan</p>
										</div>
										
									</div>
									<div class='d-flex align-items-end justify-content-between mt-4'>
										<div>
											<h4 class='fs-22 fw-semibold ff-secondary mb-4'><span class='counter-value' data-target='{$jmlajuan}'>0</span>
											</h4>
											<a href='#' class='text-decoration-underline text-muted' >Lihat Dokumen</a>
										</div>
										<div class='avatar-sm flex-shrink-0'>
											<span class='avatar-title bg-soft-success rounded fs-3'>
												<i class='bx ri-file-text-line text-success'></i>
											</span>
										</div>
									</div>
								</div><!-- end card body -->
							</div><!-- end card -->
						</div><!-- end col -->

						<div class='col-xl-3 col-md-6'>
							<!-- card -->
							<div class='card card-animate' onclick=\"Fm.jfilterdok.value='2';Fm.Action.value='BknSimpan';Fm.submit();\">
								<div class='card-body'>
									<div class='d-flex align-items-center'>
										<div class='flex-grow-1 overflow-hidden'>
											<p class='text-uppercase fw-medium text-muted text-truncate mb-0'>
												Dokumen Yang Proses</p>
										</div>
									</div>
									<div class='d-flex align-items-end justify-content-between mt-4'>
										<div>
											<h4 class='fs-22 fw-semibold ff-secondary mb-4'><span class='counter-value' data-target='{$jmlproses}'>0</span></h4>
											<a href='#' class='text-decoration-underline text-muted' >Lihat Dokumen</a>
										</div>
										<div class='avatar-sm flex-shrink-0'>
											<span class='avatar-title bg-soft-info rounded fs-3'>
												<i class='bx ri-file-edit-line text-info'></i>
											</span>
										</div>
									</div>
								</div><!-- end card body -->
							</div><!-- end card -->
						</div><!-- end col -->

						<div class='col-xl-3 col-md-6'>
							<!-- card -->
							<div class='card card-animate' onclick=\"Fm.jfilterdok.value='3';Fm.Action.value='BknSimpan';Fm.submit();\">
								<div class='card-body'>
									<div class='d-flex align-items-center'>
										<div class='flex-grow-1 overflow-hidden'>
											<p class='text-uppercase fw-medium text-muted text-truncate mb-0'>
												Dokumen Proses Pengesahan</p>
										</div>
										
									</div>
									<div class='d-flex align-items-end justify-content-between mt-4'>
										<div>
											<h4 class='fs-22 fw-semibold ff-secondary mb-4'><span class='counter-value' data-target='{$jmlproses_sah}'>0</span>
											</h4> 
											<a href='#' class='text-decoration-underline text-muted' >Lihat Dokumen</a>
										</div>
										<div class='avatar-sm flex-shrink-0'>
											<span class='avatar-title bg-soft-warning rounded fs-3'>
												<i class='bx  ri-contacts-book-upload-line text-warning'></i>
											</span>
										</div>
									</div>
								</div><!-- end card body -->
							</div><!-- end card -->
						</div><!-- end col -->

						<div class='col-xl-3 col-md-6'>
							<!-- card -->
							<div class='card card-animate' onclick=\"Fm.jfilterdok.value='4';Fm.Action.value='BknSimpan';Fm.submit();\">
								<div class='card-body'>
									<div class='d-flex align-items-center'>
										<div class='flex-grow-1 overflow-hidden'>
											<p class='text-uppercase fw-medium text-muted text-truncate mb-0'>
												Dokumen Yang Disahkan</p>
										</div>
										
									</div>
									<div class='d-flex align-items-end justify-content-between mt-4'>
										<div>
											<h4 class='fs-22 fw-semibold ff-secondary mb-4'><span class='counter-value' data-target='{$jmlterbit}'>0</span>
											</h4>
											<a href='#' class='text-decoration-underline text-muted' >Lihat Dokumen</a>
										</div>
										<div class='avatar-sm flex-shrink-0'>
											<span class='avatar-title bg-soft-primary rounded fs-3'>
												<i class='bx   ri-flag-line text-primary'></i>
											</span>
										</div>
									</div>
								</div><!-- end card body -->
							</div><!-- end card -->
						</div><!-- end col -->
					</div> <!-- end row-->

                    
                    		<div class='row'>
                        <div class='col-lg-12'>
                            <div class='card' id='orderList'>
                                <div class='card-header  border-0'>
                                    <div class='d-flex align-items-center'>
                                        <h5 class='card-title mb-0 flex-grow-1'>Daftar Ajuan Dokumen</h5>
                                        <div class='flex-shrink-0'>
                                            <button type='button' class='btn btn-success add-btn' data-bs-toggle='modal' id='create-btn' onclick=\"javascript:parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}/detail/baru';\"><i class='ri-add-line align-bottom me-1'></i> Pengajuan Dokumen</button>
                                           
                                          
                                        </div>
                                    </div>
                                </div>
                                <div class='card-body border border-dashed border-end-0 border-start-0'>
                                    <form>
                                        <div class='row g-3'>
                                            <div class='col-xxl-7 col-sm-6'>
                                                <div class='search-box'>
                                                    <input type='text' name='ckata' id='ckata' class='form-control search' placeholder='Cari No. Seri, Judul, Uraian...' value='".$ckata."'>
                                                    <i class='ri-search-line search-icon'></i>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class='col-xxl-2 col-sm-6'>
                                                <div>
                                                    <input type='date' name='ctglpengajuan'  value='".$ctglpengajuan."' id='ctglpengajuan' class='form-control' data-provider='flatpickr' data-date-format='d M, Y' data-range-date='true' id='demo-datepicker' placeholder='Select date'>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class='col-xxl-2 col-sm-4'>
                                                <div>
													".$Func->cmbQuery('ckdmap',$ckdmap,"select kddokumen, nmdokumen from ref_dokumen order by kddokumen")."
                                                    
                                                </div>
                                            </div>
                                            <!--end col-->
                                         
                                            <!--end col-->
                                            <div class='col-xxl-1 col-sm-4'>
                                                <div>
                                                    <button type='button' class='btn btn-primary w-100' onclick=\"Fm.Action.value='BknSimpan';Fm.submit();\"> <i class='ri-equalizer-fill me-1 align-bottom'></i>
                                                        Cari
                                                    </button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <div class='card-body pt-0'>
                                    <div>
                                        <ul class='nav nav-tabs nav-tabs-custom nav-success mb-3' role='tablist'>
                                            <li class='nav-item'>
                                               &nbsp;&nbsp;
                                            </li>
                                           
                                        </ul>

                                        <div class='table-responsive table-card mb-1'>
                                            <table class='table table-wrap align-middle' id='orderTable'>
                                                <thead class='text-muted table-light'>
                                                    <tr class='text-uppercase'>
                                                        <th  data-sort='idkode'>No.Seri</th>
                                                        <th  data-sort='dokumen'>Dokumen/Judul</th>
                                                        <th  data-sort='tgl'>Tgl&nbsp;Pengajuan</th>
                                                        <th  data-sort='wkt'>Wkt&nbsp;embuatan</th>
                                                        <th  data-sort='uraian'>Uraian</th>
                                                        <th  data-sort='status'>Status</th>
                                                        <th  data-sort='aksi'>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class='list form-check-all'>
													{$ListMode}
                                                </tbody>
                                            </table>
                                            <div class='noresult' style='display: none'>
                                                <div class='text-center'>
                                                    <lord-icon src='https://cdn.lordicon.com/msoeawqm.json' trigger='loop' colors='primary:#405189,secondary:#0ab39c' style='width:75px;height:75px'>
                                                    </lord-icon>
                                                    <h5 class='mt-2'>Sorry! No Result Found</h5>
                                                    <p class='text-muted'>We've searched more than 150+ Orders We did
                                                        not find any
                                                        orders for you search.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='d-flex justify-content-end'>
                                            <div class='pagination-wrap hstack gap-2'>
                                                $link
                                            </div>
                                        </div>
                                    </div>
                                    <div class='modal fade' id='showModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered'>
                                            <div class='modal-content'>
                                                <div class='modal-header bg-light p-3'>
                                                    <h5 class='modal-title' id='exampleModalLabel'>&nbsp;</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='close-modal'></button>
                                                </div>
                                                <form action='#'>
                                                    <div class='modal-body'>
                                                        <input type='hidden' id='id-field' />

                                                        <div class='mb-3' id='modal-id'>
                                                            <label for='orderId' class='form-label'>ID</label>
                                                            <input type='text' id='orderId' class='form-control' placeholder='ID' readonly />
                                                        </div>

                                                        <div class='mb-3'>
                                                            <label for='customername-field' class='form-label'>Customer
                                                                Name</label>
                                                            <input type='text' id='customername-field' class='form-control' placeholder='Enter name' required />
                                                        </div>

                                                        <div class='mb-3'>
                                                            <label for='productname-field' class='form-label'>Product</label>
                                                            <select class='form-control' data-trigger name='productname-field' id='productname-field'>
                                                                <option value=''>Product</option>
                                                                <option value='Puma Tshirt'>Puma Tshirt</option>
                                                                <option value='Adidas Sneakers'>Adidas Sneakers</option>
                                                                <option value='350 ml Glass Grocery Container'>350 ml
                                                                    Glass Grocery Container</option>
                                                                <option value='American egale outfitters Shirt'>American
                                                                    egale outfitters Shirt</option>
                                                                <option value='Galaxy Watch4'>Galaxy Watch4</option>
                                                                <option value='Apple iPhone 12'>Apple iPhone 12</option>
                                                                <option value='Funky Prints T-shirt'>Funky Prints
                                                                    T-shirt</option>
                                                                <option value='USB Flash Drive Personalized with 3D Print'>
                                                                    USB Flash Drive Personalized with 3D Print</option>
                                                                <option value='Oxford Button-Down Shirt'>Oxford
                                                                    Button-Down Shirt</option>
                                                                <option value='Classic Short Sleeve Shirt'>Classic Short
                                                                    Sleeve Shirt</option>
                                                                <option value='Half Sleeve T-Shirts (Blue)'>Half Sleeve
                                                                    T-Shirts (Blue)</option>
                                                                <option value='Noise Evolve Smartwatch'>Noise Evolve
                                                                    Smartwatch</option>
                                                            </select>
                                                        </div>

                                                        <div class='mb-3'>
                                                            <label for='date-field' class='form-label'>Order
                                                                Date</label>
                                                            <input type='date' id='date-field' class='form-control' data-provider='flatpickr' data-date-format='d M, Y' data-enable-time required placeholder='Select date' />
                                                        </div>

                                                        <div class='row gy-4 mb-3'>
                                                            <div class='col-md-6'>
                                                                <div>
                                                                    <label for='amount-field' class='form-label'>Amount</label>
                                                                    <input type='text' id='amount-field' class='form-control' placeholder='Total amount' required />
                                                                </div>
                                                            </div>
                                                            <div class='col-md-6'>
                                                                <div>
                                                                    <label for='payment-field' class='form-label'>Payment
                                                                        Method</label>
                                                                    <select class='form-control' data-trigger name='payment-method' id='payment-field'>
                                                                        <option value=''>Payment Method</option>
                                                                        <option value='Mastercard'>Mastercard</option>
                                                                        <option value='Visa'>Visa</option>
                                                                        <option value='COD'>COD</option>
                                                                        <option value='Paypal'>Paypal</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label for='delivered-status' class='form-label'>Delivery
                                                                Status</label>
                                                            <select class='form-control' data-trigger name='delivered-status' id='delivered-status'>
                                                                <option value=''>Delivery Status</option>
                                                                <option value='Pending'>Pending</option>
                                                                <option value='Inprogress'>Inprogress</option>
                                                                <option value='Cancelled'>Cancelled</option>
                                                                <option value='Pickups'>Pickups</option>
                                                                <option value='Delivered'>Delivered</option>
                                                                <option value='Returns'>Returns</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <div class='hstack gap-2 justify-content-end'>
                                                            <button type='button' class='btn btn-light' data-bs-dismiss='modal'>Close</button>
                                                            <button type='submit' class='btn btn-success' id='add-btn'>Add Order</button>
                                                            <button type='button' class='btn btn-success' id='edit-btn'>Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class='modal fade flip' id='deleteOrder' tabindex='-1' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered'>
                                            <div class='modal-content'>
                                                <div class='modal-body p-5 text-center'>
                                                    <lord-icon src='https://cdn.lordicon.com/gsqxdxog.json' trigger='loop' colors='primary:#405189,secondary:#f06548' style='width:90px;height:90px'></lord-icon>
                                                    <div class='mt-4 text-center'>
                                                        <h4>Apakah Kamu Yakin Akan Menghapus Data</h4>
                                                        <p class='text-muted fs-15 mb-4'>Proses ini akan menghapus secara permanen.</p>
                                                        <div class='hstack gap-2 justify-content-center remove'>
                                                            <button class='btn btn-link link-success fw-medium text-decoration-none' data-bs-dismiss='modal' onclick=\"Fm.Action.value='BknSimpan';Fm.submit();\"><i class='ri-close-line me-1 align-middle'></i>
                                                                Tutup</button>
                                                            <button class='btn btn-danger' id='delete-record' onclick=\"Fm.Action.value='Hapus';Fm.submit();\">Hapus</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end modal -->
                                </div>
                            </div>

                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                    

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



   
	</form>
	";
?>