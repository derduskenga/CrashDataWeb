<?php
	include "auth_user.inc.php";
	include "conn.inc.php";
	
	//set up static variables
	  $page_title = "Update Account";
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
<title>Crash Data|Update Account</title>

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
   
  <div id="center_info">
  
  <h2>Update Account Information</h2>
  
  <h3>Here you can update your account information for viewing in your
        profile.</h3>
  
  	<div id="div_analysis">  
        
	<?php
	if (isset($_POST['submit']) && $_POST['submit'] == "Update") {
		//$names = '$_POST["first_name"]." ".$_POST["last_name"}';
		$fname = $_POST["first_name"];
		$lname = $_POST["last_name"];
		$names = $fname." ".$lname;
	
		$query_update = "UPDATE users SET  full_names = '".$names." ' WHERE job_number = '". $_SESSION['job_number']."'";
						
		$result_update = mysql_query($query_update)
		or die(mysql_error());
		
		$query = "SELECT * FROM users WHERE job_number = '" . $_SESSION['job_number'] . "' ";
		
		$result = mysql_query($query)
		or die(mysql_error());
		
		$row = mysql_fetch_array($result);
		$names = explode(" ",$row['full_names']);
	?>
	<b>Your account information has been updated.</b><br>
	<a href="myaccount.php">Click here</a> to return to your account.
        <form action="update_account.php" method="post">
        	<table id="no_border">
                <tr>
                    <td id="td_label">First Name:</td><td id="td_value"> <input type="text" name="first_name"value="<?php echo $names[0]; ?>"></td>
                </tr>
                <tr>
                    <td id="td_label">Last Name:</td><td id="td_value"> <input type="text" name="last_name" value="<?php echo $names[1]; ?>"></td>
                </tr>
                <tr>
                    <td id="td_label">Job Number:</td><td id="td_value"> <?php echo $row['job_number']; ?></td>
                </tr>
                <tr>
                    <td id="td_label">User Level:</td><td id="td_value"> <?php echo $row['user_level']; ?></td>
                </tr>
                <tr>
                    <td id="td_label">Registration Date/Time: </td><td id="td_value"><?php echo $row['date_time']; ?></td>
                </tr>
                <tr>
                    <td id="td_label"></td>
                    <td id="td_value"><input type="submit" name="submit" value="Update"></td>
                </tr>
            </table>
        </form>
	</p>
	<?php
	} else {
		
		$query = "SELECT * FROM users WHERE job_number = '" . $_SESSION['job_number'] . "' ";
		
		$result = mysql_query($query)
		or die(mysql_error());
		
		$row = mysql_fetch_array($result);
		$names = explode(" ",$row['full_names']);
	?>
	
        <form action="update_account.php" method="post">
            <table id="no_border">
                <tr>
                    <td id="td_label">First Name:</td><td id="td_value"> <input type="text" name="first_name"value="<?php echo $names[0]; ?>"></td>
                </tr>
                <tr>
                    <td id="td_label">Last Name:</td><td id="td_value"> <input type="text" name="last_name" value="<?php echo $names[1]; ?>"></td>
                </tr>
                <tr>
                    <td id="td_label">Job Number:</td><td id="td_value"> <?php echo $row['job_number']; ?></td>
                </tr>
                <tr>
                    <td id="td_label">User Level:</td><td id="td_value"> <?php echo $row['user_level']; ?></td>
                </tr>
                <tr>
                    <td id="td_label">Registration Date/Time: </td><td id="td_value"><?php echo $row['date_time']; ?></td>
                </tr>
                <tr>
                    <td id="td_label"></td>
                    <td id="td_value"><input type="submit" name="submit" value="Update">&nbsp; &nbsp;<input type="button" value="Cancel" onClick="history.go(-1);"></td>
                </tr>
            </table>
            
        </form>
	
	<?php
	}
	?>
    </div>
  </div>  
 
</div>
</body>
</html>