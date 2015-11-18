<?php

	$password = "slimkk33";
	$police_number = "123";
	
	echo "police number is: " . $police_number . "<br>";
	
	echo "password is: " . $password . "<br>";
	
	echo "Sha1 password hash is: " . hash('sha256',$password) . "<br>";
	
	$salt = sha1(rand());
		
    $salt = substr($salt, 0, 10);
	
	echo "salt is: " . $salt . "<br>";
	
	echo strlen("vJ+r7iDZomyDBGaf/oSDf0n6gSBjYzQ3NTc4MjI1"). "<br>";
	
	echo "password salted hash is: " . hash('sha256', $salt . hash('sha256',$password));
	
	//echo hash('sha256', '123');
?>