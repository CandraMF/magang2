<?php
	/////////////// Slide Header 	
	$Main->Script="
	<link rel='stylesheet' type='text/css' href='{$Dir->Css}/default.css'>
	<link rel='stylesheet' type='text/css' href='{$Dir->Css}/pageNavi.css'>
	<script>function next(ID){if (event.keyCode == 13)document.getElementById(ID).focus();}</script>
	";

	$Main->Script2="
		<style>
			#facebox{
				z-index:10;
			}
		</style>
		<!-- Imat-Jquery -->
			
			<script src='{$Dir->Library}/imat-jquery/grid.js' type='text/javascript'></script>
			<script language='javascript' src='{$Dir->Library}/imat-jquery/basescript.js'></Script>
		
			
			<script src='{$Dir->Library}/imat-jquery/jquery/jquery.tablesorter.min.js' type='text/javascript'></script>
			<script src='{$Dir->Library}/imat-jquery/jquery/jquery.datepick.js' type='text/javascript'></script>
			<script src='{$Dir->Library}/imat-jquery/jquery/jquery.datepick-id.js' type='text/javascript'></script>
			<script src='{$Dir->Library}/imat-jquery/jquery/jquery.elastic.js' type='text/javascript'></script>
			<script src='{$Dir->Library}/imat-jquery/jquery/fcbkcomplete.min.js' type='text/javascript'></script>

			<script type='text/javascript' src='{$Dir->Library}/imat-jquery/jquery/upload/swfobject.js'></script>
			<script type='text/javascript' src='{$Dir->Library}/imat-jquery/jquery/upload/jquery.uploadify.v2.1.0.min.js'></script>
			<script type='text/javascript' src='{$Dir->Library}/imat-jquery/jquery.form.js'></script>
			<script src='{$Dir->Library}/imat-jquery/imatjquery.js' type='text/javascript'></script>

			<link rel='stylesheet' type='text/css' href='{$Dir->Library}/imat-jquery/jquery/stylefcbk.css'>
			<link rel='stylesheet' type='text/css' href='{$Dir->Library}/imat-jquery/jquery/jquery.datepick.css'>
			
			<link rel='stylesheet' type='text/css' href='{$Dir->Library}/imat-jquery/jquery/themes/blue/style.css'>	
			
			<link rel='stylesheet' href='{$Dir->Library}/autocomplete/themes/base/jquery.ui.all.css'>
			<script src='{$Dir->Library}/autocomplete/ui/jquery.ui.core.js'></script>
			<script src='{$Dir->Library}/autocomplete/ui/jquery.ui.widget.js'></script>
			<script src='{$Dir->Library}/autocomplete/ui/jquery.ui.button.js'></script>
			<script src='{$Dir->Library}/autocomplete/ui/jquery.ui.position.js'></script>
			<script src='{$Dir->Library}/autocomplete/ui/jquery.ui.autocomplete.js'></script>
				
	";
?>