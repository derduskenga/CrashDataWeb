<?php

include_once('DB_connect.php');

//acident ID is
    $accident_ID= $_REQUEST['accident_ID'];
//.......................................//
	$photo_name = $_REQUEST['photo_name'];
	$base=$_REQUEST['image'];
    $binary=base64_decode($base);
    header('Content-Type: bitmap; charset=utf-8');
    $file = fopen('photo/'.$photo_name.'.jpg', 'wb');
    fwrite($file, $binary);
    fclose($file);
	$file_path = "photo/".$photo_name.".jpg";
    //echo 'Image upload complete!!, Please check your php file directory…… ' . $file_path;
	echo upload_photo($accident_ID, $photo_name, $file_path);
	
	function upload_photo($accident_ID, $photo_name, $file_path){
		$message = "";
		//$query = "select license_number,full_name from driver where license_number='$driver_lisence'";
		 $result =  $result = mysql_query("INSERT INTO photos( crash_id, photo_name, photo_reference)
					VALUES(' $accident_ID', '$photo_name', '$file_path') ");
		
		//$result = mysql_query($query) or die("Query failed" . mysql_error());
		
		/*if(mysql_num_rows($result)>0){
			while($row = mysql_fetch_array($result)){
					
				$message = $photo_name. " uploaded to database";
			}
		}else{
			$message= $photo_name." not uploaded to database";		
		}
		
		return $message;	
		*/
		if($result){
					
			$message = $photo_name. " uploaded to database";
			
		}else{
			$message= $photo_name." not uploaded to database";		
		}
		
		return $message;
	
	
	}
?>