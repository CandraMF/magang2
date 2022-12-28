<?php
	$i=1;
	while(30>=$i){
		$listdok.="
			<div class='col-md-3' onclick=\"parent.location='{$Url->BaseMain}/login/dokumen_usulan/dokumen_detail';\">
					<div class='card card-animate'>
						<div class='card-body'>
							<div class='d-flex justify-content-between'>
								<div>
									<p class='fw-medium mb-0 text-danger'><strong>111/SK.02/2022</strong></p>
									<p class='mt-4 ff-secondary fw-semibold text-muted'>
										<h5>Dokumen Keputusan Badan / Kepala Badan</h5>
										Jenis dan Tarif atas Jenis Penerimaan Negara Bukan Pajak yang Bersifat Volatil dan Kebutuhan Mendesak Bidang Pendidikan dan Pelatihan di Lingkungan Kementerian Pertahanan
									</p>
									<p class='mb-0 text-muted'>
										<span class='badge bg-light text-success mb-0'>
											<i class='ri-timer-line align-middle'></i> 05 Juli 2022
										   
										</span> 
										<i class='ri-eye-line align-middle'></i> 175 x dilihat
									</p>
								</div>
								<div>
									<div class='avatar-sm flex-shrink-0'>
										 <span class='avatar-title bg-soft-warning rounded fs-3'>
											<i class='ri-file-text-line text-warning'></i>
										</span>
										
									</div>
								</div>
							</div>
						</div><!-- end card body -->
					</div> <!-- end card-->
				</div> <!-- end col-->
		";
		$i++;
	}
	$ListDok="
		<div class='card-header p-0' style='margin-bottom:3px;'>
			<div class='alert alert-warning alert-solid alert-label-icon border-0 rounded-0 m-0 d-flex align-items-center' role='alert'>
				<i class=' ri-newspaper-line label-icon'></i>
				<div class='flex-grow-1 text-truncate'>
					Dokumen Portal Hukum Terbaru
				</div>
				<div class='flex-shrink-0'>
					<a href='pages-pricing.html' class='text-muted '><b>".$Func->TglHari(date('Y-m-d'))."</b></a>
				</div>
			</div>
		</div>
		<div class='row'>
			{$listdok}
		</div>
	";
?>