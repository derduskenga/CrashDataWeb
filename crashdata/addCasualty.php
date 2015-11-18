<?php

	include_once('DB_connect.php');
	
	/*$accident_ID = $_POST['accident_ID'];
	$fname = $_POST['fname'];
	$gender = $_POST['gender'];
	$ageGroup = $_POST['ageGroup'];
	$nationality = $_POST['nationality'];
	$status = $_POST['status']; */
	
	
	$accident_ID = "xxxxx";
	$fname = "derdus";
	$gender = "male";
	$ageGroup = "25-30 years";
	$nationality = "kenyan";
	$status = "slightly injured";
	
	
	$mydateObj=getdate(date("U"));
	$d = $mydateObj['mday'];
	$m = $mydateObj['mon'];
	$y = $mydateObj['year'];
	
	
	$_date = $d . "-" . $m . "-" . $y;
	
	addCasualty($accident_ID,$fname,$status,$gender,$ageGroup,$_date,$nationality);
	
	function addCasualty($accident_ID,$fname,$status,$gender,$ageGroup,$_date,$nationality){
	
		$query = "insert into casuality 
			(crash_id,full_names,status,age_group,_date,nationality)
			values('$accident_ID','$fname','$status','$ageGroup','$_date','$nationality')";
		$result = mysql_query($query) or die("Failed query " . mysql_error());
		
		if($result){
			echo "Casualty has been added";
		}else{
			echo "An Error occured while adding casualty";
		}
	
	}

?>