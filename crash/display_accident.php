<?php
	include "auth_user.inc.php";
	include "conn.inc.php";
	
	//set up static variables
	  $page_title = "Display Accident";
	  $user_agent = getenv("HTTP_USER_AGENT");
	 // $date_accessed = date("Y-m-d");
	  if (isset($_REQUEST['id']) && $_REQUEST['id'] != ''){  
	  //create and issue query  //
	  $query = "insert into access_tracker values
		 ('','".$_SESSION['job_number']."','$page_title', '$user_agent', NOW())";
	  mysql_query($query)or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Crash Data| Display Accident</title>

<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/includes.css" rel="stylesheet" type="text/css" />
<link href="css/menus.css" rel="stylesheet" type="text/css" />
<link href="css/myaccount.css" rel="stylesheet" type="text/css" />

<link type="text/css" href="css/jquery-ui-1.10.0.custom.css" rel="stylesheet">
<script type="text/javascript" src="jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="jquery/jquery-ui-1.10.3.custom.min.js"></script>

<!--<script type="text/javascript" src="jquery/jQuery.js"></script> 
<script type="text/javascript" src='jquery/jQuery.session.js'></script>
<script src="jquery/isSessionActive.js"></script>
<script src='jquery/new_user.js'>-->

<script type="text/javascript">
	//<![CDATA[
	function changeImg(who,flag) {
	  if (flag) {
	    who.style.height='325px';  who.style.width='400px';
	  } else {
	    who.style.height='200px';  who.style.width='225px';
	  }
	}
	//]]>
	</script>
	<style type="text/css">
	.imgSize {
	 height:100px; width:125px;
	 vertical-align:bottom;
	}
	</style>

 </head>

<body>
<div id="main">

  <div id="header">
     <?php include("header.html"); ?>          
  </div>
  <div id="buttons">
     <?php include("menu.html"); ?>            
  </div>
  <div id="status">
     <span id="hi">Hi</span> <span id="username-label"><?php echo $_SESSION['user_logged']; ?></span>   
  </div>
   
  <div id="user_info">
  
      <h2>Individual Accident information area</h2>
        <p>
        <?php
        //$query = "SELECT * FROM users " .
          //       "WHERE job_number = '" . $_SESSION['user_logged'] . "' ";
		  $query = "SELECT * FROM accident WHERE crash_id = '" . $_GET['id'] . "' ";
        $result = mysql_query($query)
            or die(mysql_error());
        
        $row = mysql_fetch_array($result);
        ?>
        <h3>General Information</h3>
        	<table>
                <tr><td id="td_label">Accident ID</td><td id="td_value"><?php echo $row['crash_id']; ?></td></tr>
                <tr><td id="td_label">Location</td><td id="td_value"><?php echo $row['location']; ?></td></tr>
                <tr><td id="td_label">Occurence Time</td><td id="td_value"><?php echo $row['time']; ?></td></tr>
                <tr><td id="td_label">Occurence Date</td> <td id="td_value"><?php echo $row['date']; ?></td></tr>
            	<tr><td id="td_label">Recording Date</td><td id="td_value"> <?php echo $row['date_of_record']; ?></td></tr>
            	<tr><td id="td_label">No. of vehicles</td><td id="td_value"> <?php echo $row['number_of_vehicles']; ?></td></tr>
            	<tr><td id="td_label">Severity</td><td id="td_value"> <?php echo $row['severity']; ?></td></tr>
            	<tr><td id="td_label">Crash Configuration</td><td id="td_value"> <?php echo $row['configuration']; ?></td></tr>
            	<tr><td id="td_label">Illumination</td><td id="td_value"> <?php echo $row['illumination']; ?></td></tr>
            	<tr><td id="td_label">Weather</td><td id="td_value"> <?php echo $row['weather']; ?></td></tr>
            	<tr><td id="td_label">Road Sign(s)</td><td id="td_value"> <?php echo $row['road_sign']; ?></td></tr>
            	<tr><td id="td_label">Other Sign(s)</td><td id="td_value"> <?php echo $row['other_sign']; ?></td></tr>
            	<tr><td id="td_label">Road Surface</td><td id="td_value"> <?php echo $row['road_surface']; ?></td></tr>
            	<tr><td id="td_label">Hit and Run?</td><td id="td_value"> <?php echo $row['hit_and_run']; ?></td></tr>
            	<tr><td id="td_label">Pre-Crash event</td><td id="td_value"> <?php echo $row['pre_crash']; ?></td></tr>
            	<tr><td id="td_label">Cause Code</td><td id="td_value"> <?php echo $row['cause_code']; ?></td></tr>
            	<tr><td id="td_label">Remarks</td><td id="td_value"><?php echo $row['remarks']; ?></td></tr>
            	<tr><td id="td_label">Officer Job Number</td><td id="td_value"> <?php echo $row['crash_officer_no']; ?></td></tr>
            </table>
            
            
            
            <a href="casualty.php?id=<?php echo $row['crash_id'];?>">Casualties</a> |
            <a href="analysis.php?id=<?php echo $row['crash_id'];?>">Expert Analysis</a><br /><br />
            
            <h3>Drivers Involved</h3>
            <?php
				$query = "SELECT * FROM crash_driver WHERE crash_id = '" . $_GET['id'] . "' ";
			$results = mysql_query($query)
			or die(mysql_error());?>
            <table>
                <tr class="title">
                    <th>Driver Name</th>
                    <th>License Number</th>
                    <th>Vehicle</th>
                    <th>Dead?</th>
                    <th>Injured?</th>
                    <th>Gender</th>
                    <th>Alcohol Influence</th>
                </tr>
                
                <?php //4213
                while ($row = mysql_fetch_array($results)) {
                extract($row);
                echo "<tr><td>";
                echo $row['driver_name'];
                echo "</td><td>";
                echo $row['license_number'];
                echo "</td><td>";
                echo $row['vehicle_reg_number'];
                echo "</td><td>";
				echo $row['dead'];
                echo "</td><td>";
                echo $row['driver_injured'];
                echo "</td><td>";
                echo $row['gender'];
                echo "</td><td>";
				echo $row['alcohol_influence'];
				echo "</td></tr>";
            }
            ?>
            </table>
            
            <h3>Vehicles Involved</h3>
            <?php
				$query = "SELECT * FROM crash_vehicle WHERE crash_id = '" . $_GET['id'] . "' ";
			$results = mysql_query($query)
			or die(mysql_error());?>
            <table>
                <tr class="title">
                    <th>Reg No.</th>
                    <th>Deaths</th>
                    <th>Serious Injuries</th>
                    <th>Minor Injuries</th>
                    <th>Loading</th>
                    <th>Defects</th>
                    <th>Insurer</th>
                    <th>Policy Number</th>
                    <th>Insurance Expired?</th>
                    <th>Discrepancy</th>
                    <th>Vehicle Type</th>
                    <th>Vehicle Model</th>
                    <th>Registered To</th>
                </tr>
                
                <?php //4213
                while ($row = mysql_fetch_array($results)) {
                extract($row);
                echo "<tr><td>";
                echo $row['reg_number'];
                echo "</td><td>";
                echo $row['deaths'];
                echo "</td><td>";
                echo $row['serious_injuries'];
                echo "</td><td>";
				echo $row['minor_injuries'];
                echo "</td><td>";
                echo $row['loading'];
                echo "</td><td>";
                echo $row['defects'];
                echo "</td><td>";
				echo $row['insurer'];
                echo "</td><td>";
                echo $row['policy_number'];
                echo "</td><td>";
                echo $row['insurance_expired'];
                echo "</td><td>";
				echo $row['discrepancy'];
                echo "</td><td>";
                echo $row['vehicle_type'];
                echo "</td><td>";
                echo $row['vehicle_model'];
                echo "</td><td>";
				echo $row['register_to'];
				echo "</td></tr>";
            }
            ?>
            </table>                 
			
        </p>
        <p>
        <h3> Accident Photos </h3>
        
        <?php // ACC_20140129_114938_25
//$query = "SELECT * FROM photos WHERE crash_id = '" . $_GET['id'] . "' ";
$query = mysql_query("SELECT * FROM photos WHERE photo_id = 5 OR photo_id = 6 ");
			$i = 0;?>
            
		<table border="0" cellpadding="10"><?php
		while($row = mysql_fetch_array($query)){ 
						
			$s = $row['photo_reference'];
		    $reference = "../crashdata/".$s;
			
			if ($i % 3 == 0) { // if $i is divisible by our target number (in this case "3")?>
				<tr><td> <img src="<?php echo $reference; ?>"  class="imgSize"
	 onmouseover="changeImg(this,true)" onmouseout="changeImg(this,false)" /></td> <?php
			} else {?>
				<td><img src="<?php echo $reference; ?>"  class="imgSize"
	 onmouseover="changeImg(this,true)" onmouseout="changeImg(this,false)" /></td>
			<?php }
			$i++;
		}?>
		</tr></table>
        
        </p>
        <div id="Layer1" style="display:none;position:absolute;z-index:1;"></div>
  </div>
   
  
  <div id="right_bar">
  <h3>Witnesses Videos</h3>
  <?php
     $query = "SELECT * FROM crash_witnesses WHERE crash_id = '" . $_GET['id'] . "' ";
			$results = mysql_query($query)
			or die(mysql_error());
			
                while ($row = mysql_fetch_array($results)) {
                extract($row);
                			
				$s = $row['video_reference'];
				$path = substr($s,1);
				$reference = "../crashdata/".$path;
				
				?>				
				<video src="<?php echo $reference; ?>" width="320" height="240" controls="controls">
					Your browser does not support the video tag.
				</video>
        <?php    }
            ?>
            
         
  </div>     
 
</div>
</body>
<?php } else { 

			header("Refresh: 5; URL=index.php");
			echo "You cant access this page directly! " .
				 "You are being sent to the home page!<br>";
			echo "(If you're browser doesn't support this, " .
				 "<a href=\"index.php\">click here</a>)";
			die();
}?>
</html>