<?php
	include "auth_user.inc.php";
	include "conn.inc.php";
	
	//set up static variables
	  $page_title = "User Logs";
	  $user_agent = getenv("HTTP_USER_AGENT");
	 // $date_accessed = date("Y-m-d");
	  
	  //create and issue query  //
	  $query = "insert into access_tracker values
		 ('','".$_SESSION['job_number']."','$page_title', '$user_agent', NOW())";
	  mysql_query($query)or die(mysql_error());
?>
<?php
	if (isset($_REQUEST['id']) && $_REQUEST['id'] != '' && isset($_SESSION['user_level']) &&
		$_SESSION['user_level'] == "1") {
			
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Crash Data| User Logs</title>

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
  <h2>User Logs</h2>
  <h3>User Logs information for user with Job Number: <?php echo  $_GET['id']; ?></h3>
            <a href="admin.php" >&lt;&lt;Back</a>  
            <div id="div_logs">
          <?php
           $query = "SELECT * FROM access_tracker where job_number = '" . $_GET['id'] . "'";
			$results = mysql_query($query)
			or die(mysql_error());?>
            
            <table>
                <tr>
                    <td width="25%">Page Title</td>
                    <td width="50%">User Agent</td>
                    <td width="25%">Date/Time Accessed</td>
                    
                </tr>
                
                <?php //4213
                while ($row = mysql_fetch_array($results)) {
                extract($row);
                echo "<tr><td width=\"25%\">";
                echo $row['page_title'];
                echo "</td><td width=\"50%\">";
                echo $row['user_agent'];
                echo "</td><td width=\"25%\">";
                echo $row['date_time_accessed'];
                echo "</td></tr>";
            }
            ?>
            </table>
            </div>
                   
  </div>
   
    		
  </div>     
 
</div>

</body>
</html>
<?php
}else {
	header("Refresh: 5; URL=index.php");
			echo "You are not allowed to access this page! " .
				 "You are being sent to the home page!<br>";
			echo "(If you're browser doesn't support this, " .
				 "<a href=\"index.php\">click here</a>)";
			die();
}
 ?>