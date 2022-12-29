<?php
	$MenuAdmin ="";
	$ArrMenuAdm=array(
		array("Utama","H","#"),
		array("Beranda","D","beranda"),
		
		array("Rekrutmen","D","semua_rekrutmen"),
		array("Peserta","D","peserta"),
		array("Master Data","H","#"),
		array("Unit Kerja","D","unit_kerja"),
		array("Posisi/Jabatan","D","posisi"),
		array("Sekolah/Universitas","D","sekolah"),
		array("Jurusan","D","jurusan"),
		array("Daerah","D","daerah"),
		array("User","D","user"),
	);

	$ArrMenuPer=array(
		array("Utama","H","#"),
		array("Beranda","D","beranda"),
		array("Pendaftaran","D","pendaftaran"),
		array("Profil","D","profil"),
	);
	switch($sUserHak){
		case "1":
			$i=1;
			while(count($ArrMenuAdm)>=$i){
				if($ArrMenuAdm[$i-1][1]=="H"){
					$MenuAdmin.="
					<div class='menu-item mb-1'>
						<a class='menu-link active' href='#'>
							<span class='menu-icon'>
								<!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks.svg-->
								<span class='svg-icon svg-icon-2'>
									<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24px' height='24px' viewBox='0 0 24 24' version='1.1'>
										<g stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>
											<rect x='0' y='0' width='24' height='24' />
											<rect fill='#000000' x='4' y='4' width='7' height='7' rx='1.5' />
											<path d='M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z' fill='#000000' opacity='0.3' />
										</g>
									</svg>
								</span>
								<!--end::Svg Icon-->
							</span>
							<span class='menu-title'>{$ArrMenuAdm[$i-1][0]}</span>
						</a>
					</div>
					";
				}else{
					$link_sub=$ArrMenuAdm[$i-1][2];
					$MenuAdmin.="
					<div data-kt-menu-trigger='click' class='menu-item menu-accordion mb-1'>
						<a href='{$Url->BaseMain}/".$Func->encrypt($Pg, ENCRYPTION_KEY)."/".$Func->encrypt($link_sub, ENCRYPTION_KEY)."'>
						<span class='menu-link'>
							<span class='menu-icon'>
								<!--begin::Svg Icon | path: icons/duotone/Home/Library.svg-->
								<span class='svg-icon svg-icon-2'>
									<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24px' height='24px' viewBox='0 0 24 24' version='1.1'>
										<g stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>
											<rect x='0' y='0' width='24' height='24' />
											<path d='M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z' fill='#000000' />
											<rect fill='#000000' opacity='0.3' transform='translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)' x='16.3255682' y='2.94551858' width='3' height='18' rx='1' />
										</g>
									</svg>
								</span>
								<!--end::Svg Icon-->
							</span>
							<span class='menu-title'>{$ArrMenuAdm[$i-1][0]}</span>
						</span>
						</a>
					</div>
					";
				}
				$i++;
			}
		break;
		case "2":
			$i=1;
			while(count($ArrMenuPer)>=$i){
				if($ArrMenuPer[$i-1][1]=="H"){
					$MenuAdmin.="
					<div class='menu-item mb-1'>
						<a class='menu-link active' href='#'>
							<span class='menu-icon'>
								<!--begin::Svg Icon | path: icons/duotone/Layout/Layout-4-blocks.svg-->
								<span class='svg-icon svg-icon-2'>
									<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24px' height='24px' viewBox='0 0 24 24' version='1.1'>
										<g stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>
											<rect x='0' y='0' width='24' height='24' />
											<rect fill='#000000' x='4' y='4' width='7' height='7' rx='1.5' />
											<path d='M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z' fill='#000000' opacity='0.3' />
										</g>
									</svg>
								</span>
								<!--end::Svg Icon-->
							</span>
							<span class='menu-title'>{$ArrMenuPer[$i-1][0]}</span>
						</a>
					</div>
					";
				}else{
					$link_sub=$ArrMenuPer[$i-1][2];
					$MenuAdmin.="
					<div data-kt-menu-trigger='click' class='menu-item menu-accordion mb-1'>
						<a href='{$Url->BaseMain}/".$Func->encrypt($Pg, ENCRYPTION_KEY)."/".$Func->encrypt($link_sub, ENCRYPTION_KEY)."'>
						<span class='menu-link'>
							<span class='menu-icon'>
								<!--begin::Svg Icon | path: icons/duotone/Home/Library.svg-->
								<span class='svg-icon svg-icon-2'>
									<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='24px' height='24px' viewBox='0 0 24 24' version='1.1'>
										<g stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>
											<rect x='0' y='0' width='24' height='24' />
											<path d='M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z' fill='#000000' />
											<rect fill='#000000' opacity='0.3' transform='translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)' x='16.3255682' y='2.94551858' width='3' height='18' rx='1' />
										</g>
									</svg>
								</span>
								<!--end::Svg Icon-->
							</span>
							<span class='menu-title'>{$ArrMenuPer[$i-1][0]}</span>
						</span>
						</a>
					</div>
					";
				}
				$i++;
			}
		break;
	}
	$Main->MenuAdmin=$Func->KotakHeader("",$MenuAdmin,"100%","50");
?>