<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" /> 
<!--<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" />-->
<link rel="stylesheet" type="text/css" href="css/style.css" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Crash Data | Login</title>

<!-- load jQuery -->
<script type="text/javascript" src="jquery/jQuery.js"></script>
<!--<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script src='jquery/jQuery.session.js'></script>
<script src='jquery/isSessionActive.js'></script>
<script src='jquery/login.js'></script> -->

<style type='text/css'>

body {
	margin: 0px;
	padding: 0px;
}
	.content {
		padding-top: 100px;
	}

.header {
height: 53px;
width: 360px;
margin: 0 auto;
	} .header h3 {
line-height: 1;
width: 280px;
float: right;
margin-top: 0px;
text-align: center;
color:#309;
	}
	.header img {
		width: auto;
height: 60px;
float: left;
	}
</style>
</head>

<body>
	<div class='content'>
	<div class='header'>
	<img src='images/police.gif' />
	<h3>Traffic Police Crash Data System</h3>
</div>

<div id="signup_bar">
         <form id ="loginForm" action="verify.php" method="post" >
          <table id="signup_table">
              <tr>
                  <td colspan="3" align="center" id="log"><div id="signup_text">Login</div></td>
              </tr>
              
                  <td id="log">Username<span id="star">*</span> </td
                  ><td id="log">:</td>
                  <td id="log"><input type="text" name="job_number" id="job_number" size="45" class="signup_table_input" /></td>
              </tr>
                            
              <tr>
                  <td id="log">Password<span id="star">*</span> </td>
                  <td id="log">:</td>
                  <td id="log"><input type="password" name="password" size="45" id="password" class="signup_table_input" /></td>
              </tr>
              
              <tr>
                  <td id="log"></td>
                  <td id="log"></td>
                  <td id="log"><span id="password_mis"></span><span id="password_match"></span></td>
              </tr>
              <tr>
                  <td colspan="3" align="center" id="log"><input type="submit" value="Submit >>" class="signup_table_input" /></td>
              </tr>
              <tr>
                  <td colspan="3" id="log">Note: <span id="star">*</span> must be filled</td>
              </tr>
			  
			  
              <tr>
                  <td id="log"><input type="hidden" name="tag" value="login" />
                       <?php 
							if (isset($_GET['redirect'])) {
								$redirect = $_GET['redirect'];
							} else {
								$redirect = "index.php";
							}
							?></td>
                   <td id="log">
                      <input type="hidden" name="redirect"
               	            value="<?php echo $redirect; ?>"></td>
                            <td id="log"></td>
              </tr>
              
          </table>
          </form>
      </div>
</div>
</body>
</html>