<?php
	include "auth_user.inc.php";
	include "conn.inc.php";
	
	//set up static variables
	  $page_title = "Contacts";
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
<title>Crash Data| Contacts</title>

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
  
  <?php 
			if (isset($_POST['submit']) && $_POST['submit'] == "Save") {
						
				$query_insert = "INSERT INTO emergency (respondent, phone_number)
				VALUES('".$_POST['respondent']." ', '".$_POST['phone_number']." ')";
						   
			//$query = "UPDATE users SET  full_names = '".$names." ', user_level = '".$_POST['user_level']."',
			// job_number = '".$_POST['job_number']."' WHERE users_id = '" . $_POST['id'] . "'";
							
			$result_insert = mysql_query($query_insert)
			or die(mysql_error());
						
	  ?>
   
  <div id="user_info">
          <?php
           $query = "SELECT * FROM emergency";
			$results = mysql_query($query)
			or die(mysql_error());?>
            
            <a href="admin.php">Click Here</a> to return to the Admin Panel. <br />
            
            <h3>List of emergency contacts registered in the System</h3>
            
            <table>
                <tr>
                    <th width="40%">Respondent</td>
                    <th width="30%">Phone Number</td>
                    <th width="15%"></td>
                    <th width="15%"></td>
                </tr>
                
                <?php //4213
                while ($row = mysql_fetch_array($results)) {
                extract($row);
                echo "<tr><td width=\"40%\">";
                echo $row['respondent'];
                echo "</td><td width=\"30%\">";
                echo $row['phone_number'];                
				echo "</td><td width=\"15%\">";?>
				<a href="update_contact.php?id=<?php echo $row['emergency_id'];?>">Update</a>
                <?php
				echo "</td><td width=\"15%\">";?>
                <a href="delete_contact.php?id=<?php echo $row['emergency_id'];?>">Delete</a>                
                <?php echo "</td></tr>";
            }
            ?>
            </table>
                   
  </div>
   
  
  <div id="right_bar">
  
  		<div id="new_user_header">
           <span id="label_user">New Contact</span>
        </div>
        
        <div id="new_user">
        
			
		<form action="contacts.php" method="post" >
               <span id="label_texts">Respondent</span> <br />
               <input type="text" name="respondent" size="35" class="new_user_input" />
               <span id="label_texts">Phone Number</span> <br />
               <input type="text" name="phone_number" size="35" class="new_user_input" />
               <span id="error"></span> 
               <input type="submit" name="submit" value="Save" />
              
           </form>
        
        </div>
 
  </div>  
  
  <?php } else 
           {?> 
           
             <div id="user_info">
          <?php
           $query = "SELECT * FROM emergency";
			$results = mysql_query($query)
			or die(mysql_error());?>
            
            <a href="admin.php">Click Here</a> to return to the Admin Panel. <br />
            
            <h3>List of emergency contacts registered in the System</h3>
            
            <table>
                <tr>
                    <th width="40%">Respondent</td>
                    <th width="30%">Phone Number</td>
                    <th width="15%"></td>
                    <th width="15%"></td>
                </tr>
                
                <?php //4213
                while ($row = mysql_fetch_array($results)) {
                extract($row);
                echo "<tr><td width=\"40%\">";
                echo $row['respondent'];
                echo "</td><td width=\"30%\">";
                echo $row['phone_number'];                
				echo "</td><td width=\"15%\">";?>
				<a href="update_contact.php?id=<?php echo $row['emergency_id'];?>">Update</a>
                <?php
				echo "</td><td width=\"15%\">";?>
                <a href="delete_contact.php?id=<?php echo $row['emergency_id'];?>">Delete</a>                
                <?php echo "</td></tr>";
            }
            ?>
            </table>
                   
  </div>
   
  
  <div id="right_bar">
  
  		<div id="new_user_header">
           <span id="label_user">New Contact</span>
        </div>
        
        <div id="new_user">
        
			
		<form action="contacts.php" method="post" >
               <span id="label_texts">Respondent</span> <br />
               <input type="text" name="respondent" size="35" class="new_user_input" />
               <span id="label_texts">Phone Number</span> <br />
               <input type="text" name="phone_number" size="35" class="new_user_input" />
               <span id="error"></span> 
               <input type="submit" name="submit" value="Save" />
              
           </form>
        
        </div>
 
  </div>  
  <?php } ?>  
 
</div>

</body>
</html>
<?php
}
 ?>