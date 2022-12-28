<?php
	$MainJudul="";
	$Main->MainJudul="Utama";
	$Main->Judul="Profil";
	$idSub=!empty($idSub)?$idSub:"";
	

	$ListMode="";$i=1; 
	$PopUpWidth="'450','200'"; 
	
	$Qry="select person_id, identity_id, name, birth_place, birth_date, email, mobile  from magang.person_tm where email='{$sUserId}' order by person_id"; 
	$ParamDet="{$Pg}/{$Pr}/{$ckata}/{$Action}"; 
	$Qry=_mysql_query($Qry); 
	
	///// LIST GRID 
	
	while($Isi=_mysql_fetch_array($Qry)){ 
		$wr = $i % 2 == 0 ? "style='background:$Main->BgRow'" : "style='background:$Main->BgRow2'"; 
		$wh = $i % 2 == 0 ? "$Main->BgRow" : "$Main->BgRow2"; 

		 	
		$onclick_edit="onclick=\"parent.location='{$Url->BaseMain}/{$Pg}/{$Pr}/data_diri/baru';\" ";
		$td=" 
			<p align=right>
				<a href='#' class='btn btn-icon btn-warning' {$onclick_edit}><i class='fas fa-edit fs-4 me-2'></i></a>
			</p>"; 
		

		
		$ListMode.=" 
		<table width='100%'>
		<tr>
			<td><h2>INFORMASI DATA DIRI </h2></td>
			<td>$td</td>
		</tr>
		</table>
		
		<table class='table table-striped gy-5 gs-7'>
			
			<tr>
				<td width='20%'>Nama Lengkap</td>
				<td>: {$Isi['name']}</td>
			</tr>
			<tr>
				<td>NIK</td>
				<td>: {$Isi['identity_id']}</td>
			</tr>
			<tr>
				<td>Tempat Tgl Lahir</td>
				<td>: {$Isi['birth_place']}, ".$Func->TglAll($Isi['birth_date'])."</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>: {$Isi['email']}</td>
			</tr>
			<tr>
				<td>No. Ponsel</td>
				<td>: {$Isi['mobile']}</td>
			</tr>
		</table>	
		";$i++; 

	}

	
	$Main->Isi = "{$Pesan}
	<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}/' enctype='multipart/form-data'> 
	".$Func->txtField('Pr',$Pr,'','','hidden')." 
	".$Func->txtField('Mode',$Mode,'','','hidden')." 
	".$Func->txtField('halaman',$halaman,'','','hidden')." 
	".$Func->txtField('Action',$Action,'','','hidden')." 
	".$Func->txtField('idSub',$idSub,'','','hidden')." 
		<div class='py-10'>
		$ListMode			
				
		</div>
		<div class='d-flex align-items-center rounded py-5 px-5 bg-light-warning'>
			<!--begin::Icon-->
			<!--begin::Svg Icon | path: icons/duotone/Code/Info-circle.svg-->
			<span class='svg-icon svg-icon-3x svg-icon-warning me-5'>
				<svg xmlns='http://www.w3.org/2000/svg' width='24px' height='24px' viewBox='0 0 24 24' version='1.1'>
					<circle fill='#000000' opacity='0.3' cx='12' cy='12' r='10'></circle>
					<rect fill='#000000' x='11' y='10' width='2' height='7' rx='1'></rect>
					<rect fill='#000000' x='11' y='7' width='2' height='2' rx='1'></rect>
				</svg>
			</span>
			<!--end::Svg Icon-->
			<!--end::Icon-->
			<!--begin::Description-->
			<div class='text-gray-600 fw-bold fs-6'><h2>Perhatian</h2> Silahkan lengkapi informasi biodata diri anda untuk melanjutkan proses berikutnya.</div>
			<!--end::Description-->
		</div>
		<script>
		$('#kt_datatable_example_3').DataTable({
			
			'search': true
		});
		</script>
		

	</form>
	";

	//$Main->Isi = $Func->Kotak('Halaman Utama',$Main->Isi,'85%');
?>