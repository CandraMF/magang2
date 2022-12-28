<?php
	if(empty($Mode)||$Mode=='Lihat'){
		
	
		$Kotak="	
		 <div class='vertical-overlay'></div>
		<div class='main-content kotak2' >
			<div class='container-fluid'>
				<!-- start page title -->
				<div class='row'>
					<div class='col-12'>
						<div class='page-title-box d-sm-flex align-items-center justify-content-between'>
							<h4 class='mb-sm-0'><!--JudulKotak--></h4>

							<div class='page-title-right'>
								<ol class='breadcrumb m-0'>
									<!--MainJudul-->
									
								</ol>
							</div>

						</div>
					</div>
				</div>
				<!-- end page title -->

				<div class='row'>
					<div class='col-lg-12'>
						<div class='card' id='orderList'>
							<!--IsiKotak--> 
						</div>

					</div>
					<!--end col-->
				</div>
				<!--end row-->

			</div>
		</div>
		
		";
	}else{
		$Kotak="<!--IsiKotak--> ";
	}
	
?>