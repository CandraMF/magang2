<?php
	
	$ContentBottomIsi="
		<div class='card'>
			<div class='card-body'>
				<div class='row'>
					<div class='col-lg-10'>
						<h6 class='text-muted text-uppercase fw-semibold mb-4'>Dokumen Keputusan Badan / Kepala Badan</h6>
					</div>
					<div class='col-lg-2' align=right>
						<a href='{$Url->BaseMain}/{$Pg}/{$Pr}' title='Kembali Ke Dokumen Usulan' >
							<i class='ri-reply-fill label-icon align-middle fs-16 me-2'  class='btn btn-primary btn-label text-muted'> </i>Kembali
						</a>
					</div>
				</div>
				
				
		   

				
			</div>

			<div class='col-lg-12'>
					   
						<div class='card'>
							<div class='card-header'>
								Bidang Pengusul  <strong class='badge rounded-pill bg-success'>Bidang Hukum dan Kepatuhan</strong>
							</div>                   
							<div class='card-header'>
								No. Register  <strong class='badge rounded-pill bg-success'>111/SK.02/2022</strong>
							</div>          
							<div class='card-header'>
								Tgl. Register  <strong class='badge rounded-pill bg-success'>04 Agustus 2022</strong>
							</div> 
							<div class='card-header'>
								Status  <strong class='badge rounded-pill bg-success'>Berlaku</strong>
							</div> 
							<!-- end card body -->
						</div>
						<!-- end card -->

					   
					</div>
			<div class='card-body'>
				
				
				<div class='mb-3'>
					<label class='form-label' for='project-title-input' > Jenis dan Tarif atas Jenis Penerimaan Negara Bukan Pajak yang Bersifat Volatil dan Kebutuhan Mendesak Bidang Pendidikan dan Pelatihan di Lingkungan Kementerian Pertahanan  05 Juli 2022  175 x dilihat			</label>
				
				</div>
				
		   

				
			</div>
			<!-- end card body -->
		</div>

		<!-- end card -->

		<div class='row'>
			<div class='col-lg-9'>
				<button type='submit' class='btn btn-success w-sm'>Lihat Dokumen</button>
			</div>
			<div class='col-lg-3' align=right>
			
				<button type='submit' class='btn btn-success w-sm'>Unduh Dokumen</button>
			</div>
		</div>
		<!-- end card -->
		
	";
	
	$Main->BottomIsi="
		<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/{$Mode}/{$Sb}' enctype='multipart/form-data'> 
		
		<div class='main-content' >

            <div class='page-content'>
                <div class='container-fluid'>

                    <!-- start page title -->
                    <div class='row'>
                        <div class='col-12'>
                            <div class='page-title-box d-sm-flex align-items-center justify-content-between'>
                                <h4 class='mb-sm-0'>Rincian Dokumen</h4>
							
								
                                <div class='page-title-right'>
                                    <ol class='breadcrumb m-0'>
                                        <li class='breadcrumb-item'><a href='javascript: void(0);'> Beranda</a></li>
                                        <li class='breadcrumb-item active'>Rincian Dokumen</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

					

                    <div class='row'>

                        <div class='col-lg-12'>
							{$ContentBottomIsi}
                        </div>
                        <!-- end col -->

						
                        
                    </div>
					<div class='row'>

                       
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

?>