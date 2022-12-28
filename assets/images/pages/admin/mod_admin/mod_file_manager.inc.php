<?php
	$dirUrl = $Url->BaseUrl."drive-data/dokumen-master/";
	$dirUpload = "./drive-data/dokumen-master/";
	$ListMode="";
	switch($Action){
		case "Simpan":
			$namaFile=$_FILES['text_value']['name'];
			$namaFile=strtolower(str_replace(" ","_",$namaFile));
			$namaSementara = $_FILES['text_value']['tmp_name'];
			
			move_uploaded_file($namaSementara, $dirUpload.$namaFile);
		break;
		case "Hapus":
			unlink($txtnmfile);
		break;
	}

	
	$ArrFile = scandir($dirUpload);
	$i=1;$z=1;
	while(count($ArrFile)>=$z){
		$filelist=substr($ArrFile[$z-1],0,1);
		if($filelist!="."){
			$filename=$dirUpload.$ArrFile[$z-1];
			$fileUrl=$dirUrl.$ArrFile[$z-1];
			if (file_exists($filename)) {
				$wkt= date ("d/m/Y H:i:s.", filemtime($filename));
			}

			$ListMode.="
			<tr $wr  onmouseover=\"TG(this,'#FFCC33')\" onmouseout=\"TG(this,'$wh')\"> 
				<td align=center>$i.</td> 
 				<td>{$ArrFile[$z-1]}</td>
 				<td>".$Func->FileSizeConvert(filesize($filename))."</td>
 				<td>".$wkt."</td>
				<td>
					<ul class='list-inline hstack gap-2 mb-0'>
						<li class='list-inline-item edit copylink' data-bs-toggle='tooltip' data-bs-trigger='hover' data-bs-placement='top' title='Salin Url File' data-file='".$fileUrl."'>
							<a href='#showModal' data-bs-toggle='modal' class='text-primary d-inline-block edit-item-btn'>
								<i class='ri-file-copy-line fs-16'></i>
							</a>
						</li>
						<li class='list-inline-item' data-bs-toggle='tooltip' data-bs-trigger='hover' data-bs-placement='top' title='Remove'>
							<a class='text-danger d-inline-block remove-item-btn' data-bs-toggle='modal' href='#deleteOrder' onclick=\"Fm.txtnmfile.value='{$filename}';Fm.Action.value='Hapus';Fm.submit();\">
								<i class='ri-delete-bin-5-fill fs-16'></i>
							</a>
						</li>
					</ul>
				</td>
			</tr>
			";
			$i++;
		}
		
		$z++;
	}
	

	//////////// TABLE LIST 
	$List="<table class='table table-nowrap align-middle' id='orderTable'>
			<thead class='text-muted table-light'>
				<tr class='text-uppercase'>
					<th class='sort' width='5%'>No.</th>
					<th class='sort'>Nama File</th>
					<th class='sort'>Size</th>
					<th class='sort'>Waktu</th>
					<th class='sort'>Aksi</th>
				</tr>
			</thead>
			<tbody class='list form-check-all'>{$ListMode}</tbody>
			</table> "; 
	 
	/////////// FORM 
	$Form="
		
		<div class='card-body border border-dashed border-end-0 border-start-0'>
			<form name=Fm id=Fm method=post action='{$Url->BaseMain}/{$Pg}/{$Pr}' enctype='multipart/form-data'> 
			".$Func->txtField('Pr',$Pr,'','','hidden')." 
			".$Func->txtField('Mode',$Mode,'','','hidden')." 
			<input type='text' name='myInput' id='myInput' style='position:absolute;top:-100px;'>

			
			".$Func->txtField('txtnmfile','','','','hidden')." 
			".$Func->txtField('Action',$Action,'','','hidden')." 
				<div class='row g-3'>
					<div class='col-xxl-10 col-sm-6'>
						<input type='file' class='form-control search' placeholder='Pencarian Data' name='text_value'>
					</div>
					
					<!--end col-->
					<div class='col-xxl-2 col-sm-2'>
						
						<div >
							<button type='button' class='btn btn-success btn-label rounded-pill' onclick=\"Fm.Action.value='Simpan';Fm.submit();\"><i class='ri-upload-cloud-2-line label-icon align-middle rounded-pill fs-16 me-2'></i> Upload</button>
							
						</div>
					</div>
				
					
				</div>
				<!--end row-->
			</form>
		</div>
		<div class='card-body pt-0'>
			<div>
				<br>
				<div class='table-responsive table-card mb-1'>
					{$List}
				</div>
			

				<div class='d-flex justify-content-end'>
					<div class='pagination-wrap hstack gap-2'>
						$link
					</div>
				</div>
			</div>
			
		</div>

		<script type='text/javascript'>
			BASE_URL = '{$Url->Base}';
		</script>
		<script>	
		$( document ).ready(function() {		
			$('.copylink').click(function(){	
				var copyText = $(this).attr('data-file');

				$('#myInput').val(BASE_URL+''+copyText);
				var copyText = document.getElementById('myInput');
				copyText.select();
				copyText.setSelectionRange(0, 99999)
				document.execCommand('copy');
				document.getElementById('click_salin').click();
			});
		});
		</script>
	"; 
	 
	$Main->Isi=$Form; 	
?>