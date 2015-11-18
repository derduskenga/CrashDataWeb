<?php

class DB_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
        require_once 'include/DB_Connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {
        
    }

    /**
     *Registering new user
     * returns user details
     */
    public function registerUser($full_names, $job_number, $password, $user_level) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        $result = mysql_query("INSERT INTO users(unique_id, full_names, job_number, password, salt, user_level, date_time)
					VALUES('$uuid', '$full_names', '$job_number', '$encrypted_password', '$salt', '$user_level', NOW())");
        // check for successful store
        if ($result) {
            // get user details 
            $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM users WHERE users_id = $uid ");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }

 /**
     *Registering new admin
     * returns admin details
     */
    public function registerAdmin($user_name, $job_number, $password) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
        $result = mysql_query("INSERT INTO admin(unique_id, username, job_number, password, salt, date_time)
					VALUES('$uuid', '$user_name', '$job_number', '$encrypted_password', '$salt', NOW())");
        // check for successful store
        if ($result) {
            // get user details 
            $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM admin WHERE admin_id = $uid ");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }

    /**
     * Get user by job number and password
     */
    public function getUser($job_number, $password) {
        $result = mysql_query("SELECT * from users WHERE job_number = '$job_number' ") or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $row = mysql_fetch_array($result);
			//get the salt
            $salt = $row['salt'];
			//get a salt hashed password
            $encrypted_password = $row['password'];
			
            //$hash = $this->checkhashSSHA($salt, $password);
			$hash = hash('sha256',$salt.$password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return true;
            }
        } else {
            // user not found
            return false;
        }
    }
	
	    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
		
        $salt = substr($salt, 0, 10);
		
		$password = hash('sha256',$password);
		
        $encrypted = hash('sha256',$salt.$password);
		
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
		
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = hash('sha256',$salt.$password);

        return $hash;
    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($job_number) {
        $result = mysql_query("SELECT job_number from users WHERE job_number = '$job_number' ");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
	
	/**
     * Check admin is existed or not
     */
    public function isAdminExisted($job_number) {
        $result = mysql_query("SELECT job_number from admin WHERE job_number = '$job_number' ");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
	
	/**
     * Check accident is existed or not
     */
    public function isAccidentExisted($acc_id) {
        $result = mysql_query("SELECT crash_id from accident WHERE crash_id = '$acc_id' ");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }


	
	/**
     *Registering new accident
     * returns accident details
     */
    public function registerAccident($acc_id, $location, $time, $date, $date_record, $no_vehicles, $severity, $configuration, $illumination, $weather, $road_sign, $other_sign, $road_surface, $hit_run, $pre_crash, $cause_code, $remarks, $crash_officer_no) {
		
        $result = mysql_query("INSERT INTO accident(crash_id, location, time, date, date_of_record, number_of_vehicles, severity, configuration, illumination, weather,road_sign, other_sign, road_surface, hit_and_run, pre_crash, cause_code, remarks, crash_officer_no)
					VALUES('$acc_id', '$location', '$time', '$date', '$date_record', $no_vehicles, '$severity', '$configuration', '$illumination', '$weather', '$road_sign', '$other_sign', '$road_surface', '$hit_run', '$pre_crash', '$cause_code', '$remarks', '$crash_officer_no') ");
        // check for successful store
        if ($result) {           
		    $result = mysql_query("SELECT * FROM accident WHERE crash_id = '$acc_id' ");
            //return mysql_fetch_array($result);
			return true;
        } else {
            return false;
        }
    }	
	
	/**
     *Updating accident
     * returns accident details
     */
    public function updateAccident($acc_id, $cause_code, $remarks) {
		
        $result = mysql_query("UPDATE accident SET cause_code='$cause_code', remarks='$remarks' WHERE crash_id = '$acc_id' ");
        // check for successful store
        if ($result) {   
		    $result = mysql_query("SELECT * FROM accident WHERE crash_id = '$acc_id' ");        
           // return mysql_fetch_array($result);
			return true;
        } else {
            return false;
        }
    }	
	
	/**
     *Registering new casualties
     * returns casualty details
     */
    public function registerCasuality($acc_id, $full_names, $type, $gender, $condition, $age_group, $nationality) {
		
        $result = mysql_query("INSERT INTO casuality(crash_id, full_names, type, gender, condition, age_group, nationality)
					VALUES('$acc_id', '$full_names', '$type', '$gender', '$condition', '$age_group', '$nationality' ");
        // check for successful store
        if ($result) {     
		
		    $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM casuality WHERE sys_casuality_id = $uid ");
            // return casualty details      
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
	
	/**
     *Insert crash analysis
     * returns analysis details
     */
    public function insertCrashAnalysis($acc_id, $crash_expert, $date, $remarks, $measures) {
		
        $result = mysql_query("INSERT INTO crash_analysis(crash_id, crash_expert, date, remarks, measures)
					VALUES('$acc_id', '$crash_expert', '$date', '$remarks', '$measures' ");
        // check for successful store
        if ($result) {     
		
		    $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM crash_analysis WHERE sys_analysis_id = $uid ");
            // return analysis details      
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
	
	/**
     *Register crash driver
     * returns crash driver details
	 */
    public function registerCrashDriver($license_no,$driver_name, $acc_id, $reg_no, $dead,$driver_s_injured_yes_no, $gender, $alcohol) {
		
        $result = mysql_query("INSERT INTO crash_driver( license_number, driver_name, crash_id, vehicle_reg_number, dead, driver_injured, gender, alcohol_influence) VALUES('$license_no', '$driver_name', '$acc_id', '$reg_no', '$dead', '$driver_s_injured_yes_no', '$gender', '$alcohol') ");
        // check for successful store
        if ($result) {     
		    // return crash driver details 
			$uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM crash_driver WHERE sys_id = $uid "); 
			return $result;
        } else {
            return false;
        }
    }
	
	/**
     *Register crash expert
     * returns crash expert details
     */
    public function registerCrashExpert($job_number, $id_number, $full_names) {
		
        $result = mysql_query("INSERT INTO crash_expert( job_number, id_number, full_names)
					VALUES('$job_number', '$id_number', '$full_names' ");
        // check for successful store
        if ($result) {     
		    // return crash expert details      
			$result = mysql_query("SELECT * FROM crash_expert WHERE job_number = '$job_number' ");
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
	
	/**
     *Register crash location
     * returns crash location details
     */
    public function registerCrashLocation( $acc_id, $longitude, $latitude, $place_name, $landmark, $region, $date_of_accident) {
		
        $result = mysql_query("INSERT INTO crash_location( crash_id, longitude, latitude, place_name, nearest_landmark, region, _date)
					VALUES('$acc_id', '$longitude', '$latitude', '$place_name', '$landmark', '$region', '$date_of_accident')");
        // check for successful store
        if ($result) {   
		    $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM crash_location WHERE sys_id = $uid ");  
		    // return crash location details      
            //return mysql_fetch_array($result);
			return true;
        } else {
            return false;
        }
    }
	
	/**
     *Register crash property
     * returns crash property details
     */
    public function registerCrashProperty( $acc_id, $property_name, $category, $description) {
		
        $result = mysql_query("INSERT INTO crash_property(crash_id, property_name, category, description)
					VALUES('$acc_id', '$property_name', '$category', '$description') ");
        // check for successful store
        if ($result) {   
		    $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM crash_property WHERE sys_id = $uid ");  
		    // return crash property details      
            //return mysql_fetch_array($result);
			return true;
        } else {
            return false;
        }
    }
	
	/**
     *Register crash vehicle
     * returns crash vehicle details
	 */
    public function registerCrashVehicle( $reg_number, $acc_id, $deaths, $serious_injuries, $minor_injuries, $loading, $defects, $insurer, $policy_number, $insurance_expired, $discrepancy, $vehicle_type, $vehicle_model, $register_to,$_date) {
		
        $result = mysql_query("INSERT INTO crash_vehicle(reg_number, crash_id, deaths, serious_injuries, minor_injuries, loading, defects, insurer, policy_number, insurance_expired, discrepancy, vehicle_type, vehicle_model, register_to,_date)
					VALUES('$reg_number', '$acc_id', $deaths, $serious_injuries, $minor_injuries, '$loading', '$defects', '$insurer', '$policy_number', '$insurance_expired', '$discrepancy', '$vehicle_type', '$vehicle_model', '$register_to','$_date')");
        // check for successful store
        if ($result) {   
		     // return crash vehicle details      
			$uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM crash_vehicle WHERE sys_id = $uid "); 
            //return mysql_fetch_array($result);
			return true;
        } else {
            return false;
        }
    }
	
	/**
     *Register crash witness
     * returns crash witness details
     */
    public function registerCrashWitness( $acc_id, $full_names, $video_reference) {
		
        $result = mysql_query("INSERT INTO crash_witnesses( crash_id, $full_names, $video_reference)
					VALUES('$acc_id', '$full_names', '$video_reference') ");
        // check for successful store
        if ($result) {   
		    $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM crash_witnesses WHERE sys_id = $uid ");  
		    // return crash witness details      
            return mysql_fetch_array($result);
			return true;
        } else {
            return false;
        }
    }
	
	/**
     *Register emergency contacts
     * returns emergency contacts
     */
    public function registerContact( $respondent, $phone_number) {
		
        $result = mysql_query("INSERT INTO emergency( respondent, phone_number)
					VALUES('$respondent', '$phone_number') ");
        // check for successful store
        if ($result) {   
		    $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM emergency WHERE emergency_id = $uid ");  
		    // return emergency details      
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
	
	/**
     *insert crash photo references
     * returns crash photo references
     */
    public function insertPhotoReference( $acc_id, $photo_reference) {
		
        $result = mysql_query("INSERT INTO photos( crash_id, photo_reference)
					VALUES(' $acc_id', '$photo_reference') ");
        // check for successful store
        if ($result) {   
		    $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM photos WHERE photo_id = $uid ");  
		    // return emergency details      
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
	
	 public function addCasualty($accident_ID,$fname,$status,$gender,$ageGroup,$_date,$nationality){
	
		$query = "insert into casuality 
			(crash_id,full_names,gender,status,age_group,_date,nationality)
			values('$accident_ID','$fname','$gender','$status','$ageGroup','$_date','$nationality')";
		$result = mysql_query($query) or die("Failed query " . mysql_error());
		
		if($result){
			echo "Casualty has been added";
		}else{
			echo "An Error occured while adding casualty";
		}
	
	}

}

?>
