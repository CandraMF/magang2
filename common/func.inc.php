<?php
	class jabarsoft{
		function __construct(){}

		function get_client_ip() {
			$ipaddress = '';
			if (isset($_SERVER['HTTP_CLIENT_IP']))
				$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
			else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_X_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
			else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
				$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
			else if(isset($_SERVER['HTTP_FORWARDED']))
				$ipaddress = $_SERVER['HTTP_FORWARDED'];
			else if(isset($_SERVER['REMOTE_ADDR']))
				$ipaddress = $_SERVER['REMOTE_ADDR'];
			else
				$ipaddress = 'UNKNOWN';
			return $ipaddress;
		}

		function FileSizeConvert($bytes)
		{
			$bytes = floatval($bytes);
				$arBytes = array(
					0 => array(
						"UNIT" => "TB",
						"VALUE" => pow(1024, 4)
					),
					1 => array(
						"UNIT" => "GB",
						"VALUE" => pow(1024, 3)
					),
					2 => array(
						"UNIT" => "MB",
						"VALUE" => pow(1024, 2)
					),
					3 => array(
						"UNIT" => "KB",
						"VALUE" => 1024
					),
					4 => array(
						"UNIT" => "B",
						"VALUE" => 1
					),
				);

			foreach($arBytes as $arItem)
			{
				if($bytes >= $arItem["VALUE"])
				{
					$result = $bytes / $arItem["VALUE"];
					$result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
					break;
				}
			}
			return $result;
		}

		function ConvertVar($Content){
			$Content=str_replace("{St}","$",$Content);
			$Content=str_replace("{|+}",'".',$Content);
			$Content=str_replace("{+|}",'."',$Content);
			return $Content;
		}
		function TxtLabelAngka($NmForm="",$value="", $i=1){
			$formdata="
				<label id='numedit_{$NmForm}".$i."' class='numedit' data-frm='id_{$NmForm}".$i."'>".$this->cetakuang($value)."</label>
				<span class='frmnilai' id='id_{$NmForm}".$i."' >	
					<input type='text' id='nm_{$NmForm}".$i."'  data-id='".$i."' value='".floatval($value)."' class='txtlabelform class_{$NmForm}' style='text-align:right'>
					<input type='hidden' id='old_{$NmForm}".$i."'  data-id='".$i."' value='".floatval($value)."' class='class_{$NmForm}' style='text-align:right'>
					<br>
					<a href='#' class='SimpanHide' data-id='".$i."'><i class='icon-save'></i>  Simpan</a> 
					&nbsp;&nbsp;|&nbsp;&nbsp;
					<a href='#' class='cancel' data-nm='nm_{$NmForm}".$i."' data-old='old_{$NmForm}".$i."' data-main='numedit_{$NmForm}".$i."' data-valdat='id_{$NmForm}".$i."'><i class='icon-ban-circle'></i>Batal</a>
					
				</span>
			";
			return $formdata;
		}
		function chartpie($container="", $title="", $subtitle="", $series=""){
			$chart="
				<script type='text/javascript'>
				Highcharts.chart('".$container."', {
					chart: { type: 'pie', options3d: { enabled: true, alpha: 45 } },
					title: { text: '".$title."' },
					subtitle: { text: '".$subtitle."' },
					plotOptions: {
						pie: {
							innerSize: 100,
							depth: 45
						}
					},
					series: [ ".$series." ]
				});
				</script>
			";
			return $chart;
		}
		function chartarea($container="", $chart="", $title="", $categories="", $series=""){
			$chart="
				<script type='text/javascript'>
					Highcharts.chart('".$container."', {
						chart: {type: '".$chart."'},
						accessibility: {description: ''},
						title: {text: '".$title."'},
						subtitle: {text: ''},
						xAxis: {
							categories: [".$categories."],
							crosshair: true
						},
						yAxis: {
							title: { text: 'Nilai Rupiah' },
							labels: { formatter: function () { return this.value / 1000 + 'k'; } }
						},
						tooltip: {
							pointFormat: '{series.name} Rp. <b>{point.y:,.0f}</b>'
						},
						series: [".$series."]
					});
				</script>
			";
			return $chart;
		}
		/*
		function ambilData($query)
		{	
			$Query = _mysql_query($query);
			$Hasil=_mysql_fetch_array($Query);
			$Query1 = _mysql_query($query);
			while ($Field=_mysql_fetch_field($Query1))
			{
				$NmField = @$Field->name;

				global $$NmField;
				@$$NmField = @$Hasil[$NmField]!='0'?@$Hasil[$NmField]:"";
			}
		}
		*/
		function ambilData($query)
		{	
			$Query = _mysql_query($query);
			$Hasil=_mysql_fetch_array($Query);
			$Query1 = _mysql_query($query);
			for ($i = 0; $i < $Query1->columnCount(); $i++) {
				$col = $Query1->getColumnMeta($i);
				$NmField = @$col['name'];

				global $$NmField;
				@$$NmField = @$Hasil[$NmField]!='0'?@$Hasil[$NmField]:"";
			}
		}
		function getnoreg($vPr="",$vBln="",$vTahun=""){
			//////////////////////
			$ArrRomawi = array('I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII');
			//// pembuatan no register
			
			$Query1 = _mysql_query("SELECT noreg FROM mnoregister WHERE link_sub='{$vPr}'");
			$Query2 = _mysql_query("SELECT noregakhir FROM mnoregister_detail WHERE link_sub='{$vPr}' and bulan='{$vBln}' and tahun='{$vTahun}'");
			$Hasil1=_mysql_fetch_array($Query1);
			$Hasil2=_mysql_fetch_array($Query2);
			$noreg=$Hasil1['noreg'];
			$noregakhir=!empty($Hasil2['noregakhir'])?$Hasil2['noregakhir']:"0000";

			$noregakhir=!empty($noregakhir)?floatval($noregakhir)+1:1;
			$noregakhir=$this->ambildigit("0000",$noregakhir);
			
			$JNO=$noreg;
			$JNO=str_replace("{vbulan}",$ArrRomawi[$vBln-1],$JNO);
			$JNO=str_replace("{vtahun}",$vTahun,$JNO);
			$JNO=str_replace("{vnoreg}",$noregakhir,$JNO);
			
			$arrtemp=array($JNO,$noregakhir);
			/////////////////////////////////////////////////////////////////////////
			return $arrtemp;
		}

		function newnoreg($vPr="",$vBln="",$vTahun="", $noregakhir="", $pcreated_by="", $pcreated_date="", $pupdated_by="", $pupdated_date=""){
			$QTmp="select count(*) as jml from mnoregister_detail where link_sub='{$vPr}' and bulan='{$vBln}' and tahun='{$vTahun}'";
			$Qry = _mysql_query( $QTmp );	
			$Hasil=_mysql_fetch_array($Qry);	$jCount=!empty($Hasil['jml'])?$Hasil['jml']:0;
			if ($jCount > 0)
			{$Qry="UPDATE mnoregister_detail SET noregakhir='{$noregakhir}', updated_by='{$pupdated_by}', updated_date='{$pupdated_date}' where link_sub='{$vPr}' and bulan='{$vBln}' and tahun='{$vTahun}';";}
			else
			{$noregakhir='0001';$Qry="INSERT INTO mnoregister_detail (noregakhir, link_sub, bulan, tahun, created_by, created_date) VALUES ('{$noregakhir}', '{$vPr}', '{$vBln}', '{$vTahun}', '{$pcreated_by}', '{$pcreated_date}');";}						
			$Simpan=_mysql_query( $Qry );
		}

		function KopSurat($DINAS="",$ALAMAT=""){
			$temp="
				<table width='100%' style='border-bottom:5px double black;'>
				<tr>
					<td rowspan=4 ><img src='".$_SESSION['sImages']."/logopemda.jpg'></td>
					<td align=center><h3>PEMERINTAH KABUPATEN SUBANG</h3></td>
					<td rowspan=4><img src='".$_SESSION['sImages']."/logokesehatan.jpg'></td>
				</tr>
				<tr>
					<td align=center><h3>DINAS KESEHATAN KABUPATEN</h3></td>			
				</tr>
				<tr>
					<td align=center><h2>{$DINAS}</h2></td>			
				</tr>
				<tr>
					<td align=center>{$ALAMAT}</td>
				</tr>
				</table>
			";
			return $temp;
		}

		function TtdFooter($DINAS="", $TAHUN="", $BULAN="",$NIPKAPUS="",$NMKAPUS="",$NIPOBAT="",$NMOBAT="",$NIPBARANG="",$NMBARANG=""){
			$temp="
				<table width='100%'>
				<tr>
					<td></td>
					<td align=center>Subang, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {$BULAN} {$TAHUN}</td>
				</tr>
				<tr>
					<td align=center>Petugas Barang</td>
					<td align=center>Pengelola Obat</td>
					
				</tr>
				<tr>
					<td><br><br><br><br></td>
					<td></td>
				</tr>
				<tr>
					<td align=center><strong><u>{$NMBARANG}</u></strong></td>
					<td align=center><strong><u>{$NMOBAT}</u></strong></td>
				</tr>
				<tr>
					<td align=center><strong>NIP. {$NIPBARANG}</strong></td>
					<td align=center><strong>NIP/NRTKNA. {$NIPOBAT}</strong></td>
				</tr>
				<tr>
					<td colspan=2 align=center>Mengetahui</td>
				</tr>
				<tr>
					<td colspan=2 align=center>Kepala {$DINAS}</td>
				</tr>
				<tr>
					<td><br><br><br><br></td>
				</tr>
				<tr>
					<td colspan=2 align=center><strong><u>{$NMKAPUS}</u></strong></td>
				</tr>
				<tr>
					<td colspan=2 align=center><strong>NIP. {$NIPKAPUS}</strong></td>
				</tr>
				</table>
			";
			return $temp;
		}
		function encrypt($pure_string, $encryption_key) {
			/*
			$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			$encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
			*/
			$encrypted_string=$this->antiinjection($pure_string);
			return $encrypted_string;
		}

		
		function decrypt($encrypted_string, $encryption_key) {
			/*
			$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			$decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
			*/

			$decrypted_string=$this->antiinjection($encrypted_string);

			$decrypted_string = str_replace("'","",$decrypted_string);
			$decrypted_string = str_replace("?","",$decrypted_string);
			$decrypted_string = str_replace("=","",$decrypted_string);
			$decrypted_string = str_replace('"',"",$decrypted_string);
			$decrypted_string = str_replace('.',"",$decrypted_string);
			$decrypted_string = str_replace('system.',"",$decrypted_string);
			
			return $decrypted_string;
		}
			
		function WinOpen($Url){
			$script="onclick=\"window.open('".$Url."','winname','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=750,height=600');\"";
			return $script;
		}
		function clean($str){
			$str=@trim($str);
			if(get_magic_quotes_gpc())$str=stripslashes($str);
			return $str;
		}
		function labarugi($nobukti="", $noperk="", $debet=0, $kredit=0, $tanggal_akses=""){
			$keterangan="LABA RUGI";
			$jdk=$debet + $kredit;
			if(($jdk != 0) && !empty($nobukti)){			
				$idsbb=substr(trim($noperk),0,1);
				switch($idsbb){
					case "4":
						$COA="3011031";
						_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, debet, kredit, keterangan, tanggal_akses) VALUES ('{$nobukti}', '{$COA}', '{$debet}', '{$kredit}', '{$keterangan}', '{$tanggal_akses}');");
					break;
					case "5":
						$COA="3011031";
						_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, debet, kredit, keterangan, tanggal_akses) VALUES ('{$nobukti}', '{$COA}', '{$debet}', '{$kredit}', '{$keterangan}', '{$tanggal_akses}');");
					break;
				}
			}
			
		}
		function angka_pembulatan($angka,$digit,$minimal)
		{	
		  $digitvalue=substr($angka,-($digit));    $bulat=0;
		  $nolnol="";
		  for($i=1;$i<=$digit;$i++)
		  {
		   $nolnol.="0";
		  }
		  if($digitvalue<$minimal && $digit!=$nolnol)
		  {      $x1=$minimal-$digitvalue;
		   $bulat=$angka+$x1;
		  }else{
		   $bulat=$angka;
		  }
		  return $bulat;  
		}
		function rdAktifAkses($name='txtField',$value='',$param='')
		{
			$AK = !empty($value)?strtoupper($value):"N";
			$SelY = $AK=='Y'?" checked ":"";
			$SelN = $AK=='N'?" checked ":"";

			$Input  = "<table>
			<tr>
				<td style='border:0px;'><input type=\"radio\" name=\"$name\" value='Y' $SelY $param></td>
				<td style='border:0px;'>Y</td>
				<td style='border:0px;'><input type=\"radio\" name=\"$name\" value='N' $SelN $param> </td>
				<td style='border:0px;'>N </td>
			</tr>
			</table>
			
			";
//			$Input .= "&nbsp;";
			return $Input;
		}
		function AddDigit($Nilai=0){
			$MaxDigit=10;
			$JumlahDigit=strlen($Nilai);
			$AddText="";
			while($MaxDigit>$JumlahDigit){
				$AddText.="0";
				$JumlahDigit++;
				
			}
			return $AddText.$Nilai;

		}

		function cmbAuto($name='txtField',$value='',$query='',$param='',$width='')
		{
			$vAtas=!empty($vAtas)?$vAtas:"";
			$Input = "<option value='$vAtas'>Pilih</option>";
			$Query = _mysql_query($query);
			while ($Hasil=_mysql_fetch_row($Query))
			{
				$Sel = $Hasil[0]==$value?"selected":"";
				$Input .= "<option $Sel value=\"{$Hasil[0]}\">{$Hasil[1]}</option>";
			}

			$Input="
			<style>
			.ui-$name {
				position: relative;
				display: inline-block;
				background:white;
			}
			.ui-$name-toggle {
				position: absolute;
				top: 0;
				bottom: 0;
				margin-left: -1px;
				padding: 0;
				background:white;
				/* adjust styles for IE 6/7 */
				*height: 1.7em;
				*top: 0.1em;
			}
			.ui-$name-input {
				background:white;
				width:$width;
				margin: 0;
				padding: 0.3em;
			}
			#ui-id-2{
				background:white;
			}

			#".$name."search{
				width:550px;
			}
			</style>
			<script>
			(function( $ ) {
				$.widget( 'ui.$name', {
					_create: function() {

						var input,
							self = this,
							select = this.element.hide(),
							selected = select.children( ':selected' ),
							value = selected.val() ? selected.text() : '',
							wrapper = this.wrapper = $( '<span>' )
								.addClass( 'ui-$name' )
								.insertAfter( select );

						input = $( '<input id=".$name."search>' )
							.appendTo( wrapper )
							.val( value )
							.addClass( 'ui-state-default ui-$name-input' )
							.autocomplete({
								delay: 0,
								minLength: 0,
								source: function( request, response ) {
									var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), 'i' );
									response( select.children( 'option' ).map(function() {
										var text = $( this ).text();
										if ( this.value && ( !request.term || matcher.test(text) ) )
											return {
												label: text.replace(
													new RegExp(
														'(?![^&;]+;)(?!<[^<>]*)(' +
														$.ui.autocomplete.escapeRegex(request.term) +
														')(?![^<>]*>)(?![^&;]+;)', 'gi'
													), '<strong>$1</strong>' ),
												value: text,
												option: this
											};
									}) );
								},
								select: function( event, ui ) {
									ui.item.option.selected = true;
									self._trigger( 'selected', event, {
										item: ui.item.option
									});
								},
								change: function( event, ui ) {
									if ( !ui.item ) {
										var matcher = new RegExp( '^' + $.ui.autocomplete.escapeRegex( $(this).val() ) + '$', 'i' ),
											valid = false;
										select.children( 'option' ).each(function() {
											if ( $( this ).text().match( matcher ) ) {
												this.selected = valid = true;
												return false;
											}
										});
										if ( !valid ) {
											// remove invalid value, as it didn't match anything
											$( this ).val( '' );
											select.val( '' );
											input.data( 'autocomplete' ).term = '';
											return false;
										}
									}
								}
							})
							.addClass( 'ui-widget ui-widget-content ui-corner-left' );

						input.data( 'autocomplete' )._renderItem = function( ul, item ) {
							return $( '<li></li>' )
								.data( 'item.autocomplete', item )
								.append( '<a>' + item.label + '</a>' )
								.appendTo( ul );
						};

						$( '<a>' )
							.attr( 'tabIndex', -1 )
							.attr( 'title', 'Show All Items' )
							.appendTo( wrapper )
							.button({
								icons: {
									primary: 'ui-icon-triangle-1-s'
								},
								text: false
							})
							.removeClass( 'ui-corner-all' )
							.addClass( 'ui-corner-right ui-$name-toggle' )
							.click(function() {
								// close if already visible
								if ( input.autocomplete( 'widget' ).is( ':visible' ) ) {
									input.autocomplete( 'close' );
									return;
								}

								// work around a bug (likely same cause as #5265)
								$( this ).blur();

								// pass empty string as value to search for, displaying all results
								input.autocomplete( 'search', '' );
								input.focus();

							});
					},

					destroy: function() {
						this.wrapper.remove();
						this.element.show();
						$.Widget.prototype.destroy.call( this );
					}
				});
			})( jQuery );

			$(function() {
				$( '#$name' ).$name();
				$( '#toggle' ).click(function() {
					$( '#$name' ).toggle();
				});
			});
			</script>
			<select name=\"$name\" id=\"$name\">$Input</select><span id='cbody' style='background:white;'></span>
			";
			return $Input;
		}

		function Terbilang($x)
		{
			
		  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");	  
		  if ($x < 12)
			return " " . $abil[$x];
		  elseif ($x < 20)
			return $this->Terbilang($x - 10) . "belas";
		  elseif ($x < 100)
			return $this->Terbilang($x / 10) . " puluh" .$this-> Terbilang($x % 10);
		  elseif ($x < 200)
			return " seratus" . $this->Terbilang($x - 100);
		  elseif ($x < 1000)
			return $this->Terbilang($x / 100) . " ratus" . $this->Terbilang($x % 100);
		  elseif ($x < 2000)
			return " seribu" . $this->Terbilang($x - 1000);
		  elseif ($x < 1000000)
			return $this->Terbilang($x / 1000) . " ribu" . $this->Terbilang($x % 1000);
		  elseif ($x < 1000000000)
			return $this->Terbilang($x / 1000000) . " juta" . $this->Terbilang($x % 1000000);
		}
		function scroll($id="",$content=""){
			$scroll="
				<div id='".$id."'>
					<div class='scrollbar'><div class='track'><div class='thumb'><div class='end'></div></div></div></div>
					<div class='viewport'>
						 <div class='overview'>
						   $content
						</div>
					</div>
				</div>
			";
			return $scroll;
		}
		function img(){
			$img="
			<script>
			function readURL(input) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();
					
					reader.onload = function (e) {
						$('#blah').attr('src', e.target.result);
					}
					
					reader.readAsDataURL(input.files[0]);
				}
			}
			
			$('#imgInp').change(function(){
				readURL(this);
			});
			</script>
			";
			return $img;
		}
		function InfoUser($KCREATED_BY="",$KCREATED_DATE="",$KUPDATED_BY="",$KUPDATED_DATE=""){			
			$InfoForm="
				".$this->tabSplit('Info User')."
					<table width='100%'>
					<tr>
						<td valign=top width='20%'>Created&nbsp;By</td>
						<td valign=top width='1'>:</td>
						<td valign=top width='30%'>{$KCREATED_BY}</td>
						<td valign=top width='20%'>Updated&nbsp;By</td>
						<td valign=top width='1'>:</td>
						<td valign=top width='30%'>{$KUPDATED_BY}</td>
					</tr>
					<tr>
						<td valign=top colspan=3>Created&nbsp;Date&nbsp;:</td>
						
						<td valign=top colspan=3>Updated&nbsp;Date&nbsp;:</td>
						
					</tr>
					<tr>
						<td valign=top colspan=3>{$KCREATED_DATE}</td>
						<td valign=top colspan=3>{$KUPDATED_DATE}</td>
					</tr>
					</table>
				<hr>

			";
			return $InfoForm;
		}
		function Jurnal2wh($kd="", $fSbb="",$fnobukti="",$tgltrn="",$fNominal="",$fKet="",$fField="",$fValue="",$f2Field="",$f2Value=""){
			global $sUserId,$TANGGAL_AKSES; 
			// ambil SBB
			$fField=trim($fField);$fValue=trim($fValue);
			$wh="";
			$wh.=!empty($fField)?"and a.".trim($fField)." ='".$fValue."'":"";
			$f2Field=trim($f2Field);$f2Value=trim($f2Value);
			$wh.=!empty($f2Field)?"and a.".trim($f2Field)." ='".$f2Value."'":"";
			$Isi=_mysql_fetch_array(_mysql_query("select a.nosbb from keu_tblgl as a where left(a.nosbb,".strlen(trim($fSbb)).") ='".trim($fSbb)."' $wh"));			
			$nosbb=$Isi['nosbb'];

			$fKet=!empty($fKet)?"-".$fKet:"";
			$fValue2=!empty($fValue)?$fValue:"";
			$fValue=!empty($fValue)?"-".$fValue:"";

			$f2Value2=!empty($f2Value)?$f2Value:"";
			$f2Value=!empty($f2Value)?"-".$f2Value:"";
			
			if(!empty($fnobukti)&&!empty($nosbb)){
			$Qry=_mysql_query("select * from keu_toftrnc where nobukti='{$fnobukti}'");
				if(_mysql_num_rows($Qry)>0){
					_mysql_query("UPDATE keu_toftrnc SET chguser='$sUserId', chgtgl='$TANGGAL_AKSES' WHERE  nobukti='{$fnobukti}';");
					_mysql_query("DELETE FROM keu_toftrnc_detail WHERE  nobukti='{$fnobukti}' AND noperk='{$nosbb}';");
					_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}', '{$nosbb}', '{$fNominal}', '{$fnobukti}{$fValue}{$f2Value}{$fKet}', '{$fValue2}{$f2Value2}');");					
				}else{
					$Qry2=_mysql_query("select * from keu_toftrnh where nobukti='{$fnobukti}'");
					if(!_mysql_num_rows($Qry2)){
						_mysql_query("INSERT INTO keu_toftrnc (nobukti, tgltrn, inpuser, inptgl) VALUES ('{$fnobukti}', '{$tgltrn}', '{$sUserId}', '{$TANGGAL_AKSES}');");	

						_mysql_query("DELETE FROM keu_toftrnc_detail WHERE  nobukti='{$fnobukti}' AND noperk='{$nosbb}';");
						_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}', '{$nosbb}', '{$fNominal}', '{$fnobukti}{$fValue}{$f2Value}{$fKet}', '{$fValue2}{$f2Value2}');");

					}
				}

				$CodeLB=3900000000;
				if ($nosbb != $CodeLB){
					$cjml=_mysql_num_rows(_mysql_query("select * from keu_tblgl as a where a.nosbb ='$nosbb' and a.acctype in ('5','4');"));
					if ($cjml > 0){
						_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}' , '{$CodeLB}', '{$fNominal}', 'LABA RUGI', '".strtoupper($kd)."  {$nosbb}  LABA RUGI AUTO');");			
					}
				}
			}
		}
		
		function Jurnal3wh($kd="", $fSbb="",$fnobukti="",$tgltrn="",$fNominal="",$fKet="",$fField="",$fValue="",$fField2="",$fValue2="",$fField3="",$fValue3=""){
			global $sUserId,$TANGGAL_AKSES; 
			$wh="";
			// ambil SBB
			$fField=trim($fField);$fValue=trim($fValue);
			$wh.=!empty($fField)?"and a.".trim($fField)." ='".$fValue."'":"";

			$fField2=trim($fField2);$fValue2=trim($fValue2);
			$wh.=!empty($fField2)?"and a.".trim($fField2)." ='".$fValue2."'":"";
	
			$fField3=trim($fField3);$fValue3=trim($fValue3);
			$wh.=!empty($fField3)?"and a.".trim($fField3)." ='".$fValue3."'":"";

			$Isi=_mysql_fetch_array(_mysql_query("select a.nosbb from keu_tblgl as a where left(a.nosbb,".strlen(trim($fSbb)).") ='".trim($fSbb)."' $wh"));			
			$nosbb=$Isi['nosbb'];

//			echo "select a.nosbb from keu_tblgl as a where left(a.nosbb,".strlen(trim($fSbb)).") ='".trim($fSbb)."' $wh";

			$fKet=!empty($fKet)?"-".$fKet:"";
			$fValueF2=!empty($fValue)?$fValue:"";
			$fValue=!empty($fValue)?"-".$fValue:"";

			$fValue2F2=!empty($fValue2)?$fValue2:"";
			$fValue2=!empty($fValue2)?"-".$fValue2:"";

			$fValue3F2=!empty($fValue3)?$fValue3:"";
			$fValue3=!empty($fValue3)?"-".$fValue3:"";
			
			if(!empty($fnobukti)&&!empty($nosbb)){

			$Qry=_mysql_query("select * from keu_toftrnc where nobukti='{$fnobukti}'");			
				if(_mysql_num_rows($Qry)>0){						
					_mysql_query("UPDATE keu_toftrnc SET chguser='$sUserId', chgtgl='$TANGGAL_AKSES' WHERE  nobukti='{$fnobukti}';");
					_mysql_query("DELETE FROM keu_toftrnc_detail WHERE  nobukti='{$fnobukti}' AND noperk='{$nosbb}';");
					_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}', '{$nosbb}', '{$fNominal}', '{$fnobukti}{$fValue}{$fValue2}{$fValue3}{$fKet}', '{$fValueF2}{$fValue2F2}{$fValue3F2}');");	

				//	ECHO "KAHIJI - INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}', '{$nosbb}', '{$fNominal}', '{$fnobukti}{$fValue}{$fValue2}{$fValue3}{$fKet}', '{$fValueF2}{$fValue2F2}{$fValue3F2}');<HR>";
				}else{

					$Qry2=_mysql_query("select * from keu_toftrnh where nobukti='{$fnobukti}'");
					if(!_mysql_num_rows($Qry2)){
						_mysql_query("INSERT INTO keu_toftrnc (nobukti, tgltrn, inpuser, inptgl) VALUES ('{$fnobukti}', '{$tgltrn}', '{$sUserId}', '{$TANGGAL_AKSES}');");	
						_mysql_query("DELETE FROM keu_toftrnc_detail WHERE  nobukti='{$fnobukti}' AND noperk='{$nosbb}';");
						_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}', '{$nosbb}', '{$fNominal}', '{$fnobukti}{$fValue}{$fValue2}{$fValue3}{$fKet}', '{$fValueF2}{$fValue3F2}{$fValue3F2}');");

//						ECHO "KADUA - INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}', '{$nosbb}', '{$fNominal}', '{$fnobukti}{$fValue}{$fValue2}{$fValue3}{$fKet}', '{$fValueF2}{$fValue3F2}{$fValue3F2}');<HR>";

					}
				}

				$CodeLB=3900000000;
				if ($nosbb != $CodeLB){
					$cjml=_mysql_num_rows(_mysql_query("select * from keu_tblgl as a where a.nosbb ='$nosbb' and a.acctype in ('5','4');"));
					if ($cjml > 0){
						_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}' , '{$CodeLB}', '{$fNominal}', 'LABA RUGI', '".strtoupper($kd)."  {$nosbb}  LABA RUGI AUTO');");			
					}
				}
			}
		}
		
		function Jurnal3whPersen($kd="", $fSbb="",$fnobukti="",$tgltrn="",$fNominal="",$fKet="",$fField="",$fValue="",$fField2="",$fValue2="",$fField3="",$fValue3=""){
			global $sUserId,$TANGGAL_AKSES; 
			$wh="";
			// ambil SBB
			$fField=trim($fField);$fValue=trim($fValue);
			$wh.=!empty($fField)?"and a.".trim($fField)." ='".$fValue."'":"";

			$fField2=trim($fField2);$fValue2=trim($fValue2);
			$wh.=!empty($fField2)?"and a.".trim($fField2)." ='".$fValue2."'":"";
	
			$fField3=trim($fField3);$fValue3=trim($fValue3);
			$wh.=!empty($fField3)?"and a.".trim($fField3)." ='".$fValue3."'":"";

			$Isi=_mysql_fetch_array(_mysql_query("select a.nosbb, a.persen from keu_tblgl as a where left(a.nosbb,".strlen(trim($fSbb)).") ='".trim($fSbb)."' $wh"));			


//			echo "select a.nosbb, a.persen from keu_tblgl as a where left(a.nosbb,".strlen(trim($fSbb)).") ='".trim($fSbb)."' $wh";

			$nosbb=$Isi['nosbb'];
			$persen=$Isi['persen'];
			
			$fNominal=round(($fNominal*$persen)/100,2);

			$fKet=!empty($fKet)?"-".$fKet:"";
			$fValueF2=!empty($fValue)?$fValue:"";
			$fValue=!empty($fValue)?"-".$fValue:"";

			$fValue2F2=!empty($fValue2)?$fValue2:"";
			$fValue2=!empty($fValue2)?"-".$fValue2:"";

			$fValue3F2=!empty($fValue3)?$fValue3:"";
			$fValue3=!empty($fValue3)?"-".$fValue3:"";
			
			if(!empty($fnobukti)&&!empty($nosbb)){
			$Qry=_mysql_query("select * from keu_toftrnc where nobukti='{$fnobukti}'");			
				if(_mysql_num_rows($Qry)>0){						
					_mysql_query("UPDATE keu_toftrnc SET chguser='$sUserId', chgtgl='$TANGGAL_AKSES' WHERE  nobukti='{$fnobukti}';");
					_mysql_query("DELETE FROM keu_toftrnc_detail WHERE  nobukti='{$fnobukti}' AND noperk='{$nosbb}';");
					_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}', '{$nosbb}', '{$fNominal}', '{$fnobukti}{$fValue}{$fValue2}{$fValue3}{$fKet}', '{$fValueF2}{$fValue2F2}{$fValue3F2}');");
				}else{
					$Qry2=_mysql_query("select * from keu_toftrnh where nobukti='{$fnobukti}'");
					if(!_mysql_num_rows($Qry2)){
						_mysql_query("INSERT INTO keu_toftrnc (nobukti, tgltrn, inpuser, inptgl) VALUES ('{$fnobukti}', '{$tgltrn}', '{$sUserId}', '{$TANGGAL_AKSES}');");	
						_mysql_query("DELETE FROM keu_toftrnc_detail WHERE  nobukti='{$fnobukti}' AND noperk='{$nosbb}';");
						_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}', '{$nosbb}', '{$fNominal}', '{$fnobukti}{$fValue}{$fValue2}{$fValue3}{$fKet}', '{$fValueF2}{$fValue3F2}{$fValue3F2}');");

					}
				}

				$CodeLB=3900000000;
				if ($nosbb != $CodeLB){
					$cjml=_mysql_num_rows(_mysql_query("select * from keu_tblgl as a where a.nosbb ='$nosbb' and a.acctype in ('5','4');"));
					if ($cjml > 0){
						_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}' , '{$CodeLB}', '{$fNominal}', 'LABA RUGI', '".strtoupper($kd)."  {$nosbb}  LABA RUGI AUTO');");			
					}
				}
			}
		}


		function Jurnal($kd="", $fSbb="",$fnobukti="",$tgltrn="",$fNominal="",$fKet="",$fField="",$fValue=""){
			global $sUserId,$TANGGAL_AKSES; 
			// ambil SBB
			$fField=trim($fField);$fValue=trim($fValue);
			$wh=!empty($fField)?"and a.".trim($fField)." ='".$fValue."'":"";
			$Isi=_mysql_fetch_array(_mysql_query("select a.nosbb from keu_tblgl as a where left(a.nosbb,".strlen(trim($fSbb)).") ='".trim($fSbb)."' $wh"));			

			
			$nosbb=$Isi['nosbb'];

			$fKet=!empty($fKet)?"-".$fKet:"";
			$fValue2=!empty($fValue)?$fValue:"";
			$fValue=!empty($fValue)?"-".$fValue:"";
			
			if(!empty($fnobukti)&&!empty($nosbb)){
			$Qry=_mysql_query("select * from keu_toftrnc where nobukti='{$fnobukti}'");			
				if(_mysql_num_rows($Qry)>0){						
					_mysql_query("UPDATE keu_toftrnc SET chguser='$sUserId', chgtgl='$TANGGAL_AKSES' WHERE  nobukti='{$fnobukti}';");
					_mysql_query("DELETE FROM keu_toftrnc_detail WHERE  nobukti='{$fnobukti}' AND noperk='{$nosbb}';");
					_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}', '{$nosbb}', '{$fNominal}', '{$fnobukti}{$fValue}{$fKet}', '{$fValue2}');");					
				}else{
					$Qry2=_mysql_query("select * from keu_toftrnh where nobukti='{$fnobukti}'");
					if(!_mysql_num_rows($Qry2)){
						_mysql_query("INSERT INTO keu_toftrnc (nobukti, tgltrn, inpuser, inptgl) VALUES ('{$fnobukti}', '{$tgltrn}', '{$sUserId}', '{$TANGGAL_AKSES}');");	
						_mysql_query("DELETE FROM keu_toftrnc_detail WHERE  nobukti='{$fnobukti}' AND noperk='{$nosbb}';");
						_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}', '{$nosbb}', '{$fNominal}', '{$fnobukti}{$fValue}{$fKet}', '{$fValue2}');");

					}
				}

				$CodeLB=3900000000;
				if ($nosbb != $CodeLB){
					$cjml=_mysql_num_rows(_mysql_query("select * from keu_tblgl as a where a.nosbb ='$nosbb' and a.acctype in ('5','4');"));
					if ($cjml > 0){
						_mysql_query("INSERT INTO keu_toftrnc_detail (nobukti, noperk, ".$kd.", keterangan, nama) VALUES ('{$fnobukti}' , '{$CodeLB}', '{$fNominal}', 'LABA RUGI', '".strtoupper($kd)." {$nosbb} LABA RUGI AUTO');");			
					}
				}
			}
		}
		##################  BUKU KAS
		function BukuKas($mSbb="",$kd="", $fSbb="",$fno_transaksi="",$tgl_transaksi="",$fNominal="",$fKet="",$fField="",$fValue=""){
			global $sUserId,$TANGGAL_AKSES; 
			// ambil SBB
			$fField=trim($fField);$fValue=trim($fValue);
			$wh=!empty($fField)?"and a.".trim($fField)." ='".$fValue."'":"";
			$Isi=_mysql_fetch_array(_mysql_query("select a.nosbb from keu_tblgl as a where left(a.nosbb,".strlen(trim($fSbb)).") ='".trim($fSbb)."' $wh"));	

			$nosbb=$Isi['nosbb'];
			$fKet=!empty($fKet)?"-".$fKet:"";
			$fValue2=!empty($fValue)?$fValue:"";
			$fValue=!empty($fValue)?"-".$fValue:"";

			if(!empty($fno_transaksi)&&!empty($nosbb)){
			$Qry=_mysql_query("select * from keu_bukukas where no_transaksi='{$fno_transaksi}'");			
				if(_mysql_num_rows($Qry)>0){						

					_mysql_query("UPDATE keu_bukukas SET chguser='$sUserId', chgtgl='$TANGGAL_AKSES' WHERE  no_transaksi='{$fno_transaksi}';");
					_mysql_query("DELETE FROM keu_bukukas_detail WHERE  no_transaksi='{$fno_transaksi}' AND nosbb='{$nosbb}';");
					_mysql_query("INSERT INTO keu_bukukas_detail (no_transaksi, nosbb, ".$kd.", keterangan, nama) VALUES ('{$fno_transaksi}', '{$nosbb}', '{$fNominal}', '{$fno_transaksi}{$fValue}{$fKet}', '{$fValue2}');");					
				}else{
					$Qry2=_mysql_query("select * from keu_toftrnh where nobukti='{$fno_transaksi}'");
					if(!_mysql_num_rows($Qry2)){
						_mysql_query("INSERT INTO keu_bukukas (no_transaksi, tgl_transaksi, inpuser, inptgl,nosbb_k) VALUES ('{$fno_transaksi}', '{$tgl_transaksi}', '{$sUserId}', '{$TANGGAL_AKSES}', '$mSbb');");	
						_mysql_query("DELETE FROM keu_bukukas_detail WHERE  no_transaksi='{$fno_transaksi}' AND nosbb='{$nosbb}';");
						_mysql_query("INSERT INTO keu_bukukas_detail (no_transaksi, nosbb, ".$kd.", keterangan, nama) VALUES ('{$fno_transaksi}', '{$nosbb}', '{$fNominal}', '{$fno_transaksi}{$fValue}{$fKet}', '{$fValue2}');");
					}
				}

			}
		}

function BukuKas2wh($mSbb="",$kd="", $fSbb="",$fno_transaksi="",$tgl_transaksi="",$fNominal="",$fKet="",$fField="",$fValue="",$f2Field="",$f2Value=""){
			global $sUserId,$TANGGAL_AKSES; 
			// ambil SBB
			$fField=trim($fField);$fValue=trim($fValue);
			$wh="";
			$wh.=!empty($fField)?"and a.".trim($fField)." ='".$fValue."'":"";
			$f2Field=trim($f2Field);$f2Value=trim($f2Value);
			$wh.=!empty($f2Field)?"and a.".trim($f2Field)." ='".$f2Value."'":"";
			$Isi=_mysql_fetch_array(_mysql_query("select a.nosbb from keu_tblgl as a where left(a.nosbb,".strlen(trim($fSbb)).") ='".trim($fSbb)."' $wh"));			
			$nosbb=$Isi['nosbb'];

			$fKet=!empty($fKet)?"-".$fKet:"";
			$fValue2=!empty($fValue)?$fValue:"";
			$fValue=!empty($fValue)?"-".$fValue:"";

			$f2Value2=!empty($f2Value)?$f2Value:"";
			$f2Value=!empty($f2Value)?"-".$f2Value:"";
			
			if(!empty($fno_transaksi)&&!empty($nosbb)){
			$Qry=_mysql_query("select * from keu_bukukas where no_transaksi='{$fno_transaksi}'");
				if(_mysql_num_rows($Qry)>0){
					_mysql_query("UPDATE keu_bukukas SET chguser='$sUserId', chgtgl='$TANGGAL_AKSES' WHERE  no_transaksi='{$fno_transaksi}';");
					_mysql_query("DELETE FROM keu_bukukas_detail WHERE  no_transaksi='{$fno_transaksi}' AND nosbb='{$nosbb}';");
					_mysql_query("INSERT INTO keu_bukukas_detail (no_transaksi, nosbb, ".$kd.", keterangan, nama) VALUES ('{$fno_transaksi}', '{$nosbb}', '{$fNominal}', '{$fno_transaksi}{$fValue}{$f2Value}{$fKet}', '{$fValue2}{$f2Value2}');");					
				}else{
					$Qry2=_mysql_query("select * from keu_toftrnh where nobukti='{$fno_transaksi}'");
					if(!_mysql_num_rows($Qry2)){
						_mysql_query("INSERT INTO keu_bukukas (no_transaksi, tgl_transaksi, inpuser, inptgl, nosbb_k) VALUES ('{$fno_transaksi}', '{$tgl_transaksi}', '{$sUserId}', '{$TANGGAL_AKSES}', '$mSbb');");	

						_mysql_query("DELETE FROM keu_bukukas_detail WHERE  no_transaksi='{$fno_transaksi}' AND nosbb='{$nosbb}';");
						_mysql_query("INSERT INTO keu_bukukas_detail (no_transaksi, nosbb, ".$kd.", keterangan, nama) VALUES ('{$fno_transaksi}', '{$nosbb}', '{$fNominal}', '{$fno_transaksi}{$fValue}{$f2Value}{$fKet}', '{$fValue2}{$f2Value2}');");

					}
				}
			}

		}
		
		function BukuKas3wh($mSbb="",$kd="", $fSbb="",$fno_transaksi="",$tgl_transaksi="",$fNominal="",$fKet="",$fField="",$fValue="",$fField2="",$fValue2="",$fField3="",$fValue3=""){
			global $sUserId,$TANGGAL_AKSES; 
			$wh="";
			// ambil SBB
			$fField=trim($fField);$fValue=trim($fValue);
			$wh.=!empty($fField)?"and a.".trim($fField)." ='".$fValue."'":"";

			$fField2=trim($fField2);$fValue2=trim($fValue2);
			$wh.=!empty($fField2)?"and a.".trim($fField2)." ='".$fValue2."'":"";
	
			$fField3=trim($fField3);$fValue3=trim($fValue3);
			$wh.=!empty($fField3)?"and a.".trim($fField3)." ='".$fValue3."'":"";

			$Isi=_mysql_fetch_array(_mysql_query("select a.nosbb from keu_tblgl as a where left(a.nosbb,".strlen(trim($fSbb)).") ='".trim($fSbb)."' $wh"));			
			$nosbb=$Isi['nosbb'];

			

			$fKet=!empty($fKet)?"-".$fKet:"";
			$fValueF2=!empty($fValue)?$fValue:"";
			$fValue=!empty($fValue)?"-".$fValue:"";

			$fValue2F2=!empty($fValue2)?$fValue2:"";
			$fValue2=!empty($fValue2)?"-".$fValue2:"";

			$fValue3F2=!empty($fValue3)?$fValue3:"";
			$fValue3=!empty($fValue3)?"-".$fValue3:"";
			
			if(!empty($fno_transaksi)&&!empty($nosbb)){

			$Qry=_mysql_query("select * from keu_bukukas where no_transaksi='{$fno_transaksi}'");			
				if(_mysql_num_rows($Qry)>0){						
					_mysql_query("UPDATE keu_bukukas SET chguser='$sUserId', chgtgl='$TANGGAL_AKSES' WHERE  no_transaksi='{$fno_transaksi}';");
					_mysql_query("DELETE FROM keu_bukukas_detail WHERE  no_transaksi='{$fno_transaksi}' AND nosbb='{$nosbb}';");
					_mysql_query("INSERT INTO keu_bukukas_detail (no_transaksi, nosbb, ".$kd.", keterangan, nama) VALUES ('{$fno_transaksi}', '{$nosbb}', '{$fNominal}', '{$fno_transaksi}{$fValue}{$fValue2}{$fValue3}{$fKet}', '{$fValueF2}{$fValue2F2}{$fValue3F2}');");	
				}else{

					$Qry2=_mysql_query("select * from keu_toftrnh where nobukti='{$fno_transaksi}'");
					if(!_mysql_num_rows($Qry2)){
						_mysql_query("INSERT INTO keu_bukukas (no_transaksi, tgl_transaksi, inpuser, inptgl,nosbb_k) VALUES ('{$fno_transaksi}', '{$tgl_transaksi}', '{$sUserId}', '{$TANGGAL_AKSES}', '$mSbb');");	
						_mysql_query("DELETE FROM keu_bukukas_detail WHERE  no_transaksi='{$fno_transaksi}' AND nosbb='{$nosbb}';");
						_mysql_query("INSERT INTO keu_bukukas_detail (no_transaksi, nosbb, ".$kd.", keterangan, nama) VALUES ('{$fno_transaksi}', '{$nosbb}', '{$fNominal}', '{$fno_transaksi}{$fValue}{$fValue2}{$fValue3}{$fKet}', '{$fValueF2}{$fValue3F2}{$fValue3F2}');");

					}
				}
			}
		}
		
		function BukuKas3whPersen($mSbb="",$kd="", $fSbb="",$fno_transaksi="",$tgl_transaksi="",$fNominal="",$fKet="",$fField="",$fValue="",$fField2="",$fValue2="",$fField3="",$fValue3=""){
			global $sUserId,$TANGGAL_AKSES; 
			$wh="";
			// ambil SBB
			$fField=trim($fField);$fValue=trim($fValue);
			$wh.=!empty($fField)?"and a.".trim($fField)." ='".$fValue."'":"";

			$fField2=trim($fField2);$fValue2=trim($fValue2);
			$wh.=!empty($fField2)?"and a.".trim($fField2)." ='".$fValue2."'":"";
	
			$fField3=trim($fField3);$fValue3=trim($fValue3);
			$wh.=!empty($fField3)?"and a.".trim($fField3)." ='".$fValue3."'":"";

			$Isi=_mysql_fetch_array(_mysql_query("select a.nosbb, a.persen from keu_tblgl as a where left(a.nosbb,".strlen(trim($fSbb)).") ='".trim($fSbb)."' $wh"));			
			$nosbb=$Isi['nosbb'];
			$persen=$Isi['persen'];
			
			$fNominal=round(($fNominal*$persen)/100,2);

			$fKet=!empty($fKet)?"-".$fKet:"";
			$fValueF2=!empty($fValue)?$fValue:"";
			$fValue=!empty($fValue)?"-".$fValue:"";

			$fValue2F2=!empty($fValue2)?$fValue2:"";
			$fValue2=!empty($fValue2)?"-".$fValue2:"";

			$fValue3F2=!empty($fValue3)?$fValue3:"";
			$fValue3=!empty($fValue3)?"-".$fValue3:"";
			
			if(!empty($fno_transaksi)&&!empty($nosbb)){
			$Qry=_mysql_query("select * from keu_bukukas where no_transaksi='{$fno_transaksi}'");			
				if(_mysql_num_rows($Qry)>0){						
					_mysql_query("UPDATE keu_bukukas SET chguser='$sUserId', chgtgl='$TANGGAL_AKSES' WHERE  no_transaksi='{$fno_transaksi}';");
					_mysql_query("DELETE FROM keu_bukukas_detail WHERE  no_transaksi='{$fno_transaksi}' AND nosbb='{$nosbb}';");
					_mysql_query("INSERT INTO keu_bukukas_detail (no_transaksi, nosbb, ".$kd.", keterangan, nama) VALUES ('{$fno_transaksi}', '{$nosbb}', '{$fNominal}', '{$fno_transaksi}{$fValue}{$fValue2}{$fValue3}{$fKet}', '{$fValueF2}{$fValue2F2}{$fValue3F2}');");
				}else{
					$Qry2=_mysql_query("select * from keu_toftrnh where nobukti='{$fno_transaksi}'");
					if(!_mysql_num_rows($Qry2)){
						_mysql_query("INSERT INTO keu_bukukas (no_transaksi, tgl_transaksi, inpuser, inptgl, nosbb_k) VALUES ('{$fno_transaksi}', '{$tgl_transaksi}', '{$sUserId}', '{$TANGGAL_AKSES}','$mSbb');");	
						_mysql_query("DELETE FROM keu_bukukas_detail WHERE  no_transaksi='{$fno_transaksi}' AND nosbb='{$nosbb}';");
						_mysql_query("INSERT INTO keu_bukukas_detail (no_transaksi, nosbb, ".$kd.", keterangan, nama) VALUES ('{$fno_transaksi}', '{$nosbb}', '{$fNominal}', '{$fno_transaksi}{$fValue}{$fValue2}{$fValue3}{$fKet}', '{$fValueF2}{$fValue3F2}{$fValue3F2}');");

					}
				}
			}
		}
#c###########################################################################################################################################
		function ambildigit($nol="",$digit="")
		{
			$number=substr($nol,0,"-".strlen(trim($digit))).$digit;
			return $number;
		}
		function TglBlnthn($tgl = "")
		{
			global $Ref;
			if(!empty($tgl) and substr($tgl,0,4)!="0000")
			{
				$cHr = $Ref->NamaHari[date("w",mktime(0,0,0,substr($tgl,5,2),substr($tgl,8,2),substr($tgl,0,4)))];
				if($cHr == "Minggu"){$cHr = "<font color=red>$cHr</font>, ";}
				elseif($cHr == "Jum'at"){$cHr = "<font color=green>$cHr</font>, ";}
				else{$cHr = "$cHr, ";}
				return substr($tgl,8,2)." ".$Ref->NamaBulan[(substr($tgl,5,2)*1)-1]." ".substr($tgl,0,4);
			}
			else
			{	return " ";}
		}
		function addtext($text="",$add="")
		{
			$x=1;$rtext="";
//			strlen($text)
			while(7>=$x)
			{
				$rtext.=@$text[$x-1].$add;               
				$x++;
			}
			return $rtext;
		}
		function cetakuang($n) {
		$n=!empty($n)?$n:0;
		return @number_format($n,2,',','.');}
		
		function cetakDesimal($n) {$n=!empty($n)?$n:0;
		return @number_format($n,1,',','.');}


		function Import($JKolom="",$SKolom="",$SQry="",$NMTable="",$QInsert="",$FInsert="",$QUpdate="")
		{
			global $lap;
			$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
			$baris = $data->rowcount($sheet_index=0);
			$sukses = 0;
			$gagal = 0;
			$B=1;
			for ($i=2; $i<=$baris; $i++)
			{
				/////////// Membuat  Qry Insert 
				$Kolom=1;
				$VALUES="";
				$TD="";
				while($JKolom>=$Kolom)
				{
					if($SKolom[$Kolom-1]==$Kolom)
					{	
						$VALUES.="'".trim($data->val($i, $Kolom))."', ";
						$TD.="<TD class=csgrid align=center>".$data->val($i, $Kolom)."</TD>";
					}
					$Kolom++;
				}	

				$FIndex=1;
				if($FInsert!="")
				{
					while(count($FInsert)>=$FIndex)
					{
						$VALUES.="'".$FInsert[$FIndex-1]."', ";
						$TD.="<TD class=csgrid align=center>".$FInsert[$FIndex-1]."</TD>";
						$FIndex++;
					}
				}
				/////////// Membuat Qry Update
				$QIndex=1;
				$Set="";
				while(count($QUpdate)>=$QIndex)
				{
					if(substr($QUpdate[$QIndex-1][1],0,3)=="xxx")
					{
						
						$KRTR=SUBSTR($QUpdate[$QIndex-1][1],-2,2);				
						IF(SUBSTR($KRTR,-2,1)=="x")
						{$Set.=$QUpdate[$QIndex-1][0]."='".trim($data->val($i, SUBSTR($QUpdate[$QIndex-1][1],-1,1)))."', ";}
						else
						{$Set.=$QUpdate[$QIndex-1][0]."='".$data->val($i, SUBSTR($QUpdate[$QIndex-1][1],-2,2))."', ";}
					}
					else
					{$Set.=$QUpdate[$QIndex-1][0]."='".$QUpdate[$QIndex-1][1]."', ";}
					$QIndex++;
				}
				$Set=SUBSTR($Set,0,-2);

				/////////// Membuat seleksi Qry Seleksi
				$index=1;
				$Wh="";
				while(count($SQry)>=$index)
				{	
					if(substr($SQry[$index-1][1],0,3)=="xxx")
					{$Wh.=$SQry[$index-1][0]."='".$data->val($i, SUBSTR($SQry[$index-1][1],-1,1))."' and ";}
					else
					{$Wh.=$SQry[$index-1][0]."='".$SQry[$index-1][1]."' and ";}
					$index++;
				}
				$Wh=SUBSTR($Wh,0,-4);
			
				$Qry="select * from	$NMTable where $Wh limit 1;";
				
				
				if(_mysql_num_rows(_mysql_query($Qry))>0)
				{			
					$UPDATE="UPDATE $NMTable SET $Set WHERE $Wh LIMIT 1;";
					$Hsl1=_mysql_query($UPDATE);
					if($Hsl1)
					{$sukses1++;$Warna="#CCFFFF";}				
					else
					{$gagal++;$Warna="#FFCC00";}
					$TR.="<TR BGCOLOR='$Warna'>$TD</TR>";
					$Warna="";
				}
				else
				{			
					$INSERT="INSERT INTO $NMTable $QInsert (".SUBSTR($VALUES,0,-2).");";		
					$Hsl2=_mysql_query($INSERT);
					if($Hsl2)
					{$sukses2++;$Warna="#66FF33";}
					else 
					{$gagal++;$Warna="#FFCC00";}
					$TR.="<TR BGCOLOR='$Warna'>$TD</TR>";
					$Warna="";
				}

			}
			//echo $UPDATE."<br>"; 
			//echo $INSERT."<br>"; 
			//echo $Qry."<br>"; 
				
			$sukses1=!empty($sukses1)?$sukses1:0;
			$sukses2=!empty($sukses2)?$sukses2:0;
			$gagal=!empty($gagal)?$gagal:0;
			$lap="<h3>Proses import data selesai.</h3>";
			$lap.="<p>Jumlah data yang sukses diimport : ".$sukses2."<br>";
			$lap.="<p>Jumlah data yang sukses diupdate : ".$sukses1."<br>";
			$lap.="Jumlah data yang gagal diimport : ".$gagal."</p>";
			$lap.="<TABLE WIDTH='98%' HEIGHT='*' CELLSPACING=0 CELLPADDING=3 style='border-collapse:collapse'>$TR</TABLE>";
			return ($lap);
		}

		function antiinjection($data){
			$filter_sql=is_array($data) ? $data : @_mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars(trim($data),ENT_QUOTES))));
	
		  return $filter_sql;
		}
		
		function autolink ($str){
		  $str = str_replace("([[:space:]])((f|ht)tps?:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $str); //http
		  $str = str_replace("([[:space:]])(www\.[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $str); // www.
		  $str = str_replace("([[:space:]])([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","\\1<a href=\"mailto:\\2\">\\2</a>", $str); // mail
		  $str = str_replace("^((f|ht)tp:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "<a href=\"\\1\" target=\"_blank\">\\1</a>", $str); //http
		  $str = str_replace("^(www\.[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "<a href=\"http://\\1\" target=\"_blank\">\\1</a>", $str); // www.
		  $str = str_replace("^([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","<a href=\"mailto:\\1\">\\1</a>", $str); // mail
		  return $str;
		}

		function sensor($teks){
			$w = _mysql_query("SELECT * FROM t_katajelek");
			while ($r = _mysql_fetch_array($w)){
				$teks = str_replace($r['kata'], $r['ganti'], $teks);       
			}
			return $teks;
		}  

		function splittext($isi_komentar="")
		{
			$v_text="";
			$split_text = explode(" ",$isi_komentar);
			$split_count = count($split_text);
			$max = 57;

			for($i = 0; $i <= $split_count; $i++){
			if(@strlen($split_text[$i]) >= $max){
			for($j = 0; $j <= strlen($split_text[$i]); $j++){
			$char[$j] = substr($split_text[$i],$j,1);
			if(($j % $max == 0) && ($j != 0)){
			  $v_text .= $char[$j] . ' ';
			}else{
			  $v_text .= $char[$j];
			}
			}
			}else{
			  $v_text .= " " . @$split_text[$i] . " ";
			}
			}
			return $v_text;
		}
		function validasi($str, $tipe){
			switch($tipe){
				default:
				case'sql':
					$str = stripcslashes($str);	
					$str = htmlspecialchars($str);				
					$str = preg_replace('/[^A-Za-z0-9]/','',$str);				
					return intval($str);
				break;
				case'xss':
					$str = stripcslashes($str);	
					$str = htmlspecialchars($str);
					$str = preg_replace('/[\W]/','', $str);
					return $str;
				break;
			}
		}
		
		function extension($path) {
			$file = pathinfo($path);
			if(file_exists($file['dirname'].'/'.$file['basename'])){
				return $file['basename'];
			}
		}
		
		function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; }
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;}

		function uploadfile_all($FILE_NM="",$FILE_TMP="",$DIREKTORI="",$NMFILE="")
		{
			global $Ket,$NFILE;
			define ("MAX_SIZE","100"); 
			
			$errors=0;	
			if ($FILE_NM) 
			{
				$filename = stripslashes($FILE_NM);
				$extension = $this->getExtension($filename);
				$extension = strtolower($extension);			
					$size=filesize($FILE_TMP);
					//if ($size > MAX_SIZE*2024){$Ket='Maaf, Anda telah melebihi batas ukuran 2 Mb';$errors=1;}
					$image_name=$NMFILE.'.'.$extension;
					$newname=$DIREKTORI.$image_name;
					$copied = @copy($FILE_TMP, $newname);
					if (!$copied) 
					{$Ket='Data gagal di salin!';$errors=1;}				
			}	
			if(!$errors){$Ket="File berhasil di unggah!";$NFILE=$image_name;}
			return $Ket;
			return $NFILE;
		}
		function setSession($name="", $value=""){
			global $_SESSION, $HTTP_SESSION_VARS;
			$_SESSION['sUserId']=$UserID;
		}
		
		function kosongkanData($tabel)
		{
			
			$Query1 = _mysql_query("select * from ".$tabel);
			for ($i = 0; $i < $Query1->columnCount(); $i++) {
				$col = $Query1->getColumnMeta($i);
				$Field = @$col['name'];

				global $$Field;
				@$$Field = "";
			}
		}
		

		

		function timer(){
			$time=1000;
			@session_start();
			$_SESSION['timeout']=time()+$time;
		}
		function hex($str='',$code='') {
		$t=!empty($t)?$t:"";
		  if(($code>=0)and($code<100)) {
			$t .=dechex(strlen($str)+$code)."g";
			$str=strrev($str);
			for($i=0;$i<=strlen($str)-1;$i++) {
			  $t .=dechex(ord(substr($str,$i,1))+$code);
			}
		  }
		  return $t;
		}
		function Login()
		{
			global $Pg,$uLogin,$pLogin,$UserHak,$sUserID,$sUserNm,$sUserHak;
			$xuLogin= trim($this->antiinjection(@$_POST['uLogin']));
			$xpLogin= trim($this->antiinjection(@$_POST['pLogin']));
			$uTahun= trim($this->antiinjection(@$_POST['uTahun']));
			
			$scrt="*&^~53r37";
			$uLogin= $this->antiinjection(@$_POST['uLogin']);
			$pLogin= $this->antiinjection(sha1($scrt.@$_POST['pLogin'].$scrt));
			$pLogin=substr($this->hex(addslashes($pLogin),82), 0, 31);			
			
			$ScreenHeight= trim($this->antiinjection(@$_POST['ScreenHeight']));
			$ScreenWidth= trim($this->antiinjection(@$_POST['ScreenWidth']));

			//$Pg=$this->antiinjection(@$_POST['Pg']);
			if (!empty($uLogin)&&!empty($pLogin)&&!empty($uTahun))
			{				
				$Qry = _mysql_query("SELECT * FROM magang.user_tm WHERE (email='$uLogin' or login='$uLogin') AND password='$pLogin' AND status_id='USR101'");
				if(!_mysql_num_rows($Qry))
				{
					$username = $xuLogin;
					$password = $xpLogin;


					$ldapconfig['host'] = 'ldap.bpkh.go.id';//CHANGE THIS TO THE CORRECT LDAP SERVER
					$ldapconfig['port'] = '389';
					$ldapconfig['basedn'] = 'dc=bpkh,dc=go,dc=id';//CHANGE THIS TO THE CORRECT BASE DN
					$ldapconfig['usersdn'] = 'ou=people';//CHANGE THIS TO THE CORRECT USER OU/CN
					$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);

					ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
					ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
					ldap_set_option($ds, LDAP_OPT_NETWORK_TIMEOUT, 10);

					$dn="uid=".$username.",".$ldapconfig['usersdn'].",".$ldapconfig['basedn'];
					if(isset($username)){
						if ($bind=@ldap_bind($ds, $dn, $password)) {
							if(!empty($username)){
								$UserID=$username;
								$UserNm=$username;$UserHak =1;
							}else{
								 $UserID="";$UserNm="";
							}
							
						} else {
							 $UserID="";$UserNm="";
						}
					}else{
						 $UserID="";$UserNm="";
					}


					
				}
				else
				{						
					$r=_mysql_fetch_array($Qry);$UserID=$r['email'];
					$UserNm=$r['name'];
					if($UserID=="admin@gmail.com"){
						$UserHak =1;					
					}else{
						$UserHak =2;					
					}
					
				}			
				
				if (!empty($UserID) && !empty($UserNm))
				{	
					
					//$_SESSION['KCFINDER']=array();
					//$_SESSION['KCFINDER']['disabled'] = false;
					//$_SESSION['KCFINDER']['uploadURL'] = "../tinymcpuk/gambar";
					//$_SESSION['KCFINDER']['uploadDir'] = "";
					
					$this->timer();
					// session timeout
					$_SESSION['login']=1;
					$sid_lama = session_id();
					$sid_baru = session_id();

					

					$_SESSION['sLoginId']=$xpLogin;
					$_SESSION['sUserId']=$UserID;
					$_SESSION['sUserNm']=$UserNm;
					$_SESSION['sUserHak']=$UserHak;					
					$_SESSION['sTahun']=$uTahun;		
					
					$_SESSION['ScreenHeight']=$ScreenHeight;				
					$_SESSION['ScreenWidth']=$ScreenWidth;		

					$wkt_tgl=date('Y-m-d');
					$wkt_jm=date('Y-m-d H:i:s');
					

					//if (empty($_SESSION['sUserId'])){header("Location:index.php");}
				}
				else{
					//header("Location:".@$Url->BaseUrl."index.php/failed");
					
				}
			}
		}

		function CekLogin()
		{
			global $sUserId,$sUserNm;
			if (isset($sUserId) && isset($sUserNm))
			{
				
				if (!empty($sUserId) && !empty($sUserNm))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		function gFile($file)
		{	
		

			$fd = fopen ($file, "r");
			
			$cIsi = fread ($fd, filesize ($file));
			fclose ($fd);
			return $cIsi;
		}
		function TahunAjaran()
		{	$i=1;
			$DBulan=date("m");
			$DTahun=date("Y");	
			$ABlnRange=array("07","08","09","10","11","12","01","02","03","04","05","06");
			$i=1;
			while(count($ABlnRange)>=$i)
			{
				IF(($ABlnRange[0]<=$DBulan)&&($ABlnRange[5]>=$DBulan)){$TahunAjaran=$DTahun;}ELSE{$TahunAjaran=$DTahun-1;}
				$i++;
			}
			return $TahunAjaran;
		}

		function TglAll($tgl = "")
		{
			global $Ref;
			if(!empty($tgl) and substr($tgl,0,4)!="0000")
			{
				$cHr = $Ref->NamaHari[date("w",mktime(0,0,0,substr($tgl,5,2),substr($tgl,8,2),substr($tgl,0,4)))];
				if($cHr == "Minggu"){$cHr = "<font color=red>$cHr</font>, ";}
				elseif($cHr == "Jum'at"){$cHr = "<font color=green>$cHr</font>, ";}
				else{$cHr = "$cHr, ";}
				return substr($tgl,8,2)." ".$Ref->NamaBulan[(substr($tgl,5,2)*1)-1]." ".substr($tgl,0,4);
			}
			else
			{	return " ";}
		}
		
		function TglHari($tgl = "")
		{
			global $Ref;
			if(!empty($tgl) and substr($tgl,0,4)!="0000")
			{
				$cHr = $Ref->NamaHari[date("w",mktime(0,0,0,substr($tgl,5,2),substr($tgl,8,2),substr($tgl,0,4)))];
				if($cHr == "Minggu"){$cHr = "<font color=red>$cHr</font>, ";}
				elseif($cHr == "Jum'at"){$cHr = "<font color=green>$cHr</font>, ";}
				else{$cHr = "$cHr, ";}
				return $cHr." ". substr($tgl,8,2)." ".$Ref->NamaBulan[(substr($tgl,5,2)*1)-1]." ".substr($tgl,0,4);
			}
			else
			{	return " ";}
		}

		function Tgl($tgl="")
		{
			global $Ref;
			if(!empty($tgl) and substr($tgl,0,4)!="0000")
			{
				return substr($tgl,8,2)." ".$Ref->NamaBulan[(substr($tgl,5,2)*1)-1]." ".substr($tgl,0,4);
			}
			else
			{return " ";}
		}

		function TglInd($Tgl="")
		{
			$Tanggal = !empty($Tgl)?substr($Tgl,8,2)."-".substr($Tgl,5,2)."-".substr($Tgl,0,4):"";
			return $Tanggal;
		}

		function TglSQL($Tgl="")
		{
			$Tanggal = !empty($Tgl)?substr($Tgl,6,4)."-".substr($Tgl,3,2)."-".substr($Tgl,0,2):"";
			return $Tanggal;
		}

		function JConn()
		{	global $SQL;
			$SQL->Konek = @_mysql_connect($SQL->Host,$SQL->User,$SQL->Pwd) or $this->GoError(_mysql_Error());
			if ($SQL->Konek)
			{	$SelectDB = @_mysql_select_db($SQL->Dbs) or GoError(_mysql_Error());
				return true;
			}
			else
			{return false;}
		}

		function GoError($Test)
		{
			global $Error;
			$Text = $Test;
			$Test = true;
			echo "<center>$Test";
			exit;
			return true;
		}

		function FError($Test,$href='javascript:history.back(-1)')
		{
			if (!empty($href))
			{$MyHref="Klik <a href=\"$href\">Back</a> untuk kembali.......";}
			else
			{$MyHref="";}

			$Has = "
				<br><br><br>
				<table border=1 bgcolor=ffaaaa cellpadding=4 cellspacing=0 width=90% align=center>
				<tr>
				<td style='color:ffffff' align=center>
				<b>$Test<br>
				$MyHref
				</td>
				</tr>
				</table>
			";
			return $Has;
		}

		function Grafik($isi=array(),$leg=array(),$wr="")
		{   global $Dir;
			$z=0;
			$max=0;
				foreach($isi as $v)
					{	
						if($v > $z){$max = $v;}
						$z = $max;
					}
					if($max < 80){$tg = 2;}
					if($max < 70){$tg = 3;}
					if($max < 60){$tg = 3;}
					if($max < 50){$tg = 5;}
					if($max < 40){$tg = 5;}
					if($max < 30){$tg = 5;}
					if($max < 20){$tg = 10;}
					if($max < 10){$tg = 20;}
					if($max < 5){$tg = 30;}
					if($max > 79){$tg = 1;}
					if($max > 200){$tg = 1;}
					if($max > 300){$tg = 0.5;}
					if($max > 500){$tg = 0.2;}
					if($max > 1000){$tg = 0.18;}
					if($max > 2000){$tg = 0.17;}

					if(count($isi) < 10){$wd = 30;}else{$wd=10;}

					$Hasil = "<table cellpadding=4 cellspacing=2 bgcolor=aaaaaa align=center><tr><td rowspan=2 bgcolor=000000 >&nbsp</td></tr><tr valign=bottom align=center>";
					$y = 0;
					for($x=0;$x<count($isi);$x++)
						{	$y++;
							if($isi[$x] > 0)
								{$tinggi = $isi[$x]*$tg;}
							else
								{$tinggi=1;}
							$Hasil .= "<td>&nbsp$isi[$x]<br>&nbsp
					<img src='$Dir->Images/graph/$y.jpg' width=$wd height=$tinggi noborder>&nbsp</td>";
						}
					$Hasil .= "<td>&nbsp</td><td align=left>";
					$y=0;
					for($x=0;$x<count($isi);$x++)
						{	$y++;
							if($isi[$x] > 0)
								{$tinggi = $isi[$x]*$tg;}
							else
								{$tinggi=1;}
							$Hasil .= "
					<img src='images/graph/$y.jpg' width=15 height=8 noborder>
					 $leg[$x]<br>";
						}
					$Kol = count($isi)+3;
					$Hasil .=  "</td></tr><tr><td style='height:4' bgcolor=000000 colspan=$Kol></td></tr></table>";
					return $Hasil;
		}

		function txtField($name='txtField',$value='',$maxlength='',$size='20',$type='text',$param='', $addclass='')
		{
			$class="";
			if ($type=="number" || $type=="date" || $type=="text" || $type=="password" || $type=="file" || $type=="datetime-local"){if($size<10){$class="class='form-control  {$addclass}'";}elseif($size<=30){$class="class='form-control {$addclass}'";}elseif($size<=50){$class="class='form-control'";}elseif($size>50){$class="class='form-control {$addclass}'";}}elseif($type=="button" || $type=="submit"){$class="class='btn'";}

			@$Input = "<input $class type=\"$type\" name=\"$name\" id='".@$name."' value=\"$value\" size=\"$size\" maxlength=\"$maxlength\" $param>";
			return $Input;
		}

		function txtFieldId($name='txtField',$value='',$maxlength='',$size='20',$type='text',$param='', $addclass='')
		{
			$class="";
			if ($type=="date" || $type=="text" || $type=="password" || $type=="file"){if($size<10){$class="class='form-control  {$addclass}'";}elseif($size<=30){$class="class='form-control {$addclass}'";}elseif($size<=50){$class="class='form-control'";}elseif($size>50){$class="class='form-control {$addclass}'";}}elseif($type=="button" || $type=="submit"){$class="class='btn'";}

			@$Input = "<input $class type=\"$type\" name=\"$name\" value=\"$value\" size=\"$size\" maxlength=\"$maxlength\" $param>";
			return $Input;
		}

		function txtNumber($name='txtField',$value='',$maxlength='',$size='20',$type='text',$param='', $addclass='')
		{
			$class="";
			if ($type=="date" || $type=="text" || $type=="password" || $type=="file"){if($size<10){$class="class='form-control  {$addclass}'";}elseif($size<=30){$class="class='form-control {$addclass}'";}elseif($size<=50){$class="class='form-control'";}elseif($size>50){$class="class='form-control {$addclass}'";}}elseif($type=="button" || $type=="submit"){$class="class='btn'";}
			@$Input = "<input $class type=\"$type\" name=\"$name\" id='".@$name."' value=\"$value\" size=\"$size\" maxlength=\"$maxlength\" $param onkeyup=\"if(!isNaN(this.value)){ return true; } else{ alert('Maaf, Kolom Harus Diisi Dengan Angka....!'); if(parseFloat(this.value)>0){this.value=parseFloat(this.value);}else{this.value='';}}\">";
			return $Input;
		}
		
		
		function txtArea($name='txtField',$value='',$cols='50',$rows='3',$param='')
		{
			$Input = "<textarea class='txtarea' rows=\"$rows\" cols=\"$cols\" name=\"$name\" id=\"$name\" $param>$value</textarea>";
			return $Input;
		}
		function cKeditor($name='txtField',$value='',$param='')
		{
			/*<div class='snow-editor' name='cK{$name}' id='cK{$name}' style='height: 200px;' onchange='cKval_{$name}()';>
					{$value}
				</div> <!-- end Snow-editor-->
				<input type='text' name='{$name}' id='{$name}'>
				<script>
					
					function cKval_{$name}() {
						var myEditor = document.querySelector('#cK{$name}')
						var html = myEditor.children[0].innerHTML
						document.getElementById('{$name}').value = html;
					}
				</script>*/
			$Input="
				<textarea name='{$name}' style='width:100%;height:150px;' class='form-control' {$param}>$value</textarea>
				
			";
			return $Input;
		}
		function rdJenKel($name='txtField',$value='',$param='')
		{
			$JK = strtoupper($value);
			$SelP = $JK=='P'?" checked ":"";
			$SelL = $JK=='L'?" checked ":"";
			$Input  = "<input type=\"radio\" name=\"$name\" value=\"L\" $SelL $param> Laki-Laki";
			$Input .= "<input type=\"radio\" name=\"$name\" value=\"P\" $SelP $param> Perempuan";
			return $Input;
		}

		function rdAktif($name='txtField',$value='',$param='')
		{
			$AK = strtoupper($value);
			$SelY = $AK=='Y'?" checked ":"";
			$SelN = $AK=='N'?" checked ":"";

			$Input  = "<table>
			<tr>
				<td style='border:0px;'><input type=\"radio\" name=\"$name\" value='Y' $SelY $param></td>
				<td style='border:0px;'>Y</td>
				<td style='border:0px;'><input type=\"radio\" name=\"$name\" value='N' $SelN $param> </td>
				<td style='border:0px;'>N </td>
			</tr>
			</table>
			
			";
//			$Input .= "&nbsp;";
			return $Input;
		}
		
		function radio2D($name='txtField',$value='',$arrList = '',$param='')
		{
			$i=1;$Input="";
			while($i<=count($arrList))
			{	
				$Sel="";
				$check = $value;				
				$Sel = $arrList[$i-1][0]==$check?" checked ":"";
				$Input.= "<input type=\"radio\" name=\"$name\" value=\"{$arrList[$i-1][0]}\" $Sel $param> {$arrList[$i-1][1]}&nbsp;&nbsp;";
				$i++;
			}
			return $Input;
		}

		function radioArray($name='txtField',$value='',$arrList = '',$param='')
		{
			$i=1;$Input="";
			while($i<=count($arrList))
			{	
				$Sel="";
				$check = trim($value);		
				
				$Sel = trim($arrList[$i-1])==$check?" checked ":"";
				$Input.= "<input type=\"radio\" name=\"$name\" value=\"{$arrList[$i-1]}\" $Sel $param> {$arrList[$i-1]}&nbsp;";
				$i++;
			}
			
			return $Input;
		}

		function radioQuery($name='txtField',$value='',$query='',$param='')
		{
			global $Ref;
			$Input = "";
			$Query = _mysql_query($query);
			while ($Hasil=_mysql_fetch_row($Query))
			{
				$Sel="";
				$Sel = $Hasil[0]==$value?" checked ":"";
				$Input.= "<input type=\"radio\" name=\"$name\" value=\"{$Hasil[0]}\" $Sel $param> {$Hasil[1]}&nbsp;";
			}
			return $Input;
		}

		function cmbUmum($name='txtField',$value='',$arrList = '',$param='')
		{
			global $Ref;
			$isi = $value;
			$Input = "<option value=\"\">Pilih</option>";
			for($i=0;$i<count($arrList);$i++)
			{
				$Sel = $isi==$arrList[$i]?" selected ":"no";
				$Input .= "<option $Sel value=\"{$arrList[$i]}\">{$arrList[$i]}</option>";
			}
			$Input  = "<select $param name=\"$name\" class='form-select'>$Input</select>";
			return $Input;
		}

		function cmbUmumById($name='txtField',$value='',$arrList = '',$param='')
		{
			global $Ref;
			$isi = $value;
			$Input = "<option value=\"\">Pilih</option>";
			for($i=0;$i<count($arrList);$i++)
			{
				$Sel = $isi==$arrList[$i]?" selected ":"no";
				$Input .= "<option $Sel value=\"{$arrList[$i]}\">{$arrList[$i]}</option>";
			}
			$Input  = "<select $param name=\"$name\"  id=\"$name\" >$Input</select>";
			return $Input;
		}

		function cmbIndex($name='txtField',$value='',$arrList = '',$param='')
		{
			global $Ref;
			$isi = $value;
			$Input = "<option value=\"\">Pilih</option>";
			for($i=1;$i<=count($arrList);$i++)
			{
				$Sel = $isi==$i?" selected ":"no";
				$Input .= "<option $Sel value=\"$i\">{$arrList[$i-1]}</option>";
			}
			$Input  = "<select $param name=\"$name\"  id=\"$name\">$Input</select>";
			return $Input;
		}

		function cmbIndexKode12($name='txtField',$value='',$arrList = '',$param='')
		{
			global $Ref;
			$isi = $value;
			$Input = "<option value=\"\">Pilih</option>";
			for($i=1;$i<=count($arrList);$i++)
			{
				$Sel = $isi==$i?" selected ":"no";
				$Input .= "<option $Sel value=\"$i\">{$arrList[$i-1]}</option>";
			}
			$Input  = "<select $param name=\"$name\"  id=\"$name\">$Input</select>";
			return $Input;
		}

		function cmbQuery($name='txtField',$value='',$query='',$param='',$Atas='Pilih',$vAtas='')
		{
			global $Ref;
			$Input = "<option value='$vAtas'>$Atas</option>";
			$Query = _mysql_query($query);
			while ($Hasil=@_mysql_fetch_row($Query))
			{

				$Sel = $Hasil[0]==@trim($value)?"selected":"";
				
				$Input .= "<option $Sel value=\"{$Hasil[0]}\">{$Hasil[1]}</option>";
			}
			//
			$Input  = "<select $param name=\"$name\" id=\"$name\"  class='form-select'>$Input</select>";
			return $Input;
		}

		function cmbQueryById($name='txtField',$value='',$query='',$param='',$Atas='Pilih',$vAtas='')
		{
			global $Ref;
			$Input = "<option value='$vAtas'>$Atas</option>";
			$Query = _mysql_query($query);
			while ($Hasil=_mysql_fetch_row($Query))
			{
				$Sel = $Hasil[0]==trim($value)?"selected":"";
				$Input .= "<option $Sel value=\"{$Hasil[0]}\">{$Hasil[1]}";
			}
			$Input  = "<select $param name=\"$name\" >$Input</select>";
			return $Input;
		}

		function cmb2D($name='txtField',$value='',$arrList = '',$param='')
		{
			global $Ref;
			$isi = $value;
			$Input = "<option value=\"\">Pilih</option>";
			for($i=0;$i<count($arrList);$i++)
			{
				$Sel = $isi==$arrList[$i][0]?" selected ":"";
				$Input .= "<option $Sel value=\"{$arrList[$i][0]}\">{$arrList[$i][1]}</option>\n";
			}
			$Input  = "<select $param name=\"$name\"  id=\"$name\" class='form-select'>$Input</select>";
			return $Input;
		}

		function cmb2DNew($name='txtField',$value='',$arrList = '',$param='')
		{
			global $Ref;
			$isi = $value;
			$Input = "<option value=\"\">Pilih</option>";
			for($i=0;$i<count($arrList);$i++)
			{
				$Sel = $isi==$arrList[$i][0]?" selected ":"";
				$Input .= "<option $Sel value=\"{$arrList[$i][0]}\">{$arrList[$i][1]}</option>\n";
			}
			$Input  = "<select $param name=\"$name\">$Input</select>";
			return $Input;
		}

		function txtGrid($name='txtField',$value='',$maxlength='',$size='20',$id='txtField',$no='',$param='')
		{
			$nmid=$id.$no;			
			$awal=$no-1;
			$akhir=$no+1;
			$Input = "<input type=\"text\" name=\"$name\" id=\"$nmid\" value=\"$value\" size=\"$size\" maxlength=\"$maxlength\" $param style='text-align:right;height:22;	background-image:url(./images/txt.gif);	background-repeat:repeat-x;	border:1px solid #CCCCCC;margin:0px;' class='tGrid' onkeydown=\"javascript:KeyFocus(event,'$id{$awal}','$id{$akhir}')\" onkeyup=\"if(!isNaN(this.value)){ return true; } else{ alert('Maaf, Kolom Harus Diisi Dengan Angka....!'); if(parseFloat(this.value)>0){this.value=parseFloat(this.value);}else{this.value='';}}\">";
			return $Input;

		}
		function tabOff($Teks,$Link)
		{
			global $Dir, $Main;
			$Tab = "
				<TABLE cellpadding=0 border=0 cellspacing=0 width='100%'>
				<TR onclick=\"$Link\" style='cursor:hand'>
					<TD style='width:4px;'><IMG SRC='{$Dir->Images}/tabs/tabsekoff1.gif' style='height:21px;width:4px;'></TD>
					<TD align=center background='{$Dir->Images}/tabs/tabsekoff2.gif'>$Teks</TD>
					<TD style='width:4px;'><IMG SRC='{$Dir->Images}/tabs/tabsekoff3.gif' style='height:21px;width:4px;'></TD>
				</TR>
				</TABLE>
			";
			return $Tab;
		}
		function tabOn($Link)
		{
			global $Dir, $Main;
			$Tab = "
				<TABLE cellpadding=0 border=0 cellspacing=0 width='100%' style='margin-left:0px;'>
				<TR>
					<TD style='width:4px;'><IMG SRC='{$Dir->Images}/tabs/tabsekon1.gif' style='height:21px;width:4px;'></TD>
					<TD align=center  background='{$Dir->Images}/tabs/tabsekon2.gif'>$Link</TD>
					<TD style='width:4px;'><IMG SRC='{$Dir->Images}/tabs/tabsekon3.gif' style='height:21px;width:4px;'></TD>
				</TR>
				</TABLE>
			";
			return $Tab;
		}
		
		function tabSplit($text){
			$Tab="
			
				<TABLE cellpadding='0' cellspacing='0'  width='100%' style='margin-top:5px;margin-bottom:5px;'>
				<TR>
					<TD>".$this->tabOn("<b>".strtoupper($text)."</b>")."</TD>			
				</TR>
				</TABLE>
				
			";
			return $Tab;
		}
		function txtCalendar2($name='txtField',$tname="",$value='',$format='dd/mm/yyyy', $param='')
		{
			global $Dir;
			$txt = "
				<script>$(function() { $('#$name').datepick(); });</script>
				<TABLE cellpadding='0' cellspacing='0'>
				<TR>
					<TD style='border:0px;padding:0px;'>
						<input type=\"text\" name=\"$tname\" id=\"$name\" value=\"$value\" size='11' class='txt' style='width:80;border:0px;background:white;text-align:center' $param> 
					</TD>
					<TD style='border:0px;padding:0px;' width='10'>
						<a href=\"#\" onclick=\"$('#$name').datepick('show');\" title=\"Show popup calendar\"><img src=\"{$Dir->Images}/calendar.gif\" border=\"0\" align='left'></a> 
					</TD>
				</TR>
				</TABLE>
			";
			return $txt;
		}
		function txtCalendar($name='txtField',$value='',$format='dd/mm/yyyy', $param='')
		{
			global $Dir;
			$txt = "
				<script>$(function() { $('#$name').datepick(); });</script>
				<TABLE cellpadding='0' cellspacing='0'>
				<TR>
					<TD>
						<input type=\"text\" name=\"$name\" id=\"$name\" value=\"$value\" size='11' placeholder='00-00-0000' class='hasDatepicker' style='width:100px; font-size: 13px;' $param> 
					</TD>
					<TD>
						<a href=\"#\" onclick=\"$('#$name').datepick('show');\" title=\"Show popup calendar\"><img src=\"{$Dir->Images}/calendar.gif\" border=\"0\" align='left'></a> 
					</TD>
				</TR>
				</TABLE>
			";
			return $txt;
		}
		function txtUpload($name = "", $Folder = "./files"){
			global $Dir;
			$txtUpload = "
				<script type='text/javascript'>
				$(function() { 
					$('#uploadify').uploadify({
						'uploader'       : '{$Dir->Js}/jquery/upload/uploadify.swf',
						'script'         : '{$Dir->Js}/jquery/upload/uploadify.php',
						'cancelImg'      : '{$Dir->Js}/jquery/upload/cancel.png',
						'folder'         : '{$Folder}',
						'queueID'        : 'fileQueue',
						'auto'           : false,
						'multi'          : true
					});
				});
				</script>
				<div id='fileQueue'></div>
				<input type='file' name='$name' id='uploadify' />
			";

			return $txtUpload;
		}

		function txtTanggal($name='txtField',$value='', $param='')
		{
			$nTgl = substr($value,8,2);
			$nBln = substr($value,5,2);
			$nThn = substr($value,0,4);
			$txtField = "
				".txtField('tgl$name',$nTgl,'2','2','text')." -
				".txtField('bln$name',$nBln,'2','2','text')." -
				".txtField('thn$name',$nThn,'4','4','text')." Format : DD-MM-YYYY
			";

			return $txtField;
		}
		function txtTanggalSQL($name="txtField")
		{
			$tgl = "tgl$name";
			$bln = "tgl$name";
			$thn = "tgl$name";
			global $$tgl, $$bln, $$thn;
			echo $$tgl;
			$tgl = $$tgl;
			$bln = $$bln;
			$thn = $$thn;

			return $thn."-".$bln."-".$tgl;
		}

		function txtTanggalInd($name="txtField")
		{
			$tgl = "tgl$name";
			$bln = "tgl$name";
			$thn = "tgl$name";
			global $$tgl, $$bln, $$thn;
			$tgl = $$tgl;
			$bln = $$bln;
			$thn = $$thn;
			return $tgl."-".$bln."-".$thn;
		}
		function ViewPesanNew($Pesan = "", $Benar = 1)
		{
			switch($Benar){
				case 1:
					$Pesan ="document.getElementById('click_success').click();";
				break;
				case 2:
					$Pesan = "document.getElementById('click_error').click();";
				break;
				default:
					$Pesan = "document.getElementById('click_warning').click();";
			}

			$Pesan = "<script>$Pesan</script>";
		
			return $Pesan;
		}

		function ViewPesan($Pesan = "", $Benar = 1)
		{
			
			switch($Benar){
				case 1:
					$Pesan ="<div class='informasi toastify on bg-undefined toastify-right toastify-top' style='transform: translate(0px, 0px); top: 15px;'>".$Pesan."</div>";
				break;
				case 2:
					$Pesan = "<div class='informasi toastify on bg-danger toastify-right toastify-top' style='transform: translate(0px, 0px); top: 15px;'>".$Pesan."</div>";
				break;
				default:
					$Pesan = "<div class='informasi toastify on bg-warning toastify-right toastify-top' style='transform: translate(0px, 0px); top: 15px;'>".$Pesan."</div>";
			}
			$Pesan=$Pesan."
				<script>setTimeout(function(){ $('.informasi').hide(); }, 2000);</script>";	
			
			return $Pesan;
		
			
		}
		function Alert($pesan=""){
			echo "<script>alert('$pesan');</script>";
		}
		function mytrim($text="", $trim=" "){
			$awal = substr($text,0,1);
			$akhir = substr($text,strlen($text)-1,strlen($text));
			if ($awal==" "){
				$text = substr($text, 1, strlen($text));
			}
			if ($akhir==" "){
				$text = substr($text, 0, strlen($text)-1);
			}
			return trim($text);
		}

		function IsiSingkat($isi="", $Panjang = 500){
			$isisingkat = "";
			$isi1 = substr($isi,0,$Panjang);
			$isi2 = explode(" ", substr($isi,$Panjang,100));
			$isi = $isi1.$isi2[0]."...";
			$isisingkat = $isi;
			return $isisingkat;	
		}

		function SortHeader($text = ""){
			return "<A HREF='#' onclick=\"SortTabel('#tablesorter')\"><B>$text</B></A>";
		}
		function BelumAdaData($IsiKet="")
		{
			global $Dir;
			return "
				<TABLE cellpadding='0' cellspacing='0' width='100%' align='center'>
				<TR>
					<TD width='15'><img src='{$Dir->Images}/info/info21.gif'></TD>
					<TD style='color:#16418A' background='{$Dir->Images}/info/info22.gif'>
					<CENTER>
						<TABLE>
						<TR>
							<TD><img src='{$Dir->Images}/info/icon_info.gif'></TD>
							<TD><B>&nbsp;&nbsp;$IsiKet</B></TD>
						</TR>
						</TABLE>
					</CENTER>
					</TD>
					<TD width='15'><img src='{$Dir->Images}/info/info23.gif'></TD>
				</TR>
				</TABLE>";
		}

		function getSatuData($Qry = "")
		{
			$Qry = _mysql_query($Qry);
			$data = _mysql_fetch_array($Qry);
			return $data[0];
		}

		function buatPieChart($arData = array(), $arKet = array(), $Judul = "", $Width = 420, $Height = 250, $MapID = 0)
		{
			global $Dir;
			include("{$Dir->Common}/pchart/pChart/pData.class");
			include("{$Dir->Common}/pchart/pChart/pChart.class");

			$DataSet = new pData;
			$DataSet->AddPoint($arData,"Serie1");
			$DataSet->AddPoint($arKet,"Serie2");
			$DataSet->AddAllSeries();
			$DataSet->SetAbsciseLabelSerie("Serie2");

			// Initialise the graph
			$wFR = $Width - 5;
			$hFR = $Height - 5;
			$wRR = $Width - 2;
			$hRR = $Height - 2;
			$wChart = floor((30/100) * $Width);
			$xPos = ($wChart * 2) - 20;
			$yPos = 130;
			$Test = new pChart($Width,$Height);
			$Test->setImageMap(TRUE,$MapID);
			//$Test->drawFilledRoundedRectangle(5,5,$wFR,$hFR,5,240,240,240);
			$Test->drawRoundedRectangle(0,0,$wRR,$hRR,5,50,50,50);
			//$Test->createColorGradientPalette(195,204,56,223,110,41,5);

			// Draw the pie chart
			$Test->setFontProperties("{$Dir->Common}/pchart/Fonts/tahoma.ttf",8);
			$Test->AntialiasQuality = 0;
			$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),$xPos,$yPos,$wChart,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
			$Test->drawPieLegend(10,30,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);	

			// Write the title
			$Test->setFontProperties("{$Dir->Common}/pchart/Fonts/MankSans.ttf",10);
			$Test->drawTitle(10,20,$Judul,0,0,0);
			return $Test->Stroke();
		}
		function buatLineChart($arData = array(), $arKet = array(), $Judul = "", $Width = 420, $Height = 250, $MapID = 0)
		{
			global $Dir;
			$DataSet = new pData;
			for ($i = 0;$i < sizeof($arData);$i++)
			{
				$Ke = $i + 1;
				$DataSet->AddPoint($arData[$i],"Serie$Ke");
				$DataSet->SetSerieName($arKet[$i],"Serie$Ke");
			}
			$DataSet->AddAllSeries();
			$Width = 550;
			$Height = 200;
			$wGA = $Width - 20;
			$hGA = $Height - 30;
			$Test = new pChart($Width,$Height);
			$Test->setImageMap(TRUE,$MapID);
			$Test->setFontProperties("{$Dir->Common}/pchart/Fonts/tahoma.ttf",10);
			$Test->setGraphArea(30,10,$wGA,$hGA);
			$Test->drawGraphArea(252,252,252,TRUE);
			$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);
			$Test->drawGrid(4,TRUE,230,230,230,70);

			// Draw the line graph
			$Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
			$Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);


			// Write the title
			//$Test->setFontProperties("{$Dir->Common}/pchart/Fonts/tahoma.ttf",8);
			//$Test->drawLegend(45,35,$DataSet->GetDataDescription(),255,255,255);
			//$Test->setFontProperties("{$Dir->Common}/pchart/Fonts/tahoma.ttf",10);
			//$Test->drawTitle(60,22,$Judul,50,50,50,585);
			//$Test->Render("{$Dir->Images}/chart/chartline$Ke.jpg");
			return $Test->Stroke();
		}
		function buatBarChart($arData = array(), $arKet = array(), $arNilai = array(), $Judul = "", $Width = 420, $Height = 250, $MapID = 0)
		{
			global $Dir;
			 /* pChart library inclusions */ 
			 include("{$Dir->Common}/pchart/class/pData.class.php"); 
			 include("{$Dir->Common}/pchart/class/pDraw.class.php"); 
			 include("{$Dir->Common}/pchart/class/pImage.class.php"); 

			 /* Create and populate the pData object */ 
			 $MyData = new pData();

			
			 for ($i = 0;$i < count($arData);$i++)
			 {$MyData->addPoints($arNilai[$i],$arData[$i]);}
			
			 $MyData->setAxisName(0,"Jumlah"); 
			 $MyData->addPoints($arKet,"Months"); 
			 $MyData->setSerieDescription("Months","Month"); 
			 $MyData->setAbscissa("Months"); 

			 /* Create the pChart object */ 
			 $myPicture = new pImage(700,230,$MyData); 

			 /* Turn of Antialiasing */ 
			 $myPicture->Antialias = FALSE; 

			 /* Add a border to the picture */ 
			 $myPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0)); 

			 /* Set the default font */ 
			 $myPicture->setFontProperties(array("FontName"=>"{$Dir->Common}/pchart/fonts/pf_arma_five.ttf","FontSize"=>6)); 
			 
			 /* Define the chart area */ 
			 $myPicture->setGraphArea(60,40,650,200); 

			 /* Draw the scale */ 
			 $scaleSettings = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE); 
			 $myPicture->drawScale($scaleSettings); 
				
			 /* Write the chart legend */ 
			 $myPicture->drawLegend(10,12,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 

			 /* Turn on shadow computing */  
			 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

			 /* Draw the chart */ 
			 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 
			 $settings = array("Gradient"=>TRUE,"GradientMode"=>GRADIENT_EFFECT_CAN,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"DisplayR"=>255,"DisplayG"=>255,"DisplayB"=>255,"DisplayShadow"=>TRUE,"Surrounding"=>10); 
			 $myPicture->drawBarChart(); 

			 /* Render the picture (choose the best way) */ 
			// $myPicture->autoOutput("pictures/example.drawBarChart.simple.png"); 
			 return $myPicture->stroke();
		}
		function ambilGambar($filename = "")
		{
			$fr = fread(fopen($filename,'r'),filesize($filename));
			$fr = addslashes($fr);
			return $fr;
			fclose();
		}
		function ambilFoto($tabel = "", $fid = "", $id = "", $width = 100, $height = 100, $fphoto = "photo")
		{
			global $Dir;
			$ph = _mysql_fetch_array(_mysql_query("select $fphoto from $tabel where $fid='$id'"));
			if (!empty($id) && !empty($ph[$fphoto]))
			{
				$width = $width > $height ? $height : $width;
				return "<img src='getimages.php?tabel=$tabel&fid=$fid&id=$id&width=$width&height=$height&fphoto=$fphoto'>";
			}
			else
			{
				return "<img src='{$Dir->Images}/no_photo.jpg' width='$width' $param>";
			}
		}
		function addSlash($text = "")
		{
			$text = addslashes($text);
			return $text;
		}

		function cmbKompetensi($name='txtField',$value='',$query = '',$form='', $param=''){
			global $Dir, $Func;
			$ListKompetensi = "";
			$Q = _mysql_query($query);
			$V = "";
			$nn = 0;
			while ($H = _mysql_fetch_array($Q))
			{
				$V = $value == $H[0] ? $H[1] : $V;
				$bg = $nn % 2 == 0 ? "#FFFFD5" : "";
				$ListKompetensi .= "<A id='a{$name}' HREF='#' onclick=\"{$form}.{$name}.value='{$H[0]}';{$form}.p{$name}.value='{$H[1]}';showHideObjek('#l{$name}');$param\" class='listkom'>{$H[1]}</A><hr size='1' color='#D8D8D8'>";
				$nn++;
			}
			$Input = "
				<div onblur=\"document.getElementById('l{$name}').style.visibility='hidden'\" id='d{$name}'>
					<TABLE cellpadding='0' cellspacing='0'>
					<TR>
						<TD>			
							<input type='hidden' name='$name' value='$value'>
							<input type='text' name='p{$name}' value='$V' id='p{$name}' size='50' class='txt'>&nbsp;&nbsp;
						</TD>
						<TD>
						<!--<img src='{$Dir->Images}/btn_pilih.gif' onclick=\"g_Select.show(event, 'p{$name}', 'l{$name}');\" id='i{$name}'>-->
						<img src='{$Dir->Images}/btn_pilih.gif' onclick=\"showHideObjek('#l{$name}');\" id='i{$name}'>
						*
						</TD>
					</TR>
					</TABLE>
					<div style='position:absolute;width:400px;max-height:200px;background:white;border:1px solid gray;padding:2px;overflow-y:auto;z-index:2;display:none' id='l{$name}'>
						$ListKompetensi
					</div>
				</div>
			";	
			return $Input;
		}

		function txtTglPicker($name='',$value='',$Objek='')
			{		Global $Ref,$Dir;

					if(substr($value,2,1)!='-' || substr($value,2,1)!='/')
						{
							$value = !empty($value)?substr($value,8,2)."/".substr($value,5,2)."/".substr($value,0,4):"";
						}
					$Input = "
					<input readonly type=\"text\" name=\"$name\" value=\"$value\" size=10 maxlength=10>
					<img src='$Dir->Images/calendar.gif' onclick=\"show_calendar('{$Objek}')\"  align=\"absmiddle\" style=\"cursor:hand\">&nbsp";
					return $Input;
			}
		function chkAkhir($name='txtField',$value='',$param='')
			{
				global $Ref;
				$Sel = $value=='1'?" checked ":"";
				$Input  = "<input name=\"$name\" id=\"$name\" value=\"1\" type=\"checkbox\" $Sel $param>";
				return $Input;
			}
		function chkform($name='txtField',$value='',$Isi='',$id='', $param='')
		{
			global $Ref;
			$Sel = $value==$Isi?" checked ":"";
			$Input  = "<input name=\"$name\" id=\"$id\" value='$value' type=\"checkbox\" $Sel $param>";
			return $Input;
		}
		function chkprint($value='',$Isi='')
		{
			global $Ref;
			$Sel = $value==$Isi?" X ":"&nbsp;&nbsp;";
			$Input  = "<span style='border:1px solid black;padding:3px;'>$Sel</span>";
			return $Input;
		}
		function Kotak($Judul="",$Isi="",$Width="",$JenisKotak=0,$MainJudul="")
		{
			global $Main,$Dir, $Mode;
			$JenisKotak=$JenisKotak>0?"_{$JenisKotak}":"_1";
			include "{$Main->Tema}/kotak{$JenisKotak}.inc.php";
			$Kotak = str_replace("<!--Width-->","$Width",$Kotak);
			$Kotak = str_replace("<!--IsiKotak-->","$Isi",$Kotak);
			$Kotak = str_replace("<!--MainJudul-->",$MainJudul,$Kotak);
			$Kotak = str_replace("<!--JudulKotak-->",strtoupper("$Judul"),$Kotak);
			return $Kotak;
		}

		function KotakMode($Judul="",$Isi="",$Width="",$Height="",$JW="84")
		{
			global $Main,$Dir, $Mode;
			$Mode="";
			include "{$Main->Tema}/kotak.inc.php";
			$Kotak = str_replace("<!--Width-->","$Width",$Kotak);
			$Kotak = str_replace("<!--WidthJudul-->","$JW",$Kotak);
			$Kotak = str_replace("<!--IsiKotak-->","$Isi",$Kotak);
			$Kotak = str_replace("<!--JudulKotak-->",strtoupper("$Judul"),$Kotak);
			$Kotak = str_replace("<!--Height-->","$Height",$Kotak);
			return $Kotak;
		}
		function KotakPopUp($Judul="",$Isi="",$Width="",$Height="",$JW="84")
		{
			global $Main,$Dir;
			include "{$Main->Tema}/kotakmenu.inc.php";
			$KotakMenu = str_replace("<!--Width-->","$Width",$KotakMenu);
			$KotakMenu = str_replace("<!--WidthJudul-->","$JW",$KotakMenu);
			$KotakMenu = str_replace("<!--IsiKotak-->","$Isi",$KotakMenu);
			$KotakMenu = str_replace("<!--JudulKotak-->","$Judul",$KotakMenu);
			$KotakMenu = str_replace("<!--Height-->","$Height",$KotakMenu);
			return $KotakMenu;
		}

		function KotakHeader($Judul="",$Isi="",$Width="",$Height="",$JW="84")
		{
			global $Main,$Dir;
			include "{$Main->Tema}/kotakheader.inc.php";
			$KotakHeader = str_replace("<!--Width-->","$Width",$KotakHeader);
			$KotakHeader = str_replace("<!--IsiKotak-->","$Isi",$KotakHeader);
			$KotakHeader = str_replace("<!--JudulKotak-->","$Judul",$KotakHeader);
			$KotakHeader = str_replace("<!--Height-->","$Height",$KotakHeader);
			return $KotakHeader;
		}

		
		function downloat($direktori="",$filename="")
		{
			if(file_exists($direktori.$filename)){
				$file_extension = strtolower(substr(strrchr($filename,"."),1));

				switch($file_extension){
				  case "pdf": $ctype="application/pdf"; break;
				  case "exe": $ctype="application/octet-stream"; break;
				  case "zip": $ctype="application/zip"; break;
				  case "rar": $ctype="application/rar"; break;
				  case "doc": $ctype="application/msword"; break;
				  case "xls": $ctype="application/vnd.ms-excel"; break;
				  case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
				  case "gif": $ctype="image/gif"; break;
				  case "png": $ctype="image/png"; break;
				  case "jpeg":
				  case "jpg": $ctype="image/jpg"; break;
				  default: $ctype="application/proses";
				}

				if ($file_extension=='php'){
				  $return="<h1>Access forbidden!</h1>
						<p>Maaf, file yang Anda download sudah tidak tersedia atau filenya (direktorinya) telah diproteksi</p>";
				  exit;
				}
				else{
				 
				  header("Content-Type: octet/stream");
				  header("Pragma: private"); 
				  header("Expires: 0");
				  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				  header("Cache-Control: private",false); 
				  header("Content-Type: $ctype");
				  header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
				  header("Content-Transfer-Encoding: binary");
				  header("Content-Length: ".filesize($direktori.$filename));
				  readfile("$direktori$filename");
				  exit();   
				}
			}else{
				  $return="<h1>Access forbidden!</h1>
						<p>Maaf, file yang Anda download sudah tidak tersedia atau filenya (direktorinya) telah diproteksi.</p>";
				  exit;
			}
			return $return;
		}
		
		function slideheader()
		{	$IsiSliderHeader="";
			$QHeader=_mysql_query("select * from t_header where aktif='Y' order by id_header  desc");
			while($IsiHeader=_mysql_fetch_array($QHeader))
			{
				$IsiSliderHeader.="
					<li>
						<img src='images/img_header/{$IsiHeader['gbr_header']}' class='random' width='1024' height='300'/>
						<div class='label_text'>
							 <h5>{$IsiHeader['jdl_header']}</h5><p>{$IsiHeader['keterangan']}</p>
						</div>
					</li>
				";
			}
			$slide="			
				<div class='border_box' align=center>
				<div class='box_skitter box_skitter_large34' >
					<ul>$IsiSliderHeader</ul>
				</div>
				</div>
			";
			return $slide; 
		}

	/////////////////////////////////////////////////// fungsi thumb /////////////////////////////////////////
			// Upload gambar untuk berita
			function UploadImage($fupload_name,$lokasi){
			  //direktori gambar
			  $vdir_upload = $lokasi;
			  $vfile_upload = $vdir_upload . $fupload_name;

			  //Simpan gambar dalam ukuran sebenarnya
			  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

			  //identitas file asli
			  $im_src = imagecreatefromjpeg($vfile_upload);
			  $src_width = imageSX($im_src);
			  $src_height = imageSY($im_src);

			  //Simpan dalam versi small 110 pixel
			  //Set ukuran gambar hasil perubahan
			  $dst_width = 110;
			  $dst_height = ($dst_width/$src_width)*$src_height;

			  //proses perubahan ukuran
			  $im = imagecreatetruecolor($dst_width,$dst_height);
			  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

			  //Simpan gambar
			  imagejpeg($im,$vdir_upload . "small_" . $fupload_name);
			  

			  //Simpan dalam versi medium 360 pixel
			  //Set ukuran gambar hasil perubahan
			  $dst_width2 = 390;
			  $dst_height2 = ($dst_width2/$src_width)*$src_height;

			  //proses perubahan ukuran
			  $im2 = imagecreatetruecolor($dst_width2,$dst_height2);
			  imagecopyresampled($im2, $im_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);

			  //Simpan gambar
			  imagejpeg($im2,$vdir_upload . "medium_" . $fupload_name);
			  
			  //Hapus gambar di memori komputer
			  imagedestroy($im_src);
			  imagedestroy($im);
			  imagedestroy($im2);
			}
			
			// Upload file untuk download file
			function UploadFile($fupload_name,$lokasi){
			  //direktori file
			  $vdir_upload = $lokasi;
			  $vfile_upload = $vdir_upload . $fupload_name;

			  //Simpan file
			  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
			}

			function CreateTable($namatable="",$Query=""){
				$Qry=_mysql_query("SHOW CREATE TABLE $namatable;");
				if(@!_mysql_num_rows($Qry)>0)
				{_mysql_query($Query);}
			}

			function MakeDir($DirName="")
			{
				if (!file_exists($DirName)){mkdir($DirName, 0777, true);} 
			}
			/*function UploadBanner($fupload_name){
			  //direktori banner
			  $vdir_upload = "../../../foto_banner/";
			  $vfile_upload = $vdir_upload . $fupload_name;

			  //Simpan gambar dalam ukuran sebenarnya
			  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
			}


			


			// Upload gambar untuk album galeri foto
			function UploadAlbum($fupload_name){
			  //direktori gambar
			  $vdir_upload = "../../../img_album/";
			  $vfile_upload = $vdir_upload . $fupload_name;

			  //Simpan gambar dalam ukuran sebenarnya
			  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

			  //identitas file asli
			  $im_src = imagecreatefromjpeg($vfile_upload);
			  $src_width = imageSX($im_src);
			  $src_height = imageSY($im_src);

			  //Simpan dalam versi small 120 pixel
			  //Set ukuran gambar hasil perubahan
			  $dst_width = 120;
			  $dst_height = ($dst_width/$src_width)*$src_height;

			  //proses perubahan ukuran
			  $im = imagecreatetruecolor($dst_width,$dst_height);
			  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

			  //Simpan gambar
			  imagejpeg($im,$vdir_upload . "kecil_" . $fupload_name);
			  
			  //Hapus gambar di memori komputer
			  imagedestroy($im_src);
			  imagedestroy($im);
			}


			// Upload gambar untuk galeri foto
			function UploadGallery($fupload_name){
			  //direktori gambar
			  $vdir_upload = "../../../img_galeri/";
			  $vfile_upload = $vdir_upload . $fupload_name;

			  //Simpan gambar dalam ukuran sebenarnya
			  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

			  //identitas file asli
			  $im_src = imagecreatefromjpeg($vfile_upload);
			  $src_width = imageSX($im_src);
			  $src_height = imageSY($im_src);

			  //Simpan dalam versi small 100 pixel
			  //Set ukuran gambar hasil perubahan
			  $dst_width = 100;
			  $dst_height = ($dst_width/$src_width)*$src_height;

			  //proses perubahan ukuran
			  $im = imagecreatetruecolor($dst_width,$dst_height);
			  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

			  //Simpan gambar
			  imagejpeg($im,$vdir_upload . "kecil_" . $fupload_name);
			  
			  //Hapus gambar di memori komputer
			  imagedestroy($im_src);
			  imagedestroy($im);
			}


			// Upload gambar untuk sekilas info
			function UploadInfo($fupload_name){
			  //direktori gambar
			  $vdir_upload = "../../../foto_info/";
			  $vfile_upload = $vdir_upload . $fupload_name;

			  //Simpan gambar dalam ukuran sebenarnya
			  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

			  //identitas file asli
			  $im_src = imagecreatefromjpeg($vfile_upload);
			  $src_width = imageSX($im_src);
			  $src_height = imageSY($im_src);

			  //Simpan dalam versi small 54 pixel
			  //Set ukuran gambar hasil perubahan
			  $dst_width = 54;
			  $dst_height = ($dst_width/$src_width)*$src_height;

			  //proses perubahan ukuran
			  $im = imagecreatetruecolor($dst_width,$dst_height);
			  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

			  //Simpan gambar
			  imagejpeg($im,$vdir_upload . "kecil_" . $fupload_name);
			  
			  //Hapus gambar di memori komputer
			  imagedestroy($im_src);
			  imagedestroy($im);
			}

			// Upload gambar untuk favicon
			function UploadFavicon($fupload_name){
			  //direktori favicon di root
			  $vdir_upload = "../../../";
			  $vfile_upload = $vdir_upload . $fupload_name;

			  //Simpan gambar dalam ukuran sebenarnya
			  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
			}*/

	}

	class pageNavi{
			// Fungsi untuk mencek halaman dan posisi data
			function cariPosisi($batas) {
				$REQUEST_URI=$_SERVER['REQUEST_URI'];
				$strpos=strpos($REQUEST_URI,"pagehal-");
				$substrpos=substr($REQUEST_URI,$strpos);
				
				if(empty($strpos)){$GetPageHal=1;}else{$GetPageHal=str_replace("pagehal-","",$substrpos);}
				if(empty($GetPageHal)) {
					$posisi = 0;
					$GetPageHal = 1;
				} else {
					$posisi = ($GetPageHal - 1) * $batas;
				}
				return $posisi;
			}
			
			// Fungsi untuk menghitung total halaman
			function jumlahHalaman($jmldata, $batas) {
				$jmlhalaman = ceil($jmldata/$batas);
				return $jmlhalaman;
			}
			
			// Fungsi untuk link halaman 1,2,3 
			function navHalaman($halaman_aktif, $jmlhalaman, $linkhal) {
				global $link;
				
				$link_halaman = "";
			
				// Link ke halaman pertama (first) dan sebelumnya (prev)
				if($halaman_aktif > 1) {
					$prev = $halaman_aktif - 1;
		
					if($prev > 1) { 
						$link_halaman .= "<a class=\"first\" href=\"{$linkhal}/pagehal-1\"></a>";
					}			
					$link_halaman .= "<a class='btn btn-outline-secondary navipage' href=\"{$linkhal}/pagehal-".$prev."\">Prev</a>";
				}
			
				// Link halaman 1,2,3, ...
				$angka = ($halaman_aktif > 3 ? "<span  class='btn btn-light position-relative navipage'>...</span>" : " "); 
				for($i = $halaman_aktif-2;$i < $halaman_aktif;$i++) {
					if ($i < 1) continue;
					$angka .= "<a href=\"{$linkhal}/pagehal-".$i."\"  class='btn btn-outline-secondary navipage'>".$i."</a>";
				}
				$angka .= "<span class=\"btn btn-primary\">".$halaman_aktif."</span>";
				  
				for($i=$halaman_aktif+1; $i<($halaman_aktif+3); $i++) {
					if($i > $jmlhalaman) break;
					$angka .= "<a href=\"{$linkhal}/pagehal-".$i."\"  class='btn btn-outline-secondary navipage'>".$i."</a>";
				}
				$angka .= ($halaman_aktif+2 < $jmlhalaman ? "<span class='btn btn-light position-relative navipage'>...</span><a href=\"{$linkhal}/pagehal-".$jmlhalaman."\"  class='btn btn-outline-secondary navipage'>".$jmlhalaman."</a>" : " ");
			
				$link_halaman .= $angka;
				
				// Link ke halaman berikutnya (Next) dan terakhir (Last) 
				if($halaman_aktif < $jmlhalaman) {
					$next = $halaman_aktif + 1;
					$link_halaman .= "<a href=\"{$linkhal}/pagehal-".$next."\" class='btn btn-outline-secondary navipage'>Next</a>";
					
					if($halaman_aktif != $jmlhalaman - 1) {
						$link_halaman .= "<a class=\"last\" href=\"{$linkhal}/pagehal-".$jmlhalaman."\"></a>";
					}
				}
				$link_halaman=str_replace("///","/",$link_halaman);
				return $link_halaman;
			}
		}

		class Halaman{
		var $Banyak = 10;
		var $Hal = 1;
		var $Link = "index.php";
		var $Tampil = "#isi";
		var $Query = "";
		var $Qry = "";
		var $Jumlah = 0;
		var $No = 0;
		function buatHalaman(){
			$Mulai = ($this->Hal * $this->Banyak)-$this->Banyak;
			$this->Qry = _mysql_query($this->Query." limit $Mulai,{$this->Banyak}");
			$this->Jumlah = _mysql_num_rows(_mysql_query($this->Query));
			$JmlPage = ceil($this->Jumlah/$this->Banyak);
			$ListPage="";
			for ($i=1;$i<=$JmlPage;$i++)
			{	
				$Sel = $this->Hal == $i ? "selected" : "";
				$ListPage.="<option value='$i' $Sel>$i";
			}
			
			if (!empty($ListPage))
			{
				$ListPage = "
				<TABLE cellpadding='0' cellspacing='0' width='100%'>
				<TR>
					<TD>Jumlah Data : $this->Jumlah</TD>
					<TD align='right'>Halaman <select onchange=\"ambilData('{$this->Tampil}', '{$this->Link}&Hal='+this.options[this.selectedIndex].value);ambilData('{$this->Tampil2}', '{$this->Link}&Hal='+this.options[this.selectedIndex].value)\">$ListPage</select> dari {$JmlPage}</TD>
				</TR>
				</TABLE>";
			}
			$this->No = (($this->Hal-1)*$this->Banyak);

			return $ListPage;
		}
	}
	?>