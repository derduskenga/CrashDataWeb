<?php
	include_once('DB_connect.php');

	require 'Classes/PHPExcel.php';
	
	require_once 'Classes/PHPExcel/IOFactory.php';
	
	$uploaddir = "files/";
	
	$mydateObj=getdate(date("U"));
	$d = $mydateObj['mday'];
	$m = $mydateObj['mon'];
	$y = $mydateObj['year'];
	
	
	$_date = $d . "-" . $m . "-" . $y;
	//echo $_date;
	
	$uploadfile = $uploaddir . basename($_FILES['myfile']['name']);

	if(move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadfile)){
  		echo "The file has been uploaded successfully" . $uploadfile;

	$inputFileName = strtolower($_FILES['myfile']['name']);
	//$inputFileName = 'files/test.xlsx';
	$i=0;
	$dataArray=array();
	
	
	$objPHPExcel = PHPExcel_IOFactory::load($uploadfile);
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

    $worksheetTitle = $worksheet->getTitle();
    $highestRow = $worksheet->getHighestRow(); 
    $highestColumn= $worksheet->getHighestColumn(); 
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $nrColumns = ord($highestColumn) - 64;
    echo "<br>The worksheet ".$worksheetTitle." has ";
    echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
    echo ' and ' . $highestRow . ' records.';
    echo '<br>Data: <table border="1"><tr>';
	
    for ($row = 2; $row <= $highestRow; ++ $row) {
        echo '<tr>';
        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = strtolower($cell->getValue());
            $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
			
            echo "<td>" . strtolower($val) . "</td>";
			 
			 array_push($dataArray,$val);
			$i++;
          }
           echo '</tr>';
		  
		   
        }
		
		
      echo '</table>';
	
	}
	
	//number of columns in 
	$numberOfColumns = 6;
	
	//echo "<br> Number of elements is " . $i . "<br>";
	
	$k=0;
	
	do{
			//echo $dataArray[$k] . "," . $dataArray[$k+1] . "," . $dataArray[$k+2] . "," . $dataArray[$k+3] . "," . $dataArray[$k+4] . "," . $dataArray[$k+5] . "<br>";
			$feedback = putToDB($dataArray[$k],strtoupper($dataArray[$k+1]),$dataArray[$k+2],$dataArray[$k+3],generateAgeBrackets($dataArray[$k+4]),$_date,$dataArray[$k+5]);
	
		$k+=6;
	}while($k<$i);
	
	echo $feedback;
	
		}else{
		
  		echo "There was an error uploading the file";
	}
	
	
	function putToDB($crash_id,$full_name,$gender,$status,$age,$_date,$nationality){
	
	
		$message = "";
		$query = "INSERT INTO casuality(crash_id,full_names,gender,status,age_group,_date,nationality)
				VALUE('$crash_id','$full_name','$gender','$status','$age','$_date','$nationality')";
				
		$result = mysql_query($query) or die("Query failed" . mysql_error());
		
		if($result){
			$message .= "Your data has been saved succesifully";
		}else{
			$message .= "There was an error while uploading your data. Try again!";
		}
		
		return $message;
	
	}
	
	function generateAgeBrackets($age){
	
		$ageGroup = "";
		
		if($age<6){
			$ageGroup = "0-5 years";
		}else if($age<11){
			$ageGroup = "6-10 years";
		}else if ($age<17){
			$ageGroup = "11-16 years";
		}else if ($age<26){
			$ageGroup = "17-25 years";
		}else if ($age<36){
			$ageGroup = "26-35 years";
		}else if ($age<46){
			$ageGroup = "36-45 years";
		}else if ($age<56){
			$ageGroup = "46-55 years";
		}else if ($age<66){
			$ageGroup = "56-65 years";
		}else if($age>65){
			$ageGroup = "over 65 years";
		}
		
		return strtolower($ageGroup);
	}
	

?>