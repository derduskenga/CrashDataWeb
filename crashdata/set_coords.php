<?php
    
    require 'include/config.php';
    
    try {
	
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        
        $sth = $db->prepare("UPDATE location SET lat = ?, lon = ? WHERE loc_id = ?");
        if ($sth->execute(array($_GET['lat'], $_GET['lon'], $_GET['id'])))
            echo "OK";
        
    } catch (Exception $e) {
        echo $e->getMessage();
    }