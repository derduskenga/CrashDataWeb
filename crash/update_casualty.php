<?php
	include "auth_user.inc.php";
	include "conn.inc.php";
	
	//set up static variables
	  $page_title = "Update Casualty";
	  $user_agent = getenv("HTTP_USER_AGENT");
	 // $date_accessed = date("Y-m-d");
	  if (isset($_REQUEST['id']) && $_REQUEST['id'] != '' && isset($_SESSION['user_level']) &&
		($_SESSION['user_level'] == "1" || $_SESSION['user_level'] == "2") ) {
	  //create and issue query  //
	  $query = "insert into access_tracker values
		 ('','".$_SESSION['job_number']."','$page_title', '$user_agent', NOW())";
	  mysql_query($query)or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Crash Data| Update Casualty</title>

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
  
      <h2>Update Casualty Information</h2>
	
	<?php
	if (isset($_POST['submit']) && $_POST['submit'] == "Update") {
		//$names = '$_POST["first_name"]." ".$_POST["last_name"}';
		$fname = $_POST["first_name"];
		$lname = $_POST["last_name"];
		$names = $fname." ".$lname;
		
		$query_update = "UPDATE casuality SET  full_names = '".$names." ', gender = '".$_POST['gender']."', status = '" . $_POST['status']."', age_group = '" . $_POST['age']. "', nationality = '" . $_POST['nationality']. "' WHERE sys_casuality_id = '". $_POST['id']."'";
						
		$result_update = mysql_query($query_update)
		or die(mysql_error());
		
		$query = "SELECT * FROM casuality WHERE sys_casuality_id = '". $_POST['id']."' ";
		
		$result = mysql_query($query)
		or die(mysql_error());
		
		$row = mysql_fetch_array($result);
		$names = explode(" ",$row['full_names']);
	?>
	<h3>Casualty information has been updated !!</h3>
	<a href="casualty.php?id=<?php echo $row['crash_id'];?>" >Click Me</a> to return to Casualties Information. 
    	<div id="div_casualty">
        <form action="update_casualty.php" method="post">
          <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
          <table id="no_border">
            <tr>
                <td id="td_label">First Name:  </td>
                <td id="td_value"> <input type="text" name="first_name" size="35" value="<?php echo $names[0]; ?>"></td>
            </tr>
            <tr>
            	<td id="td_label">Last Name:</td>
                <td id="td_value"> <input type="text" name="last_name" size="35" value="<?php echo $names[1]; ?>"></td>
            </tr>
            <tr>
            	<td id="td_label">Gender: </td>
                <td id="td_value"><input type="radio" name="gender" checked value="male"<?php
                    if ($row['gender']=="male") {
                        echo 'checked="checked"';
                    } ?> /> Male
            		<input type="radio" name="gender" value="female"<?php
                    if ($row['gender']=="female") {
                        echo 'checked="checked"';
                    } ?> /> Female </td>
            </tr>
            <tr>
            	<td id="td_label">Age Group: </td>
                <td id="td_value"><select name="age">
                  <option value="No age selected"<?php
                        if ($row['age_group']=="No age selected") {
                            echo " selected";
                        } ?>>--Select--</option>
                  <option value="0-5 years"<?php
                        if ($row['age_group']=="0-5 years") {
                            echo " selected";
                        } ?>>0-5 years</option>
                  <option value="6-10 years"<?php
                        if ($row['age_group']=="6-10 years") {
                            echo " selected";
                        } ?>>6-10 years</option>
                  <option value="11-16 years"<?php
                        if ($row['age_group']=="11-16 years") {
                            echo " selected";
                        } ?>>11-16 years</option>
                  <option value="17-25 years"<?php
                        if ($row['age_group']=="17-25 years") {
                            echo " selected";
                        } ?>>17-25 years</option>
                  <option value="26-35 years"<?php
                        if ($row['age_group']=="26-35 years") {
                            echo " selected";
                        } ?>>26-35 years</option>
                  <option value="36-45 years"<?php
                        if ($row['age_group']=="36-45 years") {
                            echo " selected";
                        } ?>>36-45 years</option>
                  <option value="46-55 years"<?php
                        if ($row['age_group']=="46-55 years") {
                            echo " selected";
                        } ?>>46-55 years</option>
                  <option value="56-65 years"<?php
                        if ($row['age_group']=="56-65 years") {
                            echo " selected";
                        } ?>>56-65 years</option>
                  <option value="over 65 years"<?php
                        if ($row['age_group']=="over 65 years") {
                            echo " selected";
                        } ?>>over 65 years</option>
                </select></td>
                </tr>
                <tr>
            		<td id="td_label">Nationality: </td>
                	<td id="td_value"><select name="nationality">
                              <option value="No Nationality selected"<?php
                        if ($row['nationality']=="No Nationality selected") {
                            echo " selected";
                        } ?>>--Select--</option>
                              <option value="Kenyan"<?php
                        if ($row['nationality']=="Kenyan") {
                            echo " selected";
                        } ?>>Kenyan</option>
                              <option value="Other African"<?php
                        if ($row['nationality']=="Other African") {
                            echo " selected";
                        } ?>>Other African</option>
                              <option value="American"<?php
                        if ($row['nationality']=="American") {
                            echo " selected";
                        } ?>>American</option>
                              <option value="Asian"<?php
                        if ($row['nationality']=="Asian") {
                            echo " selected";
                        } ?>>Asian</option>
                              <option value="European"<?php
                        if ($row['nationality']=="European") {
                            echo " selected";
                        } ?>>European</option>
                          </select></td>
                  </tr>
                  <tr>
                  		<td id="td_label">Status:</td>
                      	<td id="td_value"><input type="radio" name="status" value="killed"<?php
							if ($row['status']=="killed") {
								echo 'checked="checked"';
							} ?> /> Killed <br />
						  <input type="radio" name="status" value="seriously injured"<?php
							if ($row['status']=="seriously injured") {
								echo 'checked="checked"';
							} ?> /> Seriously Injured <br />
						  <input type="radio" name="status" value="slightly injured"<?php
							if ($row['status']=="slightly injured") {
								echo 'checked="checked"';
							} ?> /> Slightly Injured </td>
                   </tr>
                   <tr>
                   		<td id="td_label"></td>
                        <td id="td_value"><input type="submit" name="submit" value="Update"></td>
               </table>
        </form>
	</div>
	<?php
	} else {
		
		$query = "SELECT * FROM casuality WHERE sys_casuality_id = '". $_GET['id']."' ";
		
		$result = mysql_query($query)
		or die(mysql_error());
		
		$row = mysql_fetch_array($result);
		$names = explode(" ",$row['full_names']);
	?>
	<h3>Casualty information has been updated!!</h3>
	<a href="casualty.php?id=<?php echo $row['crash_id'];?>" >Click Me</a> to return to Casualties Information. 
    	<div id="div_casualty">
        <form action="update_casualty.php" method="post">
        	<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <table id="no_border">
            <tr>
                <td id="td_label">First Name:  </td>
                <td id="td_value"> <input type="text" name="first_name" size="35" value="<?php echo $names[0]; ?>"></td>
            </tr>
            <tr>
            	<td id="td_label">Last Name:</td>
                <td id="td_value"> <input type="text" name="last_name" size="35" value="<?php echo $names[1]; ?>"></td>
            </tr>
            <tr>
            	<td id="td_label">Gender: </td>
                <td id="td_value"><input type="radio" name="gender" checked value="male"<?php
                    if ($row['gender']=="male") {
                        echo 'checked="checked"';
                    } ?> /> Male
            		<input type="radio" name="gender" value="female"<?php
                    if ($row['gender']=="female") {
                        echo 'checked="checked"';
                    } ?> /> Female </td>
            </tr>
            <tr>
            	<td id="td_label">Age Group: </td>
                <td id="td_value"><select name="age">
                  <option value="No age selected"<?php
                        if ($row['age_group']=="No age selected") {
                            echo " selected";
                        } ?>>--Select--</option>
                  <option value="0-5 years"<?php
                        if ($row['age_group']=="0-5 years") {
                            echo " selected";
                        } ?>>0-5 years</option>
                  <option value="6-10 years"<?php
                        if ($row['age_group']=="6-10 years") {
                            echo " selected";
                        } ?>>6-10 years</option>
                  <option value="11-16 years"<?php
                        if ($row['age_group']=="11-16 years") {
                            echo " selected";
                        } ?>>11-16 years</option>
                  <option value="17-25 years"<?php
                        if ($row['age_group']=="17-25 years") {
                            echo " selected";
                        } ?>>17-25 years</option>
                  <option value="26-35 years"<?php
                        if ($row['age_group']=="26-35 years") {
                            echo " selected";
                        } ?>>26-35 years</option>
                  <option value="36-45 years"<?php
                        if ($row['age_group']=="36-45 years") {
                            echo " selected";
                        } ?>>36-45 years</option>
                  <option value="46-55 years"<?php
                        if ($row['age_group']=="46-55 years") {
                            echo " selected";
                        } ?>>46-55 years</option>
                  <option value="56-65 years"<?php
                        if ($row['age_group']=="56-65 years") {
                            echo " selected";
                        } ?>>56-65 years</option>
                  <option value="over 65 years"<?php
                        if ($row['age_group']=="over 65 years") {
                            echo " selected";
                        } ?>>over 65 years</option>
                </select></td>
                </tr>
                <tr>
            		<td id="td_label">Nationality: </td>
                	<td id="td_value"><select name="nationality">
                              <option value="No Nationality selected"<?php
                        if ($row['nationality']=="No Nationality selected") {
                            echo " selected";
                        } ?>>--Select--</option>
                              <option value="Kenyan"<?php
                        if ($row['nationality']=="Kenyan") {
                            echo " selected";
                        } ?>>Kenyan</option>
                              <option value="Other African"<?php
                        if ($row['nationality']=="Other African") {
                            echo " selected";
                        } ?>>Other African</option>
                              <option value="American"<?php
                        if ($row['nationality']=="American") {
                            echo " selected";
                        } ?>>American</option>
                              <option value="Asian"<?php
                        if ($row['nationality']=="Asian") {
                            echo " selected";
                        } ?>>Asian</option>
                              <option value="European"<?php
                        if ($row['nationality']=="European") {
                            echo " selected";
                        } ?>>European</option>
                          </select></td>
                  </tr>
                  <tr>
                  		<td id="td_label">Status:</td>
                      	<td id="td_value"><input type="radio" name="status" value="killed"<?php
							if ($row['status']=="killed") {
								echo 'checked="checked"';
							} ?> /> Killed <br />
						  <input type="radio" name="status" value="seriously injured"<?php
							if ($row['status']=="seriously injured") {
								echo 'checked="checked"';
							} ?> /> Seriously Injured <br />
						  <input type="radio" name="status" value="slightly injured"<?php
							if ($row['status']=="slightly injured") {
								echo 'checked="checked"';
							} ?> /> Slightly Injured </td>
                   </tr>
                   <tr>
                   		<td id="td_label"></td>
                        <td id="td_value"><input type="submit" name="submit" value="Update">
                        &nbsp;&nbsp;<input type="button" value="Cancel" onClick="history.go(-1);"></td>
               </table>
            
        </form>
        </tr>
	
	<?php
	}
	?>
  </div>
  
  
</div>
</body>
<?php
 }
 else {
		header("Refresh: 5; URL=index.php");
			echo "You are not allowed to access this page! " .
				 "You are being sent to the home page!<br>";
			echo "(If you're browser doesn't support this, " .
				 "<a href=\"index.php\">click here</a>)";
			die();
}
?>
</html>