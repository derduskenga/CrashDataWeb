<?php
	include "auth_user.inc.php";
	include "conn.inc.php";
	
	//set up static variables
	  $page_title = "Delete casualty";
	  $user_agent = getenv("HTTP_USER_AGENT");
	 // $date_accessed = date("Y-m-d");
	    
	
	if (isset($_REQUEST['id']) && $_REQUEST['id'] != '' && isset($_SESSION['user_level']) &&
		$_SESSION['user_level'] == "1"){
		
		//create and issue query  //
	  $query = "insert into access_tracker values
		 ('','".$_SESSION['job_number']."','$page_title', '$user_agent', NOW())";
	  mysql_query($query)or die(mysql_error());
		if (isset($_POST['submit']) && $_POST['submit'] == "Yes") {
			
		//	$query_select = "SELECT * FROM casuality " .
		//					"WHERE sys_casuality_id = '" . $_POST['id'] . "'";
			$query_delete = "DELETE FROM casuality " .
							"WHERE sys_casuality_id = '" . $_POST['id'] . "'";
							
			$result_delete = mysql_query($query_delete)
			or die(mysql_error());
		//	$result_select = mysql_query($query_select)
		//	or die(mysql_error());
			
		//	$row = mysql_fetch_array($result_select);
			echo "<a href=\"casualty.php?id=".$_POST['crash_id']."\">click here</a> to go back to casualties information";
			
			//$_SESSION['user_logged'] = "";
			//$_SESSION['user_password'] = "";
		/*	header("Refresh: 5; URL=users.php");
			echo "Account has been deleted! " .
				 "You are being sent to the users area!<br>";
			echo "(If you're browser doesn't support this, " .
				 "<a href=\"users.php\">click here</a>)";
			die();*/
		} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Crash Data| Delete Casualty</title>

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
  
  	<h3>Delete Casualty?</h3>
  
      <div id="div_delete">
        Are you sure you want to delete this casualty?<br>
        There is no way to retrieve this casualty details once you confirm!<br>
        <form action="delete_casualty.php" method="post">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <input type="hidden" name="crash_id" value="<?php echo $_GET['crash_id']; ?>">
            <input type="submit" name="submit" value="Yes"> &nbsp;
            <input type="button" value=" No " onClick="history.go(-1);">
        </form>
        </div>
	</p>
  </div>   
 
</div>
</body>
<?php
 }
} else {
		header("Refresh: 5; URL=index.php");
			echo "You are not allowed to access this page! " .
				 "You are being sent to the home page!<br>";
			echo "(If you're browser doesn't support this, " .
				 "<a href=\"index.php\">click here</a>)";
			die();
}
?>
</html>
