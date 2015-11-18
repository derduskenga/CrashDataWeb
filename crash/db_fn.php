<?php

class DB_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
       // require_once 'DB_Connect.php';
        // connecting to database
       // $this->db = new DB_Connect();
       // $this->db->connect();
	   include "conn.inc.php";
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
     * Get user by job number and password
     */
    public function getUser($job_number, $password) {
        $result = mysql_query("SELECT * from users WHERE job_number = '$job_number' ") or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            $salt = $result['salt'];
            $encrypted_password = $result['password'];
            //$hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
			$hash = hash('sha256',$salt.$password);
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $result;
            }
        } else {
            // user not found
            return false;
        }
    }
	
	/**
     * Get user by job number and password
     */
    public function getAdmin($username, $password) {
        $result = mysql_query("SELECT * from admin WHERE username = '$username' ") or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysql_fetch_array($result);
            $salt = $result['salt'];
            $encrypted_password = $result['password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $result;
            }
        } else {
            // user not found
            return false;
        }
    }
	
	/**
     *Registering new casualties
     * returns casualty details
     */
    public function registerCasuality($acc_id, $full_names, $gender, $status, $age_group, $nationality) {
		
        $result = mysql_query("INSERT INTO casuality (crash_id, full_names, gender, status, age_group, nationality)
		VALUES('$acc_id', '$full_names', '$gender', '$status', '$age_group', '$nationality')");
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
     * Check user is existed or not
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

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }
	
	
	
}

?>
