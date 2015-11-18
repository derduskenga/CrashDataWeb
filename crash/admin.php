<?php
	include "auth_user.inc.php";
	include "conn.inc.php";
	
	//set up static variables
	  $page_title = "Admin Area";
	  $user_agent = getenv("HTTP_USER_AGENT");
	 // $date_accessed = date("Y-m-d");
	  	  
?>
<?php
	if (isset($_SESSION['user_level']) &&
		$_SESSION['user_level'] != "1") {
			
			//create and issue query  //
	  $query = "insert into access_tracker values
		 ('','".$_SESSION['job_number']."','$page_title', '$user_agent', NOW())";
	  mysql_query($query)or die(mysql_error());
		  
	?>
        <div id="restrict">Restricted!!! You must login as an administrator. </div>
	<?php
	 }
	 else {
		
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Crash Data| Admin Area</title>

<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/includes.css" rel="stylesheet" type="text/css" />
<link href="css/menus.css" rel="stylesheet" type="text/css" />
<link href="css/users.css" rel="stylesheet" type="text/css" />

<link type="text/css" href="css/jquery-ui-1.10.0.custom.css" rel="stylesheet">
<script type="text/javascript" src="jquery/jquery-1.9.1.js"></script>
<script type="text/javascript" src="jquery/jquery-ui-1.10.3.custom.min.js"></script>

<!--<script type="text/javascript" src="jquery/jQuery.js"></script> 
<script type="text/javascript" src='jquery/jQuery.session.js'></script>
<script src="jquery/isSessionActive.js"></script>
<script src='jquery/new_user.js' /> -->

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
          <?php
           $query = "SELECT * FROM users";
			$results = mysql_query($query)
			or die(mysql_error());?>
            <span id="username-label"><a href="access_reports.php">Access Reports</a></span>
            <span id="username-label"><a href="contacts.php">Contacts</a></span><br />
            <h3>List of users registered in the System</h3>
            
            <table>
                <tr>
                    <th width="25%">Full Names</td>
                    <th width="15%">Job Number</td>
                    <th width="5%">Level</td>
                    <th width="25%">Date/Time Added</td>
                    <th width="10%"></td>
                    <th width="10%"></td>
                    <th width="10%"></td>
                </tr>
                
                <?php //4213
                while ($row = mysql_fetch_array($results)) {
                extract($row);
                echo "<tr><td width=\"25%\">";
                echo $row['full_names'];
                echo "</td><td width=\"15%\">";
                echo $row['job_number'];
                echo "</td><td width=\"5%\">";
                echo $row['user_level'];
                echo "</td><td width=\"25%\">";
                echo $row['date_time'];
				echo "</td><td width=\"10%\">";?>
				<a href="update_user.php?id=<?php echo $row['users_id'];?>">Update</a>
                <?php
				echo "</td><td width=\"10%\">";?>
                <a href="delete_user.php?id=<?php echo $row['users_id'];?>">Delete</a>
                <?php
				echo "</td><td width=\"10%\">";?>
				<a href="user_logs.php?id=<?php echo $row['job_number'];?>">User Logs</a>
                <?php echo "</td></tr>";
            }
            ?>
            </table>
                   
  </div>
   
  
  <div id="right_bar">
 
        <div id="new_user_header">
           <span id="label_user">Register User</span>
        </div>
        
        <div id="new_user">
         
		<form id ="newUserForm" name ="newUserForm" action="verify.php" method="post" >
               <span id="label_texts">First Name</span> <br />
               <input type="text" name="first_name" id="first_name" size="45" class="new_user_input" />
               <span id="label_texts">Last Name</span> <br />
               <input type="text" name="last_name" id="last_name" size="45" class="new_user_input" />
               <span id="label_texts">Job Number</span> <br />
               <input type="text" name="job_number" id="job_number" size="45" class="new_user_input" />
               <span id="label_texts">User Level(1. Admin 2. Expert 3. Other)</span> <br />
               <input type="text" name="user_level" id="user_level" size="45" class="new_user_input" />
               <span id="label_texts">Password</span> <br />
               <input type="password" name="password" id="password" size="45" class="new_user_input" />
               <span id="label_texts">Repeat Password</span> <br />
               <input type="password" name="password_rep" id="password_rep" size="45" class="new_user_input" />
               <span id="error"></span> 
               <input type="submit" name="submit" value="Register" />
               <input type="hidden" name="tag" value="register" />
               <?php 
							if (isset($_GET['redirect'])) {
								$redirect = $_GET['redirect'];
							} else {
								$redirect = "admin.php";
							}
							?>
                      <input type="hidden" name="redirect"
               	            value="<?php echo $redirect; ?>"></td>
           </form>
        
        </div>
  		
  </div>     
 
</div>

</body>
</html>
<?php
}
 ?>