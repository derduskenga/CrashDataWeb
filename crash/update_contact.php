<?php
	include "auth_user.inc.php";
	include "conn.inc.php";
	
	//set up static variables
	  $page_title = "Update Contact";
	  $user_agent = getenv("HTTP_USER_AGENT");
	 // $date_accessed = date("Y-m-d");
	  	  
?>
<?php if (isset($_REQUEST['id']) && $_REQUEST['id'] != '' && isset($_SESSION['user_level']) &&
		$_SESSION['user_level'] == "1") {
			
			//create and issue query  //
	  $query = "insert into access_tracker values
		 ('','".$_SESSION['job_number']."','$page_title', '$user_agent', NOW())";
	  mysql_query($query)or die(mysql_error());
		
			
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Crash Data| Update Contact</title>

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
   
  <div id="center_info">
          <h2>Update Contact Information</h2>
	
        <h3>Here you can update contact information.</h3>
        <div id="div_contact">
	<?php
		if (isset($_POST['submit']) && $_POST['submit'] == "Update") {
				
			$query_update = "UPDATE emergency SET  respondent = '".$_POST['respondent']." ', phone_number = '".$_POST['phone_number']."' WHERE emergency_id = '". $_POST['id']."'";
							
			$result_update = mysql_query($query_update)
			or die(mysql_error());
			
			$query = "SELECT * FROM emergency WHERE emergency_id = '". $_POST['id']."' ";
			
			$result = mysql_query($query)
			or die(mysql_error());
			
			$row = mysql_fetch_array($result);
		?>
		<b>Contact information has been updated.</b><br>
		<a href="contacts.php">Click here</a> to return to your Contacts.
			<form action="update_contact.php" method="post">
			 <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
             <table id="no_border"> 
               <tr>
				 <td id="td_label">Respondent:</td>
                 <td id="td_value"> <input type="text" name="respondent" size="35" value="<?php echo $row['respondent']; ?>"></td>
               </tr>
               <tr>
				 <td id="td_label">Phone Number:</td>
                 <td id="td_value"> <input type="text" name="phone_number" size="35" value="<?php echo $row['phone_number']; ?>"></td>
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
			
			$query = "SELECT * FROM emergency WHERE emergency_id = '". $_GET['id']."' ";
			
			$result = mysql_query($query)
			or die(mysql_error());
			
			$row = mysql_fetch_array($result);
		?>
	
		   <a href="contacts.php">Click here</a> to return to your Contacts.
			<form action="update_contact.php" method="post">
			  <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
				<table id="no_border"> 
                   <tr>
                     <td id="td_label">Respondent:</td>
                     <td id="td_value"> <input type="text" name="respondent" size="35" value="<?php echo $row['respondent']; ?>"></td>
                   </tr>
                   <tr>
                     <td id="td_label">Phone Number:</td>
                     <td id="td_value"> <input type="text" name="phone_number" size="35" value="<?php echo $row['phone_number']; ?>"></td>
                   </tr>
                   <tr>
                      <td id="td_label"></td>				
                      <td id="td_value"><input type="submit" name="submit" value="Update"></td>
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
<?php
} else {
	header("Refresh: 5; URL=index.php");
			echo "You are not allowed to access this page! " .
				 "You are being sent to the home page!<br>";
			echo "(If you're browser doesn't support this, " .
				 "<a href=\"index.php\">click here</a>)";
			die();
}
 ?>