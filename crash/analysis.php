<?php
	include "auth_user.inc.php";
	include "conn.inc.php";
	
	//set up static variables
	  $page_title = "Expert Analysis";
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
<title>Crash Data| Expert Analysis</title>

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
  
     <?php
		if (isset($_POST['submit']) && $_POST['submit'] == "Update") {
			
			$query_update = "UPDATE crash_analysis SET crash_id = '".$_POST['crash_id']." ', job_number = '".$_POST['job_number']."',
			 remarks = '".$_POST['remarks']."', measures = '".$_POST['measures']."' WHERE crash_id = '" . $_POST['id'] . "'";
							
			$result_update = mysql_query($query_update)
			or die(mysql_error());
			
			$query = "SELECT * FROM crash_analysis WHERE crash_id = '" . $_POST['crash_id'] . "'";
			
			$result = mysql_query($query)
			or die(mysql_error());
			
			$row = mysql_fetch_array($result);
		?>
		<b>Crash Analysis information has been updated.</b><br>
		<a href="display_accident.php?id=<?php echo $_POST['id'];?>">Click Here</a> to go back to the Accident Details page:
           <h3>Analysis Details of Accident with ID: <?php echo $_POST['id'];?></h3>
           <div id="div_analysis">
			<form action="analysis.php" method="post">
                 <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
				<table id="no_border">
                    <tr>
                    	<td id="td_label">Accident ID: </td>
                        <td id="td_value"> <input type="text" name="crash_id" value="<?php echo $row['crash_id']; ?>" size="40"></td>
                    </tr>
                    <tr>
                    	<td id="td_label">Expert Job Number: </td>
                        <td id="td_value"><input type="text" name="job_number" value="<?php echo $row['job_number']; ?>" size="40"></td>
                    </tr>
                    <tr>
                    	<td id="td_label">Remarks: </td>
                        <td id="td_value"><textarea wrap="virtual" name="remarks" cols="30" rows="10"><?php echo $row['remarks']; ?></textarea></td>
                    </tr>
                    <tr>
                    	<td id="td_label">Measures:</td>
                        <td id="td_value"> <textarea wrap="virtual" name="measures" cols="30" rows="10"><?php echo $row['measures']; ?></textarea></td>
                   </tr>
               	    <tr>
                       <td id="td_label"><?php 
					   						if(isset($_SESSION['user_level']) && ($_SESSION['user_level'] == '1' || $_SESSION['user_level'] == '2')){
												 ?> <input type="submit" name="submit" value="Update" />
												 <?php } ?></td>
                       <td id="td_value"></td>
                   </tr>
                </table>
			</form>
            </div>
		
		<?php
		} 
				
		else if (isset($_POST['submit']) && $_POST['submit'] == "Save") {
			
			$query_insert = "INSERT INTO crash_analysis (crash_id, job_number, remarks, measures, date_inserted)
				VALUES('".$_POST['crash_id']." ', '".$_POST['job_number']." ', '".$_POST['remarks']." ', '".$_POST['measures']." ', 'NOW() ')";
							
			$result_insert = mysql_query($query_insert)
			or die(mysql_error());
			
			$query = "SELECT * FROM crash_analysis WHERE crash_id = '" . $_POST['crash_id'] . "'";
			
			$result = mysql_query($query)
			or die(mysql_error());
			
			$row = mysql_fetch_array($result);
		?>
		<b>Crash information information has been saved.</b><br>
		<a href="display_accident.php?id=<?php echo $_POST['id'];?>">Click Here</a> to go back to the Accident Details page:
        	<h3>Analysis Details of Accident with ID: <?php echo $_POST['id'];?></h3>
        <div id="div_analysis">
			<form action="analysis.php" method="post">
                 <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
				<table id="no_border">
                    <tr>
                    	<td id="td_label">Accident ID: </td>
                        <td id="td_value"> <input type="text" name="crash_id" value="<?php echo $row['crash_id']; ?>" size="40"></td>
                    </tr>
                    <tr>
                    	<td id="td_label">Expert Job Number: </td>
                        <td id="td_value"><input type="text" name="job_number" value="<?php echo $row['job_number']; ?>" size="40"></td>
                    </tr>
                    <tr>
                    	<td id="td_label">Remarks: </td>
                        <td id="td_value"><textarea wrap="virtual" name="remarks" cols="30" rows="10"><?php echo $row['remarks']; ?></textarea></td>
                    </tr>
                    <tr>
                    	<td id="td_label">Measures:</td>
                        <td id="td_value"> <textarea wrap="virtual" name="measures" cols="30" rows="10"><?php echo $row['measures']; ?></textarea></td>
                   </tr>
                	<tr>
                       <td id="td_label"><?php 
					   						if(isset($_SESSION['user_level']) && ($_SESSION['user_level'] == '1' || $_SESSION['user_level'] == '2')){
												 ?> <input type="submit" name="submit" value="Update" />
												 <?php } ?></td>
                       <td id="td_value"></td>
                   </tr>
                </table>
			</form>
            </div>
		
		<?php
		} 
		else {
			
			$query = "SELECT * FROM crash_analysis WHERE crash_id = '" . $_GET['id'] . "'";			
			$result = mysql_query($query)
			or die(mysql_error());
			
			$no_of_rows = mysql_num_rows($result);
			
			if($no_of_rows>0){
			
			$row = mysql_fetch_array($result);
		?>
		
        <a href="display_accident.php?id=<?php echo $_GET['id'];?>">Click Here</a> to go back to the Accident Details page: 
        <h3>Analysis Details of Accident with ID: <?php echo $_GET['id'];?></h3>
        <div id="div_analysis">
        	
			<form action="analysis.php" method="post">
                 <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
				<table id="no_border">
                    <tr>
                    	<td id="td_label">Accident ID: </td>
                        <td id="td_value"> <input type="text" name="crash_id" value="<?php echo $row['crash_id']; ?>" size="40"></td>
                    </tr>
                    <tr>
                    	<td id="td_label">Expert Job Number: </td>
                        <td id="td_value"><input type="text" name="job_number" value="<?php echo $row['job_number']; ?>" size="40"></td>
                    </tr>
                    <tr>
                    	<td id="td_label">Remarks: </td>
                        <td id="td_value"><textarea wrap="virtual" name="remarks" cols="30" rows="10"><?php echo $row['remarks']; ?></textarea></td>
                    </tr>
                    <tr>
                    	<td id="td_label">Measures:</td>
                        <td id="td_value"> <textarea wrap="virtual" name="measures" cols="30" rows="10"><?php echo $row['measures']; ?></textarea></td>
                   </tr>
                   <tr>
                       <td id="td_label"><?php 
					   						if(isset($_SESSION['user_level']) && ($_SESSION['user_level'] == '1' || $_SESSION['user_level'] == '2')){
												 ?> <input type="submit" name="submit" value="Update" />
												 <?php } ?></td>
                       <td id="td_value"></td>
                   </tr>
                </table>
			</form>
		</div>
		<?php }
		   else{ ?>
			   
               <a href="display_accident.php?id=<?php echo $_GET['id'];?>">Click Here</a> to go back to the Accident Details page:
               <h3>Analysis Details of Accident with ID: <?php echo $_GET['id'];?></h3>
               <div id="div_analysis"> 
			<form action="analysis.php" method="post">
                 <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
				<table id="no_border">
                    <tr>
                    	<td id="td_label">Accident ID: </td>
                        <td id="td_value"> <input type="text" name="crash_id" size="40"></td>
                    </tr>
                    <tr>
                    	<td id="td_label">Expert Job Number: </td>
                        <td id="td_value"><input type="text" name="job_number" size="40"></td>
                    </tr>
                    <tr>
                    	<td id="td_label">Remarks: </td>
                        <td id="td_value"><textarea wrap="virtual" name="remarks" cols="30" rows="10"></textarea></td>
                    </tr>
                    <tr>
                    	<td id="td_label">Measures:</td>
                        <td id="td_value"> <textarea wrap="virtual" name="measures" cols="30" rows="10"></textarea></td>
                   </tr>
                   <tr>
                       <td id="td_label"><?php 
					   						if(isset($_SESSION['user_level']) && ($_SESSION['user_level'] == '1' || $_SESSION['user_level'] == '2')){
												 ?> <input type="submit" name="submit" value="Save" />
												 <?php } ?></td>
                       <td id="td_value"></td>
                   </tr>
                </table>                
				
			</form>
		</div>
			<?php   }
		}
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