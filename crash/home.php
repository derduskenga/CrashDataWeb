<?php
	
	include "conn.inc.php";
	
	if (isset($_SESSION['user_logged']) &&
		$_SESSION['user_logged'] != "") {
				
	
	//set up static variables
	  $page_title = "home";
	  $user_agent = getenv("HTTP_USER_AGENT");
	 // $date_accessed = date("Y-m-d");
	  
	  //create and issue query  //
	  $query = "insert into access_tracker values
		 ('','".$_SESSION['job_number']."','$page_title', '$user_agent', NOW())";
	  mysql_query($query)or die(mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Crash Data| Home</title>

<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/includes.css" rel="stylesheet" type="text/css" />
<link href="css/menus.css" rel="stylesheet" type="text/css" />

<link type="text/css" href="css/jquery-ui-1.10.0.custom.css" rel="stylesheet">
<script type="text/javascript" src="jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="jquery/jquery-ui-1.10.3.custom.min.js"></script>

<!--<script type="text/javascript" src="jquery/jQuery.js"></script> 
<script type="text/javascript" src='jquery/jQuery.session.js'></script>
<script src="jquery/isSessionActive.js"></script>
<script src='jquery/new_user.js'>-->

<style type="text/css">
			body { font: normal 14px Verdana; }
			h1 { font-size: 24px; }
			h2 { font-size: 18px; }
			#sidebar { float: right; width: 30%; }
			#main { padding-right: 15px; }
            .infoWindow { width: 360px; height: 360px; }
  </style>
        
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">
    //<![CDATA[
    
    var map;
    
    var center = new google.maps.LatLng(-1.2833333, 36.8166667);
    
    var geocoder = new google.maps.Geocoder();
    var infowindow = new google.maps.InfoWindow();
    
    var directionsService = new google.maps.DirectionsService();
    var directionsDisplay = new google.maps.DirectionsRenderer();
    
    function init() {
        
        var mapOptions = {
          zoom: 13,
          center: center,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    /*	var marker = new google.maps.Marker({
          position: center,
          map: map,
          title: 'Hello World!'
      });
      */

        
        directionsDisplay.setMap(map);
        //directionsDisplay.setPanel(document.getElementById('directions_panel'));
        
        // Detect user location
    /*	if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                
                var userLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
                
                geocoder.geocode( { 'latLng': userLocation }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                    //	document.getElementById('start').value = results[0].formatted_address;
                    }
                });
                
            }, function() {
                alert('Geolocation is supported, but it failed');
            });
        }
        */
        
        makeRequest('../crashdata/get_locations.php', function(data) {
            
            var data = JSON.parse(data.responseText);
       //     var selectBox = document.getElementById('destination');
            
            for (var i = 0; i < data.length; i++) {
                displayLocation(data[i]);
            //    addOption(selectBox, data[i]['name'], data[i]['address']);
            }
        });
    }
    
    function displayLocation(location) {
    
        var content = 	'<div class="infoWindow"><strong>' 	+ location.crash_id + '</strong>'
                        + '<br/>Place Name: ' 	+ location.place_name
                        + '<br/>Landmark: ' 	+ location.nearest_landmark 
                        + '<br/>Region: ' 	+ location.region
						+ '<br/>Date: ' 	+ location._date
						+ '<br/>Number of Vehicles: ' 	+ location.number_of_vehicles
						+ '<br/>Severity: ' 	+ location.severity
						+ '<br/>Pre-Crash: ' 	+ location.pre_crash
						+ '<br/>Cause Code: ' 	+ location.cause_code
						+ '<br/>Crash Officer No.: ' 	+ location.crash_officer_no
						+ '<br/>Crash Configuration: ' 	+ location.configuration
						+ '<br/>Hit and Run: ' 	+ location.hit_and_run + '</div>';
        
    /*    if (parseInt(location.lat) == 0) {
            geocoder.geocode( { 'place': location.place_name }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    
                    var marker = new google.maps.Marker({
                        map: map, 
                        position: results[0].geometry.location,
                        title: location.place_name
                    });
                    
                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.setContent(content);
                        infowindow.open(map,marker);
                    });
                    
                        
                    
                    makeRequest(url, function(data) {
                        if (data.responseText == 'OK') {
                            // Success
                        }
                    });
                }
            });
        } else {
           */ 
            var position = new google.maps.LatLng(parseFloat(location.lat), parseFloat(location.lon));
            var marker = new google.maps.Marker({
                map: map, 
                position: position,
                title: location.place_name
            });
            
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.setContent(content);
                infowindow.open(map,marker);
            });
      //  }
    }
    
/*	function addOption(selectBox, text, value) {
        var option = document.createElement("OPTION");
        option.text = text;
        option.value = value;
        selectBox.options.add(option);
    }
    */
    
/*	function calculateRoute() {
        
        var start = document.getElementById('start').value;
        var destination = document.getElementById('destination').value;
        
        if (start == '') {
            start = center;
        }
        
        var request = {
            origin: start,
            destination: destination,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            }
        });
    }
    */
    
    function makeRequest(url, callback) {
        var request;
        if (window.XMLHttpRequest) {
            request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
        } else {
            request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
        }
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                callback(request);
            }
        }
        request.open("GET", url, true);
        request.send();
    }
    //]]>
    </script>
 </head>

<body onload="init();">
<div id="main">

  <div id="header">
     <?php include("header.html"); ?>          
  </div>
  <div id="buttons">
     <?php include("menu.html"); ?>            
  </div>
  <div id="status">
     <span id="hi">Hi</span> <span id="username-label"><?php echo $_SESSION['user_logged']; ?></span> 
     <span id="log-out"><input type="button" name="logout" value="Log Out" id="btn-logout" /> </span>
  </div>
   
  <div id="map_canvas">
  </div>
   
  
  <div id="right_bar">
    <div id="search_by">
       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        Search Accidents By <br />
        <input type="radio" name="search" value="Date" /> Date <br />
        <input type="radio" name="search" value="Accident ID" /> Accident ID <br />
        <input type="text" name="search_value" />
        <input type="submit" name="submit" value="Search" />
       </form>
    </div>
    
    <div id="display-accidents">
       <?php
        	if (isset($_POST['submit']) && $_POST['submit'] == "Search"){
				$search = $_POST['search'];  
			//	$query = "SELECT crash_id, location, date, number_of_vehicles, crash_officer_no FROM accident ";  
				if ($search == "Date") {  
					$date = $_POST['search_value'];
				//	$query = "SELECT crash_id, location, date, number_of_vehicles, crash_officer_no FROM accident WHERE date = '$date' ";
					$query = "SELECT crash_id, location, date FROM accident WHERE date = '$date' ";        
					      
				}
				else if ($search == "Accident ID") {
					$crash_id = $_POST['search_value'];
				//	$query = "SELECT crash_id, location, date, number_of_vehicles, crash_officer_no FROM accident WHERE crash_id = '$crash_id' "; 
					$query = "SELECT crash_id, location, date FROM accident WHERE crash_id = '$crash_id' "; 
				} 
				$results = mysql_query($query)
					or die(mysql_error());?>
            <table>
                <tr class="title">
                    <th width="30%">Accident ID</th>
                    <th width="40%">Location</th>
                    <th></th>
                </tr>
                
                <?php //4213
                while ($row = mysql_fetch_array($results)) {
                extract($row);
                echo "<tr><td width=\"30%\">";
                echo $row['crash_id'];
                echo "</td><td width=\"40%\">";
                echo $row['location'];
                echo "</td><td width=\"30%\">";?>
				<a href="display_accident.php?id=<?php echo $row['crash_id'];?>">View</a>
                <?php echo "</td></tr>";
            }
            ?>
            </table>
		<?php 	} ?>
			
		
        
    </div>
  </div>     
 
</div>
</body>
</html>

<?php } 
else { header("Refresh: 5; URL=login.php");
			echo "You are currently not logged in, we are redirecting you, " .
			"be patient!<br>";
			echo "(If your browser doesn't support this, " .
			"<a href=\"login.php\">click here</a>)";
			die();	
			
	}
	
	 ?>