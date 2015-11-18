<?php
	include_once('DB_connect.php');
	
	$driver_lisence = $_REQUEST['license_number'];
	//$driver_lisence = "1608254";
	
	echo driverNameIs($driver_lisence);
	
	function driverNameIs($driver_lisence){
		$message = "";
		$query = "select license_number,full_name from driver where license_number='$driver_lisence'";
		
		$result = mysql_query($query) or die("Query failed" . mysql_error());
		
		if(mysql_num_rows($result)>0){
			while($row = mysql_fetch_array($result)){
			
				$driver_name=$row['full_name'];

				$message .=$driver_name;
			}
		}else{
			$message="";		
		}
		
		return $message;	
	
	
	}




?>