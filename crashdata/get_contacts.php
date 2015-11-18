<?php
	include_once './include/DB_Connect.php';
	include_once('DB_connect.php');

function getContacts(){
    $db = new DB_Connect();
    // array for json response
    $response = array();
    $response["contacts"] = array();
    
    // Mysql select query
    $result = mysql_query("SELECT * FROM emergency") or die("Query failed " . mysql_error());
    
    while($row = mysql_fetch_array($result)){
        // temporary array to create single category
        $tmp = array();
        $tmp["emergency_id"] = $row["emergency_id"];
        $tmp["respondent"] = $row["respondent"];
		$tmp["phone_number"] = $row["phone_number"];
        
        // push category to final json array
        array_push($response["contacts"], $tmp);
    }
    
    // keeping response header to json
    header('Content-Type: application/json');
    
    // echoing json result
    echo json_encode($response);
}

getContacts();
?>