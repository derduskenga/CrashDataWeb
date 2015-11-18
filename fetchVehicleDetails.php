<?php
	
	include_once('DB_connect.php');
	//$vReg = "KBX345R";
	
	$vReg = $_POST['vReg'];
	
	$vReg = str_replace(" ","",$vReg);
	$str_from_DB = get_vehicleDetails($vReg);
	echo trim($str_from_DB);
	
	
	function get_vehicleDetails($vReg){
		$message = "";
		$query = "select reg_number,model,vehicle_type,owned_by from vehicle where reg_number='$vReg'";
		
		$result = mysql_query($query) or die("Query failed" . mysql_error());
		
		if(mysql_num_rows($result)>0){
		
			while($row = mysql_fetch_array($result)){
					
				
				$vehicle_type=$row['model'];
				$vehicle_model=$row['vehicle_type'];
				$registered_to=$row['owned_by'];
				
				$message=$vehicle_type . "," . $vehicle_model . "," . $registered_to . ",";
			}
		}else{
		
			$message= "" . "," . "". "," . "" . ",";		
		}
		
		return $message;	
	
	}

?>