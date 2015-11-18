<?php

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
    echo "Image upload complete!!";
?>