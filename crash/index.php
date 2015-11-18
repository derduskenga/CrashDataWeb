<?php
session_start();
	if ((isset($_SESSION['user_logged']) &&
	$_SESSION['user_logged'] != "") ||
		(isset($_SESSION['user_password']) &&
		$_SESSION['user_password'] != "")) {
		include "home.php";
	} else {
	 include "login.php";
}
?>