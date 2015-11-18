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
    $tag = $_REQUEST['tag'];///////////////////////////////////////////////////================
	

    // include db handler
    require_once 'include/DB_Functions.php';
    $db = new DB_Functions();

    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);
	$message = '';

    // check for tag type
    if ($tag == 'login') {
        // Request type is check Login
        $job_number = $_POST['job_number'];
        $password = $_POST['password'];
        
        // check for user
        $user = $db->getUser($job_number, $password);
        if ($user != false) {
            // user found
            // echo json with success = 1
			
            //$response["success"] = 1;
			$message='success';
            
            //echo json_encode($response);
			echo $message;
        } else {
            // user not found
            // echo json with error = 1
            //$response["error"] = 1;
            //$response["error_msg"] = "Incorrect Job Number or Password!";
            //echo json_encode($response);
			$message='failed';
			echo $message;
        }
    } 
	
	else if ($tag == 'new_user') {
        // Request type is Register new user        
		$full_names = $_REQUEST['full_names'];
		$job_number = $_REQUEST['job_number'];
		$user_level = $_REQUEST['user_level'];
		$password = $_REQUEST['password'];
		
		
        // check if user is already existed
        if ($db->isUserExisted($job_number)) {
            // user is already existed - error response
            $response["error"] = 2;
            $response["error_msg"] = "User already exists";
            echo json_encode($response);
        } else {
            // store user
            $user = $db->registerUser($full_names, $job_number, $password, $user_level);
            if ($user) {
                // user stored successfully
				
                $response["success"] = 1;
				$response["success_msg"] = "New User registered successfully";
                
                echo json_encode($response);
            
			} else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in Registration";
                echo json_encode($response);
            }
        }
		
		
    }else if($tag == 'casualty'){
	
		$accident_ID = $_POST['accident_ID'];
		$fname = $_POST['fname'];
		$gender = $_POST['gender'];
		$ageGroup = $_POST['ageGroup'];
		$nationality = $_POST['nationality'];
		$status = $_POST['status'];
	
		//$accident_ID = "xxxxx";
		//$fname = "derdus";
		//$gender = "male";
		//$ageGroup = "25-30 years";
		//$nationality = "kenyan";
		//$status = "slightly injured";
		
		$mydateObj=getdate(date("U"));
		$d = $mydateObj['mday'];
		$m = $mydateObj['mon'];
		$y = $mydateObj['year'];
		
		$_date = $d . "-" . $m . "-" . $y;
		
		$user = $db->addCasualty($accident_ID,$fname,$status,$gender,$ageGroup,$_date,$nationality);
	}
	
	else if ($tag == 'acc_det') {
        // Request type is check Login
        $road_signs = $_POST['road_signs'];//acc
		$road_surface= $_POST['road_surface'];//acc
		$other_sign= $_POST['other_sign'];//acc
		$accident_ID= $_POST['accident_ID'];//
		$area_name= $_POST['area_name'];//loc //acc
		$landmark= $_POST['landmark'];//loc
		$date_of_accident= $_POST['date_of_accident'];//acc
		$time_of_accident= $_POST['time_of_accident'];//acc
		$date_of_record= $_POST['date_of_record'];//acc
		$number_of_vehicles= $_POST['number_of_vehicles'];//acc
		$hit_n_run = $_POST['hit_n_run'];//acc
		$severity= $_POST['severity'];//acc
		$pre_crush_event= $_POST['pre_crush_event'];//acc
		$crash_configuration= $_POST['crash_configuration'];//acc
		$weather_conditions= $_POST['weather_conditions'];//acc
		$illumination= $_POST['illumination'];//acc
		$region_name= $_POST['region_name'];//loc
	
		//not yet passed
		$latitude= $_POST['lat'];//loc
		$longitude= $_POST['lng'];//loc
		$job_number= $_POST['jno'];//acc
				
		$cause_code="null";
		$remarks="null";
		$m_acc_det="";
        
        // check if accident exists
        if ($db->isAccidentExisted($accident_ID)) {
			
            $response["error"] = 2;
            $response["error_msg"] = "Accident already exists";
            echo json_encode($response);            
            
        } else {
			
			$acc = $db->registerAccident($accident_ID, $area_name, $time_of_accident, $date_of_accident, $date_of_record, $number_of_vehicles, $severity, $crash_configuration, $illumination, $weather_conditions, $road_signs, $other_sign, $road_surface, $hit_n_run, $pre_crush_event, $cause_code, $remarks, $job_number);
            
				
                //$response["success"] = 1;
				//$response["success_msg"] = "New Accident registered successfully";
               				
				//echo json_encode($response);
				
			//} else {
				
                //$err["error"] = 1;
                //$err["error_msg"] = "Error occured in Registering Accident";
                //echo json_encode($err);
            //}
			
			
			$loc = $db->registerCrashLocation( $accident_ID, $longitude, $latitude, $area_name, $landmark, $region_name, $date_of_accident);
           //if ($loc) {
				
                //$response["success"] = 1;
				//$response["success_msg"] = "Crash location registered successfully";
               				
				//echo json_encode($response);
				
			//} else {
				
                //$err["error"] = 1;
                //$err["error_msg"] = "Error occured in Registering Crash Location";
                //echo json_encode($err);
            //}
			
			if($loc && $acc){
				echo "New Accident registered successfully";
			}else{
				echo "Error occured while creating a new accident";
			}
           
        }
		
		
    }
	if ($tag == 'test') {
        // Request type is check Login
        $accident_ID = $_REQUEST['accident_ID'];
        
        $veh = $db->registerCrashVehicle( 'kBr 456y', $accident_ID, 1,5,8, 'proper', 'none', 'heritage', 'abjjkllkky', 'no', 'none', 'truck', 'tata', 'nakumatt');
            if ($veh) {
				
                $response["success"] = 1;
				$response["success_msg"] = "Crash Vehicle registered successfully";
               				
				echo json_encode($response);
				
			} else {
				
                $err["error"] = 1;
                $err["error_msg"] = "Error occured in Registering Crash Vehicle";
                echo json_encode($err);
            }
    } 
		
	else if ($tag == 'dri_veh') {
        $accident_ID = $_POST['accident_ID'];	
		$deaths= $_POST['deaths']; //acc veh
		$s_injuries= $_POST['s_injuries'];//acc //veh
		$m_injuries= $_POST['m_injuries'];//acc
		$driver_name= $_POST['driver_name'];//acc //dri
		$d_license_no= $_POST['d_license_no'];//dri
		$discrepancy= $_POST['discrepancy'];//veh
		$driver_dead_yes_no = $_POST['driver_dead_yes_no'];//dr
		$alcohol_test= $_POST['alcohol_test'];//dri
		$driver_gender= $_POST['driver_gender'];//dri
		$driver_s_injured_yes_no= $_POST['driver_s_injured_yes_no'];//dri
		$insurance_expired= $_POST['insurance_expired'];//veh
		$insurance_name= $_POST['insurance_name'];//veh
		$registered_to= $_POST['registered_to'];//veh
		$vehicle_model= $_POST['vehicle_model'];//veh
		$vehicle_insurance_policy_no= $_POST['vehicle_insurance_policy_no'];
		$other_insurance= $_POST['other_insurance'];//veh
		$vehicle_reg_number= $_POST['vehicle_reg_number'];//acc //veh
		$vehicle_type= $_POST['vehicle_type'];
		$loading= $_POST['loading'];//veh
		$vehicle_defect= $_POST['vehicle_defect'];//veh 
		
		
		$mydateObj=getdate(date("U"));
		$d = $mydateObj['mday'];
		$m = $mydateObj['mon'];
		$y = $mydateObj['year'];
		
		$_date = $d . "-" . $m . "-" . $y;
		
        // check if accident exists
        if ($db->isAccidentExisted($accident_ID)) {
			
            $dri = $db->registerCrashDriver($d_license_no, $driver_name, $accident_ID, $vehicle_reg_number, $driver_dead_yes_no, $driver_s_injured_yes_no, $driver_gender, $alcohol_test);
			
           // if ($dri) {
				
               // $response["success"] = 1;
				//$response["success_msg"] = "New Crash Driver registered successfully";
               				
				//echo json_encode($response);
				
			//} else {
				
               // $err["error"] = 1;
               // $err["error_msg"] = "Error occured in Registering Crash Driver";
                //echo json_encode($err);
           // }
						
			$veh = $db->registerCrashVehicle( $vehicle_reg_number, $accident_ID, $deaths, $s_injuries, $m_injuries, $loading, $vehicle_defect, $insurance_name, $vehicle_insurance_policy_no, $insurance_expired, $discrepancy, $vehicle_type, $vehicle_model, $registered_to,$_date);
            //if ($veh) {
				
                //$response["success"] = 1;
				//$response["success_msg"] = "Crash Vehicle registered successfully";
               				
				//echo json_encode($response);
				
			//} else {
				
               // $err["error"] = 1;
                //$err["error_msg"] = "Error occured in Registering Crash Vehicle";
                //echo json_encode($err);
            //}
			
			if($dri && $veh){
				echo "Vehicle/Driver details saved successifully";
			}else{
				echo "An error occured while saving details";
			}
            
            
        } else {
			//$response["error"] = 2;
            //$response["error_msg"] = "Accident does not exist";
            //echo json_encode($response);
			echo "A new accident was not created";
           
        }
		
		
		
    }
	
	else if ($tag == 'rem') {
		
        $cause_code = $_REQUEST['cause_code'];//acc
		$remarks= $_REQUEST['remarks']; //acc
		$accident_ID= $_REQUEST['accident_id'];
		$property_category= $_REQUEST['property_category'];//prop
		$name_of_property= $_REQUEST['name_of_property'];//prop
		$property_description= $_REQUEST['property_description'];//prop
		
        // check if accident exists
        if ($db->isAccidentExisted($accident_ID)) {
			
            $prop = $db->registerCrashProperty( $accident_ID, $name_of_property, $property_category, $property_description);
            //if ($prop) {
				
               // $response["success"] = 1;
				//$response["success_msg"] = "New Crash Property registered successfully";
               				
				//echo json_encode($response);
				
			//} else {
				
               // $err["error"] = 1;
               // $err["error_msg"] = "Error occured in Registering Crash Property";
               // echo json_encode($err);
            //}
			
			$updt = $db->updateAccident($accident_ID, $cause_code, $remarks);
           // if ($updt) {
				
                //$response["success"] = 1;
				//$response["success_msg"] = "Accident updated successfully";
               				
				//echo json_encode($response);
				
			//} else {
				
               // $err["error"] = 1;
               // $err["error_msg"] = "Error occured in Updating accident";
               // echo json_encode($err);
            //}
			
			if($prop && $updt){
				echo "Accident details have been saved fully";
			}else{
				echo "An error occured while registering";
			}
            
            
        } else {
			//$response["error"] = 2;
            //$response["error_msg"] = "Accident does not exist";
            //echo json_encode($response);
			echo "Accident does not exist";
			
           
        }
		
		
    }
	
	else if ($tag == 'new_admin') {
        // Request type is Register new user        
		$user_name = $_REQUEST['user_name'];
		$job_number = $_REQUEST['job_number'];
		$password = $_REQUEST['password'];
		
		
        // check if user is already existed
        if ($db->isAdminExisted($job_number)) {
            // user is already existed - error response
            $response["error"] = 2;
            $response["error_msg"] = "User already exists";
            echo json_encode($response);
        } else {
            // store user
            $user = $db->registerAdmin($user_name, $job_number, $password);
            if ($user) {
                // user stored successfully
				session_start();
                $response["success"] = 1;
				$response["success_msg"] = "New User registered successfully";
                $response["user"]["username"] = $user["username"];
				$response["user"]["job_number"] = $user["job_number"];
				$response["user"]["date_time"] = $user["date_time"];
				
				$response["sid"] = session_id();
			
				$_SESSION["admin_logged"] = $user["username"];
				$_SESSION["admin_password"] = $user["password"];
				$_SESSION["job_number"] = $user["job_number"];
				$_SESSION["date_time"] = $user["date_time"];
                echo json_encode($response);
            
			} else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in Registration";
                echo json_encode($response);
            }
        }
		
		
    }
	
	else if ($tag == 'input') {  
        
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];
        
            $acc = $db->registerAccident($acc_id, $crash_driver, $crash_vehicle, $location, $time, $date, $no_vehicles, $severity, $configuration, $illumination, $weather, $dead, $seriously_injured, $minor_injuries, $description, $remarks, $crash_officer_no);
            if ($acc) {
                // successful
                $response["success"] = 1;
               
                echo json_encode($response);
            } else {
                // failed
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in registering an accident";
                echo json_encode($response);
            }
			
			$cas = $db->registerCasuality($acc_id, $casualty_names, $type, $gender, $condition, $age_group, $nationality);
			if ($cas) {
                // user stored successfully
                $response["success"] = 1;
               
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in registering casualty";
                echo json_encode($response);
            }
			
			$analys = $db->insertCrashAnalysis($acc_id, $crash_expert, $date, $remarks, $measures);
			if ($analys) {
                // user stored successfully
                $response["success"] = 1;
               
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in registering casualty";
                echo json_encode($response);
            }
			
			$cdri = $db->registerCrashDriver($license_no, $id_no, $acc_id, $reg_no, $dead_or_alive, $age, $alcohol, $license_valid, $road_license_valid, $inspection_cert);
			if ($cdri) {
                // user stored successfully
                $response["success"] = 1;
               
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in registering casualty";
                echo json_encode($response);
            }
			
			$cexp = $db->registerCrashExpert($job_number, $id_number, $full_names);
			if ($cexp) {
                // user stored successfully
                $response["success"] = 1;
               
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in registering casualty";
                echo json_encode($response);
            }	
			
			$loc = $db->registerCrashLocation( $acc_id, $longitude, $latitude, $place_name, $landmark, $region);
			if ($loc) {
                // user stored successfully
                $response["success"] = 1;
               
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in registering casualty";
                echo json_encode($response);
            }	
			
			$prop = $db->registerCrashProperty( $acc_id, $property_name, $category, $description);
			if ($prop) {
                //successful
                $response["success"] = 1;
               
                echo json_encode($response);
            } else {
                //failed
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in registering casualty";
                echo json_encode($response);
            }	
			
			$veh = $db->registerCrashVehicle( $reg_number, $acc_id, $occupants_number, $deaths, $serious_injuries, $loading, $defects, $insurer, $policy_number, $insurance_status);
			if ($veh) {
                //successful
                $response["success"] = 1;
               
                echo json_encode($response);
            } else {
                //failed
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in registering casualty";
                echo json_encode($response);
            }	
			
    }
	
	else if ($tag == 'photo') {
        
		
		$photo = $db->insertPhotoReference( $acc_id, $photo_reference);
			if ($photo) {
                //successful
                $response["success"] = 1;
               
                echo json_encode($response);
            } else {
                //failed
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in registering casualty";
                echo json_encode($response);
            }	
	}
	
	else if ($tag == 'video') {
        
		
		$vid = $db->registerCrashWitness( $acc_id, $full_names, $video_reference);
			if ($vid) {
                //successful
                $response["success"] = 1;
               
                echo json_encode($response);
            } else {
                //failed
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in registering casualty";
                echo json_encode($response);
            }	
	}
	
	else if ($tag == 'contact') {
        
		
		$cnt = $db->registerContact( $respondent, $phone_number);
			if ($cnt) {
                //successful
                $response["success"] = 1;
               
                echo json_encode($response);
            } else {
                //failed
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in registering casualty";
                echo json_encode($response);
            }	
	}else if($tag=='client_login'){
	
		$job_number = $_REQUEST['job_number'];
        $password = $_REQUEST['password'];
		
		$user = $db->getUser($job_number, $password);
		
		if($user){
		
			echo "success";
			
		}else{
			echo "failed";
		
		}
	
	}else if ($tag == 'logout') {        
		
		    session_start();
			session_destroy();
			$_SESSION = array();

			$response['success'] = 1;
			$response['error'] = 0;
			$response['message'] = 'Logged out successfully';
			
			echo json_encode($response);
	}//else {
	
        //echo "Invalid Request";
    //}
} 

else {
    echo "Access Denied";
}
?>
