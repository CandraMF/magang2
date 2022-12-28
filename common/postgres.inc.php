<?php
	function _mysql_query($query){
	
		$query=str_replace("''","null",$query);
		//echo $query."<br>";
		$return=$GLOBALS['conn']->query($query);


		return $return;
	}
	function _mysql_fetch_array($result){
		$return=$result->fetch(\PDO::FETCH_ASSOC);		
		return $return; 
	}

	function _mysql_num_rows($result){
		$return=@$result->rowCount();
		return $return; 
	}
	function _mysql_real_escape_string($result){
		$return=pg_escape_string($result);
		
		return $return; 
	}

	function _mysql_fetch_field($result){
		$return=$result->fetch_field();
		return $return; 
	}

	function _mysql_fetch_row($result){
		$return=$result->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_LAST);
		return $return; 
	}
	
	
?>