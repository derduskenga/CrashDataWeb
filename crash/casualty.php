<?php
	include "auth_user.inc.php";
	include "conn.inc.php";
	
	//set up static variables
	  $page_title = "Casualty";
	  $user_agent = getenv("HTTP_USER_AGENT");
	 // $date_accessed = date("Y-m-d");
	  if ((isset($_REQUEST['id']) && $_REQUEST['id'] != '') || (isset($_REQUEST['acc_id']) && $_REQUEST['acc_id'] != '')){  
	  //create and issue query  //
	  $query = "insert into access_tracker values
		 ('','".$_SESSION['job_number']."','$page_title', '$user_agent', NOW())";
	  mysql_query($query)or die(mysql_error());
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Crash Data| Casualty</title>

<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/includes.css" rel="stylesheet" type="text/css" />
<link href="css/menus.css" rel="stylesheet" type="text/css" />
<link href="css/casualty.css" rel="stylesheet" type="text/css" />

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
  <?php
if (isset($_POST['submit']) && $_POST['submit'] == "submit") {
			//$names = '$_POST["first_name"]." ".$_POST["last_name"}';
			$first_name = $_REQUEST['first_name'];
			$last_name = $_REQUEST['last_name'];
			$acc_id = $_REQUEST['acc_id'];
			$gender = $_REQUEST['gender'];
			$status = $_REQUEST['status'];
			$age_group = $_REQUEST['age'];
			$nationality = $_REQUEST['nationality'];
					
			$full_names = $first_name." ".$last_name;
			
			$result = mysql_query("SELECT crash_id from accident WHERE crash_id = '".$acc_id." ' ");
			$no_of_rows = mysql_num_rows($result);
			if ($no_of_rows > 0) {
				// user existed 
				$query_insert = "INSERT INTO casuality (crash_id, full_names, gender, status, age_group, nationality)
				VALUES('".$acc_id." ', '".$full_names." ', '".$gender." ', '".$status." ', '".$age_group." ', '".$nationality." ')";
						   
			//$query = "UPDATE users SET  full_names = '".$names." ', user_level = '".$_POST['user_level']."',
			// job_number = '".$_POST['job_number']."' WHERE users_id = '" . $_POST['id'] . "'";
							
			$result_insert = mysql_query($query_insert)
			or die(mysql_error());
				//return true;
			} else {
				// user not existed
				echo "Accident ID ".$acc_id." Does not exist";
				
			}
			
			
			
			/*$query = "SELECT * FROM users WHERE users_id = '" . $_POST['id'] . "'";
			
			$result = mysql_query($query)
			or die(mysql_error());
			
			$row = mysql_fetch_array($result);
			$names = explode(" ",$row['full_names']);
			*/
			
		?>
   
  <div id="user_info">
  
  <?php
           $query = "SELECT * FROM casuality WHERE crash_id = '" . $_POST['acc_id'] . "'";
			$results = mysql_query($query)
			or die(mysql_error());?>
            
              <h3>This is the list of casualaties in the Accident with ID: <?php echo $_POST['acc_id']; ?></h3>
            <table>
                <tr class="title">
                    <th width="25%">Full Names</th>
                    <th width="10%">Gender</th>
                    <th width="15%">Status</th>
                    <th width="15%">Age Group</th>
                    <th width="15%">Nationality</th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                </tr>
                
                <?php //4213
                while ($row = mysql_fetch_array($results)) {
                extract($row);
                echo "<tr><td width=\"25%\">";
                echo $row['full_names'];
                echo "</td><td width=\"10%\">";
                echo $row['gender'];
                echo "</td><td width=\"15%\">";
                echo $row['status'];
                echo "</td><td width=\"15%\">";
                echo $row['age_group'];
				echo "</td><td width=\"15%\">";
                echo $row['nationality'];
				echo "</td><td width=\"10%\">";?>
				<a href="update_casualty.php?id=<?php echo $row['sys_casuality_id'];?>">Update</a>
                <?php
				echo "</td><td width=\"10%\">";?>
				<a href="delete_casualty.php?id=<?php echo $row['sys_casuality_id'];?>&crash_id=<?php echo $row['crash_id'];?>">Delete</a>
                <?php echo "</td></tr>";
            }
            ?>
            </table>
  
  </div>
   
  
  <div id="right_bar">
  
  <div id="cas_header">
      <span id="label_casualty">Add New Casualty</span>
    </div>
    <div id="cas_info">
    
    <form action="casualty.php" method="post">
       <table>
           <tr>
              <td><span id="label_texts">Accident ID: </span></td>
              <td><input type="text" name="acc_id" id="acc_id" size="40" class="new_user_input" value="<?php echo $_POST['acc_id']; ?>" /></td>
          </tr>
          <tr>
              <td><span id="label_texts">First Name: </span></td>
              <td><input type="text" name="first_name" id="first_name" size="40" class="new_user_input" /></td>
          </tr>
          <tr>
              <td><span id="label_texts">Last Name: </span></td>
              <td><input type="text" name="last_name" id="last_name" size="40" class="new_user_input" /></td>
          </tr>
          <tr>
              <td><span id="label_texts">Gender: </span></td>
              <td><input type="radio" name="gender" value="male" /> Male<input type="radio" name="gender" value="female" /> Female</td>
          </tr>
          <tr>
              <td><span id="label_texts">Age Group: </span></td>
              <td>
                   <label>
                      <select name="age">
                          <option value="No age selected">--Select--</option>
                          <option value="0-5 years">0-5 years</option>
                          <option value="6-10 years">6-10 years</option>
                          <option value="11-16 years">11-16 years</option>
                          <option value="17-25 years">17-25 years</option>
                          <option value="26-35 years">26-35 years</option>
                          <option value="36-45 years">36-45 years</option>
                          <option value="46-55 years">46-55 years</option>
                          <option value="56-65 years">56-65 years</option>
                          <option value="over 65 years">over 65 years</option>
                      </select>
                  </label>
             </td>
          </tr>
          <tr>
              <td><span id="label_texts">Nationality: </span></td>
              <td>
                   <label>
                      <select name="nationality">
                          <option value="No Nationality selected">--Select--</option>
                          <option value="Kenyan">Kenyan</option>
                          <option value="Other African">Other African</option>
                          <option value="American">American</option>
                          <option value="Asian">Asian</option>
                          <option value="European">European</option>
                      </select>
                  </label>
             </td>
          </tr>
          <tr>
              <td><span id="label_texts">Status: </span></td>
              <td>
                  <input type="radio" name="status" value="killed" /> Killed <br />
                  <input type="radio" name="status" value="seriously injured" /> Seriously Injured <br />
                  <input type="radio" name="status" value="slightly injured" /> Slightly Injured
              </td>
          </tr>
          <tr>
              <td></td>
              <td><input type="submit" name="submit" value="submit" /><input type="button" value="Cancel" name="cancel" id="cancel" /></td>
          </tr>
       </table>
      			 <input type="hidden" name="tag" value="casualty" />
               <?php 
							if (isset($_GET['redirect'])) {
								$redirect = $_GET['redirect'];
							} else {
								$redirect = "casualty.php";
							}
							?>
                      <input type="hidden" name="redirect"
               	            value="<?php echo $redirect; ?>"></td>
       </form>
       
    </div>
    <?php }
	 else { ?>
	 <div id="user_info">
  <?php
  
           $query = "SELECT * FROM casuality WHERE crash_id = '" . $_GET['id'] . "'";
			$results = mysql_query($query)
			or die(mysql_error());?>
          
            <a href="display_accident.php?id=<?php echo $_GET['id'];?>">Click Here</a> to go back to the Accident Details page: <br />
              <h3>This is the list of casualaties in the Accident with ID: <?php echo $_GET['id']; ?></h3>
            <table>
                <tr class="title">
                    <th width="25%">Full Names</th>
                    <th width="10%">Gender</th>
                    <th width="15%">Status</th>
                    <th width="15%">Age Group</th>
                    <th width="15%">Nationality</th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                </tr>
                
                <?php //4213
                while ($row = mysql_fetch_array($results)) {
                extract($row);
                echo "<tr><td width=\"25%\">";
                echo $row['full_names'];
                echo "</td><td width=\"10%\">";
                echo $row['gender'];
                echo "</td><td width=\"15%\">";
                echo $row['status'];
                echo "</td><td width=\"15%\">";
                echo $row['age_group'];
				echo "</td><td width=\"15%\">";
                echo $row['nationality'];
				echo "</td><td width=\"10%\">";?>
				<a href="update_casualty.php?id=<?php echo $row['sys_casuality_id'];?>">Update</a>
                <?php
				echo "</td><td width=\"10%\">";?>
				<a href="delete_casualty.php?id=<?php echo $row['sys_casuality_id'];?>&crash_id=<?php echo $row['crash_id'];?>">Delete</a>
                <?php echo "</td></tr>";
            }
            ?>
            </table>
  
  </div>
   
  
  <div id="right_bar">
  
  <div id="cas_header">
      <span id="label_casualty">Add New Casualty</span>
    </div>
    <div id="cas_info">
    
    <form action="casualty.php" method="post">
       <table>
           <tr>
              <td><span id="label_texts">Accident ID: </span></td>
              <td><input type="text" name="acc_id" id="acc_id" size="40" class="new_user_input" value="<?php echo $_GET['id']; ?>" /></td>
          </tr>
          <tr>
              <td><span id="label_texts">First Name: </span></td>
              <td><input type="text" name="first_name" id="first_name" size="40" class="new_user_input" /></td>
          </tr>
          <tr>
              <td><span id="label_texts">Last Name: </span></td>
              <td><input type="text" name="last_name" id="last_name" size="40" class="new_user_input" /></td>
          </tr>
          <tr>
              <td><span id="label_texts">Gender: </span></td>
              <td><input type="radio" name="gender" value="male" /> Male<input type="radio" name="gender" value="female" /> Female</td>
          </tr>
          <tr>
              <td><span id="label_texts">Age Group: </span></td>
              <td>
                   <label>
                      <select name="age">
                          <option value="No age selected">--Select--</option>
                          <option value="0-5 years">0-5 years</option>
                          <option value="6-10 years">6-10 years</option>
                          <option value="11-16 years">11-16 years</option>
                          <option value="17-25 years">17-25 years</option>
                          <option value="26-35 years">26-35 years</option>
                          <option value="36-45 years">36-45 years</option>
                          <option value="46-55 years">46-55 years</option>
                          <option value="56-65 years">56-65 years</option>
                          <option value="over 65 years">over 65 years</option>
                      </select>
                  </label>
             </td>
          </tr>
          <tr>
              <td><span id="label_texts">Nationality: </span></td>
              <td>
                   <label>
                      <select name="nationality">
                          <option value="No Nationality selected">--Select--</option>
                          <option value="Kenyan">Kenyan</option>
                          <option value="Other African">Other African</option>
                          <option value="American">American</option>
                          <option value="Asian">Asian</option>
                          <option value="European">European</option>
                      </select>
                  </label>
             </td>
          </tr>
          <tr>
              <td><span id="label_texts">Status: </span></td>
              <td>
                  <input type="radio" name="status" value="killed" /> Killed <br />
                  <input type="radio" name="status" value="seriously injured" /> Seriously Injured <br />
                  <input type="radio" name="status" value="slightly injured" /> Slightly Injured
              </td>
          </tr>
          <tr>
              <td></td>
              <td><input type="submit" name="submit" value="submit" /><input type="button" value="Cancel" name="cancel" id="cancel" /></td>
          </tr>
       </table>
      			 <input type="hidden" name="tag" value="casualty" />
               <?php 
							if (isset($_GET['redirect'])) {
								$redirect = $_GET['redirect'];
							} else {
								$redirect = "casualty.php";
							}
							?>
                      <input type="hidden" name="redirect"
               	            value="<?php echo $redirect; ?>"></td>
       </form>
       
    </div>
    <?php } ?>
    
    <div id="cas_upload">
        <form action="casualty.php" method="post">
			<span id="label_texts">Upload Excel file: </span> <input type="file" name="file" id="file" /> 
			<input type="submit" name="submit" value="submit" />
		</form>
    </div>
  
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