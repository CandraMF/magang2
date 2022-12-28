<?php
	$listdok="";
	$jcari=!empty($jcari)?$jcari:"Dokumen";
	switch($jcari){
		case "Kamus Hukum":
			include "{$Dir->ModAdmin}beranda/kamushukum.inc.php";
		break;
		default:
			include "{$Dir->ModAdmin}beranda/dokumen.inc.php";
	}
	$Main->HeadIsi="
		<script type='text/javascript' language='javascript' src='{BaseUrl}js/jquery-1.12.4.js'>  </script>
		<script src='{BaseUrl}js/amazingslider.js'></script>
		<script src='{BaseUrl}js/amazingslider_param.js'></script>
	

		<div id='amazingslider-1' style='display:block;position:relative;'>
			<ul class='amazingslider-slides' style='display:none;'>
				<li>
					<img src='{BaseUrl}images/slide/1.jpg'>
				</li>
				<li>
					<img src='{BaseUrl}images/slide/2.jpg'>
				</li>
				<li>
					<img src='{BaseUrl}images/slide/3.jpg'>
				</li>
				<li>
					<img src='{BaseUrl}images/slide/4.jpg'>
				</li>
			</ul>
		</div>
		
	";

	$Qry=_mysql_query("select a.kddokumen,a.nmdokumen, b.jmlterbit from ref_dokumen as a left join (select kddokumen, count(*) as jmlterbit from t_prohuk where tglvalid is not null group by kddokumen) as b on a.kddokumen=b.kddokumen order by a.kddokumen"); 
	$divterbit="";	
	$i=1;
	while($Isi=_mysql_fetch_array($Qry)){ 
		$class=$i==1?"<div class='py-4 px-3'>":"<div class='mt-3 mt-md-0 py-4 px-3'>";
		$divterbit.="
			<div class='col-2 '>
				<div class='mt-3 mt-md-0 py-4 px-3'>
					<h5 class='text-muted text-uppercase fs-13'>{$Isi['nmdokumen']}</h5>
					<div class='d-flex align-items-center' style='padding-top:10px;'>
						<div class='flex-shrink-0'>
							<i class='ri-book-2-line display-6 text-muted'></i>
						</div>
						<div class='flex-grow-1 ms-3'>
							<h2 class='mb-0'><span class='counter-value' data-target='".floatval($Isi['jmlterbit'])."'>".floatval($Isi['jmlterbit'])."</span></h2>
						</div>
					</div>
				</div>
			</div><!-- end col -->
		";	
		$i++;
	}
	
	$Main->Isi = "
		<div class='main-content'>
			<div class='page-content'>
				<div class='container-fluid'>
					<div style='margin-top:-18%;'>
						
						<div class='col-xl-12'>
								<div class='card-body border border-dashed border-end-0 border-start-0'>
									<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}' enctype='multipart/form-data'> 
									".$Func->txtField('Pr',$Pr,'','','hidden')." 
									".$Func->txtField('Mode',$Mode,'','','hidden')." 
									".$Func->txtField('halaman',$halaman,'','','hidden')." 
									".$Func->txtField('Action',$Action,'','','hidden')." 
										<div class='row g-3'>
											<div class='col-xxl-9 '>
											
												<div class='form-floating'>
													<input type='text' name='ckata' value='".@$ckata."' class='form-control' id='firstnamefloatingInput' placeholder='Ketikan Kata Kunci Pencarian '>
													<label for='firstnamefloatingInput'>Ketikan Kata Kunci Pencarian </label>
												</div>
											</div>
											<div class='col-xxl-2 '>
											
												<div class='form-floating'>
												
													".$Func->cmbUmum('jcari',@$jcari,array('Dokumen','Kamus Hukum'),"class='form-control' placeholder='Cari Jenis Pencarian'")."		
													<label for='firstnamefloatingInput'>Cari Jenis Pencarian</label>
												</div>
											</div>
											<!--end col-->
											<div class='col-xxl-1 '>
												
												<div >
													<button type='button' class='btn btn-primary w-100' style='height:60px;' onclick=\"Fm.Action.value='BknSimpan';Fm.submit();\"> <i class='ri-equalizer-fill me-1 align-bottom' ></i>
														Cari
													</button>
												</div>
											</div>
										
											
										</div>
										<!--end row-->
									</form>
								</div>
								<div class='card crm-widget'>
									<div class='card-body p-0'>
										<div class='row row-cols-xxl-5 row-cols-md-5 row-cols-1 g-0'>
											{$divterbit}
											
										</div><!-- end row -->
									</div><!-- end card body -->
								</div><!-- end card -->
							</div><!-- end col -->
						</div><!-- end row -->		
						
						{$ListDok}
						
					</div>
				</div>
			</div>
		</div>
 
	
	";
	//$Main->Isi = $Func->Kotak('Halaman Utama',$Main->Isi,'85%');
?>