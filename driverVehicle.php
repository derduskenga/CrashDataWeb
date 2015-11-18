<?php
	
	$deaths= $_POST['deaths'];
	$s_injuries= $_POST['s_injuries'];
	$m_injuries= $_POST['m_injuries'];
	$driver_name= $_POST['driver_name'];
	$d_license_no= $_POST['d_license_no'];
	$discrepancy= $_POST['discrepancy'];
	$driver_dead_yes_no = $_POST['driver_dead_yes_no'];
	$alcohol_test= $_POST['alcohol_test'];
	$driver_gender= $_POST['driver_gender'];
	$driver_s_injured_yes_no= $_POST['driver_s_injured_yes_no'];
	$insurance_expired= $_POST['insurance_expired'];
	$insurance_name= $_POST['insurance_name'];
	$registered_to= $_POST['registered_to'];
	$vehicle_model= $_POST['vehicle_model'];
	$vehicle_insurance_policy_no= $_POST['vehicle_insurance_policy_no'];
	$other_insurance= $_POST['other_insurance'];
	$vehicle_reg_number= $_POST['vehicle_reg_number'];
	$vehicle_type= $_POST['vehicle_type'];
	$loading= $_POST['loading'];
	$vehicle_defect= $_POST['vehicle_defect'];
	
	//1. when inserting to db, one vehicle cannot belong to the same accident twice, so, avoid that
	//2. one driver cannot belong to two crash vehicles
	
	
?>