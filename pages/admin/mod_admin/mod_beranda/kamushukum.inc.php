<?php
	$i=1;
	$wh=!empty($ckata)?" and (lower(nmkamus) like '%".strtolower($ckata)."%' or lower(uraian) like '%".strtolower($ckata)."%')":"";
	$Qry=_mysql_query("SELECT * from t_kamus_hukum where stskamus='Diterima' and aktif='aktif' $wh ORDER BY created_date desc limit 20"); 
	while($Isi=_mysql_fetch_array($Qry)){ 
		$listdok.="
			<div class='col-md-6'>
					<div class='card card-animate'>
						<div class='card-body'>
							<div class='d-flex justify-content-between'>
								<div>
									<p class='fw-medium mb-0 text-danger'><strong>{$Isi['kdregister']}</strong></p>
									<p class='mt-4 ff-secondary fw-semibold text-muted'>
										<h5>{$Isi['nmkamus']}</h5>
										{$Isi['uraian']}
									</p>
									<p class='mb-0 text-muted'>
										<span class='badge bg-light text-success mb-0'>
											<i class='ri-timer-line align-middle'></i> ".$Func->TglAll($Isi['created_date'])."
										   
										</span> 
										<i class='ri-eye-line align-middle'></i> ".substr($Isi['created_date'],11,5)."
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
					Kamus Hukum
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