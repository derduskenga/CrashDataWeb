<?php
	include "auth_user.inc.php";
	include "conn.inc.php";
	
	//set up static variables
	  $page_title = "Access Reports";
	  $user_agent = getenv("HTTP_USER_AGENT");
	 // $date_accessed = date("Y-m-d");
	  
	  //create and issue query  //
	  $query = "insert into access_tracker values
		 ('','".$_SESSION['job_number']."','$page_title', '$user_agent', NOW())";
	  mysql_query($query)or die(mysql_error());
?>
<?php
	if (isset($_SESSION['user_level']) &&
		$_SESSION['user_level'] != "1") {
		  
	?>
        <div id="restrict">Restricted!!! You must login as an administrator. </div>
	<?php
	 }
	 else {
		 //issue query and select results for counts
		  $count_sql = "select count(page_title) from access_tracker ";
		  $count_res = mysql_query($count_sql) or die(mysql_error());
		  $all_count = mysql_result($count_res, 0, "count(page_title)");
		  
		  //issue query and select results for user agents
		  $user_agent_sql = "select distinct user_agent, count(user_agent) as count
			  from access_tracker group by user_agent order by count desc";
		  $user_agent_res = mysql_query($user_agent_sql)
			  or die(mysql_error());
		  //start user agent display block
		  $user_agent_block = "<ul>";
		  
		  //loop through user agent results
		  while ($row_ua = mysql_fetch_array($user_agent_res)) {
			 $user_agent = $row_ua['user_agent'];
			 $user_agent_count = $row_ua['count'];
			 $user_agent_block .= "
			 <li>$user_agent
			 <ul>
			 <li><em>accesses per browser: $user_agent_count</em>
			 </ul>";
		  }
		  
		  //finish up the user agent block
		  $user_agent_block .= "</ul>";
		  
		  //issue query and select results for pages
		  $page_title_sql = "select distinct page_title, count(page_title) as count
			  from access_tracker group by page_title order by count desc";
		  $page_title_res = mysql_query($page_title_sql)
			  or die(mysql_error());
		  //start page title display block
		  $page_title_block = "<ul>";
		// loop through results
		  while ($row_pt = mysql_fetch_array($page_title_res)) {
			 $page_title = $row_pt['page_title'];
			 $page_count = $row_pt['count'];
			 $page_title_block .= "
			 <li>$page_title
				 <ul>
				 <li><em>accesses per page: $page_count</em>
				 </ul>";
		  }
		  
		  //finish up the page title block
		  $page_title_block .= "</ul>";
		
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Crash Data| Access Reports</title>

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
  
  <h2>Access Report</h2>
  <h3>Analysis of various web browsers and pages accessed by users in the system</h3>
  <a href="admin.php" >Click Me</a> to return to the Admin Area.
  
  	<div id="div_analysis">
          
           <P><strong>Total Accesses Tracked:</strong> <? echo "$all_count"; ?></p>
           <P><strong>Web Browsers Used:</strong>
           <?php print "$user_agent_block"; ?>
           <P><strong>Individual Pages:</strong>
          <?php print "$page_title_block"; ?>
      </div>
  </div>  
 
</div>

</body>
</html>
<?php
}
 ?>