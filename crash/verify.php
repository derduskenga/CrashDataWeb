<?php

/**
 * File to handle all API requests
 * Accepts GET and POST
 * 
 * Each request will be identified by TAG
 * Response will be JSON data

  /**
 * check for POST request 
 */
if (isset($_REQUEST['tag']) && $_REQUEST['tag'] != '') {
    // get tag
    $tag = $_REQUEST['tag'];

    // include db handler
    include "conn.inc.php";
	require_once 'db_fn.php';
    $db = new DB_Functions();

    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);

    // check for tag type
    if ($tag == 'login') {
        // Request type is check Login
        $job_number = $_REQUEST['job_number'];
        $password = hash('sha256',$_REQUEST['password']);
        
        // check for user
        $user = $db->getUser($job_number, $password);
        if ($user!=false) {
            // user found
            // echo json with success = 1
			//echo "correct";
			session_start();
            $response["success"] = 1;
            $response["full_names"] = $user["full_names"];
			$response["job_number"] = $user["job_number"];
			$response["user_level"] = $user["user_level"];
			$response["date_time"] = $user["date_time"];
			
		//	$response["sid"] = session_id();
			
			$_SESSION["user_logged"] = $user["full_names"];
			$_SESSION["job_number"] = $user["job_number"];
			$_SESSION["user_level"] = $user["user_level"];
			$_SESSION["date_time"] = $user["date_time"];
			$_SESSION["user_password"] = $user["password"];
          //  echo json_encode($response);
			
			header ("Refresh: 5; URL=" . $_REQUEST['redirect'] . "");
			echo "You are being redirected to your original page request!<br>";
			echo "(If your browser doesn't support this, " .
				//"<a href=\"index.php\">click here</a>)";
				"<a href=\"" . $_REQUEST['redirect']. "\">click here</a>)";
        } else {
            // user not found
            // echo json with error = 1
            $err["error"] = 1;
            $err["error_msg"] = "Incorrect Job Number or Password!";
            echo json_encode($err);
			header ("Refresh: 5; URL=" . $_REQUEST['redirect'] . "");
			echo "You are being redirected to your original page request!<br>";
			echo "(If your browser doesn't support this, " .
				//"<a href=\"index.php\">click here</a>)";
				"<a href=\"" . $_REQUEST['redirect']. "\">click here</a>)";
        }
    } 
	
	else if ($tag == 'register') {
        // Request type is check Login
        $first_name = $_REQUEST['first_name'];
        $last_name = $_REQUEST['last_name'];
		$job_number = $_REQUEST['job_number'];
        $password = $_REQUEST['password'];
		$user_level = $_REQUEST['user_level'];
		
		$full_names = $first_name." ".$last_name;
        
        // check if user is already existed
        if ($db->isUserExisted($job_number)) {
            // user is already existed - error response
            $response["error"] = 2;
            $response["error_msg"] = "User already exists";
            echo json_encode($response);
        } else {
            // store user
            $user = $db->registerUser($full_names, $job_number, $password, $user_level);
            if ($user != false) {
                // user stored successfully
				//session_start();
                $response["success"] = 1;
				$response["success_msg"] = "New User registered successfully";
                $response["user"]["full_names"] = $user["full_names"];
				$response["user"]["job_number"] = $user["job_number"];
				$response["user"]["user_level"] = $user["user_level"];
				$response["user"]["date_time"] = $user["date_time"];
								
				
				header ("Refresh: 5; URL=" . $_REQUEST['redirect'] . "");
				echo "You are being redirected to your original page request!<br>";
				echo "(If your browser doesn't support this, " .
					//"<a href=\"index.php\">click here</a>)";
					"<a href=\"" . $_REQUEST['redirect']. "\">click here</a>)";
                echo json_encode($response);
            
			} else {
                // user failed to store
                $err["error"] = 1;
                $err["error_msg"] = "Error occured in Registration";
                echo json_encode($err);
				
				header ("Refresh: 5; URL=" . $_REQUEST['redirect'] . "");
				echo "You are being redirected to your original page request!<br>";
				echo "(If your browser doesn't support this, " .
					//"<a href=\"index.php\">click here</a>)";
					"<a href=\"" . $_REQUEST['redirect']. "\">click here</a>)";
            }
        }
		
		
    }
	
	else if ($tag == 'casualty') {
        // Request type is check Login
        $first_name = $_REQUEST['first_name'];
        $last_name = $_REQUEST['last_name'];
		$acc_id = $_REQUEST['acc_id'];
        $gender = $_REQUEST['gender'];
		$status = $_REQUEST['status'];
		$age_group = $_REQUEST['age'];
		$nationality = $_REQUEST['nationality'];
				
		$full_names = $first_name." ".$last_name;
		//$full_names = $first_name;
        
        // check if accident exists
        if ($db->isAccidentExisted($acc_id)) {
			
			 // store casualty
            $user = $db->registerCasuality($acc_id, $full_names, $gender, $status, $age_group, $nationality);
            if ($user) {
                // casualty stored successfully
				
                $response["success"] = 1;
				$response["success_msg"] = "New Casualty registered successfully";
         /*       $response["user"]["full_names"] = $user["full_names"];
				$response["user"]["job_number"] = $user["job_number"];
				$response["user"]["user_level"] = $user["user_level"];
				$response["user"]["date_time"] = $user["date_time"];
				*/
				
				echo json_encode($response);								
				
				header ("Refresh: 5; URL=" . $_REQUEST['redirect'] . "");
				echo "You are being redirected to your original page request!<br>";
				echo "(If your browser doesn't support this, " .
					//"<a href=\"index.php\">click here</a>)";
					"<a href=\"" . $_REQUEST['redirect']. "\">click here</a>)";
                
            
			} else {
                // user failed to store
                $err["error"] = 1;
                $err["error_msg"] = "Error occured in Registering casualty";
                echo json_encode($err);
				
				header ("Refresh: 5; URL=" . $_REQUEST['redirect'] . "");
				echo "You are being redirected to your original page request!<br>";
				echo "(If your browser doesn't support this, " .
					//"<a href=\"index.php\">click here</a>)";
					"<a href=\"" . $_REQUEST['redirect']. "\">click here</a>)";
            }
            
            
        } else {
			$response["error"] = 2;
            $response["error_msg"] = "Accident does not exist";
            echo json_encode($response);
			
			header ("Refresh: 5; URL=" . $_REQUEST['redirect'] . "");
				echo "You are being redirected to your original page request!<br>";
				echo "(If your browser doesn't support this, " .
					//"<a href=\"index.php\">click here</a>)";
					"<a href=\"" . $_REQUEST['redirect']. "\">click here</a>)";
           
        }
		
		
    }
				
	else {
        echo "Invalid Request";
    }
} 

else {
    echo "Access Denied";
}
?>
