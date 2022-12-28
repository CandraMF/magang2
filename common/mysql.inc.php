<?php
	function _mysql_query($query){
		$return=$GLOBALS['conn']->query($query);

		$Inputquery=htmlentities($query, ENT_QUOTES);
		$SelectFilter=trim(strtoupper(substr($query,0,6)));
		if($SelectFilter!="SELECT"){
			$ParamsUserId=@$_SESSION['sUserId'];
			$GLOBALS['conn']->query("INSERT INTO __log_aktifitas (username, waktu, query, action, ipaddress) VALUES ('{$ParamsUserId}', now(), '".$Inputquery."', '".$SelectFilter."', '".$_SERVER['REMOTE_ADDR']."');");
		} 
		return $return;
	}
	function _mysql_fetch_array($result){
		$return=$result->fetch_assoc();
		return $return; 
	}

	function _mysql_num_rows($result){
		$return=@$result->num_rows;
		return $return; 
	}
	function _mysql_real_escape_string($result){
		$return=$GLOBALS['conn']->real_escape_string($result);
		
		return $return; 
	}

	function _mysql_fetch_field($result){
		$return=$result->fetch_field();
		return $return; 
	}

	function _mysql_fetch_row($result){
		$return=$result->fetch_row();
		return $return; 
	}
	
	
?>