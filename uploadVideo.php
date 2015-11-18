<?php
   // $base=$_REQUEST['image'];
//$binary=base64_decode($base);
//header('Content-Type: bitmap; charset=utf-8');
//$file = fopen('uploaded_image.jpg', 'wb');
//fwrite($file, $binary);
//fclose($file);
//echo "Video upload complete!!, Please check your php file directory……";
// Where the file is going to be placed



//$accident_id=$_POST[''];
$target_path = "./video/";
/* Add the original filename to our target path.
Result is "uploads/filename.extension" */

$x1=basename( $_FILES['uploadedfile']['name']);

//the accident ID is
$accident_id= substr($x1,23,22);

//...................//
$x2=substr($x1,0,23);

$target_path = $target_path . $x2;

 
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "The file ". $x2 .
    " has been uploaded and its file path is ".$target_path. "Accident id " . $accident_id;
} else{
    echo "There was an error uploading the file, please try again!";
    echo "filename: " .  basename( $_FILES['uploadedfile']['name']);
    echo "target_path: " .$target_path. "Accident id " . $accident_id;
}
?>