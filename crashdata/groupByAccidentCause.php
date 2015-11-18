<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Group by accident cause</title>
</head>

<body bgcolor="#CCCCCC">

	<TABLE CELLPADDING=6 FRAME=BOX  width="50%" align="center">
<THEAD align="center">
<TR  width="50%"> <TH colspan="9">Accident distribution by cause</TH></TR>
<TR  width="50%"> <TH colspan="1">Year</TH> <TH colspan="8">Accident Cause</TH></TR>
</THEAD>

<THEAD align="center">
<TR  width="50%"> <TH></TH> <TH>Drivers and M/Cycles</TH> <TH>Pedal cyclists</TH> <TH> Pedestrians</TH> <TH>Obstruction</TH>   <TH>Vehicle defects</TH> <TH>Road defects</TH> <TH>Weather</TH> <TH>Other causes</TH></TR>
</THEAD>

<TBODY align="center">


	<?php
	
		include('DB_connect.php');
	
		$startYear = 2012;
		$endYear = 2014;
		
		//$startYear = $_REQUEST['from'];//year to start with 
	//$endYear = $_REQUEST['to'];//year to end with
	$base = $startYear;
	
	$commaSepStr = "";
	$size= 0;
	
	do{
	
		$commaSepStr.= $base . ",";
		$base=$base+1;
		$size= $size+1;
	
	}while($base<=$endYear);
	//echo $size;
	$arrayOfYears = explode(",",$commaSepStr);
	
	
	/*"1 Drivers and M/Cycles","2 Pedal cyclists", "3 Pedestrians", "4 Obstruction",
            "5 Vehicle defects", "6 Road defects", "7 Weather", "8 Other causes"*/
			
		$i=0;//this a counter like counter = 0;
		
		do{
		
			$driver_cycles = getCause1(arrayOfYears[$i]);
			$pedal_cycles = getCause2(arrayOfYears[$i]);
			$pedestrians = getCause3(arrayOfYears[$i]);
			$obstruction = getCause4(arrayOfYears[$i]);
			$vehicle_defects = getCause5(arrayOfYears[$i]);
			$road_defects = getCause6(arrayOfYears[$i]);
			$weather = getCause7(arrayOfYears[$i]);
			$other_causes = getCause8(arrayOfYears[$i]);
			
				echo "<TR> <TD>2012</TD> <TD> 23</TD> <TD>17</TD> <TD>67</TD>  <TD>27</TD> <TD>19</TD> <TD>49</TD> <TD>8</TD> <TD>4</TD> </TR>";
			$i=0
		}while($i=0<$size);
		
		
		
		function getCause8($year){
			
			$query = "select crash_id, COUNT(crash_id) as value_ FROM accident WHERE date LIKE '%$year' AND cause_code='8 Other causes'";
			
			$result = mysql_query($query)or die("Query failed:" . mysql_error());
			
			$row = mysql_fetch_assoc($result);
				
			$value = $row['value_'];
			
			return $value;
		
		}	
		
		function getCause7($year){
			
			$query = "select crash_id, COUNT(crash_id) as value_ FROM accident WHERE date LIKE '%$year' AND cause_code='7 Weather'";
			
			$result = mysql_query($query)or die("Query failed:" . mysql_error());
			
			$row = mysql_fetch_assoc($result);
				
			$value = $row['value_'];
			
			return $value;
		
		}	
		function getCause6($year){
			
			$query = "select crash_id, COUNT(crash_id) as value_ FROM accident WHERE date LIKE '%$year' AND cause_code='6 Road defects'";
			
			$result = mysql_query($query)or die("Query failed:" . mysql_error());
			
			$row = mysql_fetch_assoc($result);
				
			$value = $row['value_'];
			
			return $value;
		
		}	
		
		function getCause5($year){
			
			$query = "select crash_id, COUNT(crash_id) as value_ FROM accident WHERE date LIKE '%$year' AND cause_code='5 Vehicle defects'";
			
			$result = mysql_query($query)or die("Query failed:" . mysql_error());
			
			$row = mysql_fetch_assoc($result);
				
			$value = $row['value_'];
			
			return $value;
		
		}	
		
		function getCause4($year){
			
			$query = "select crash_id, COUNT(crash_id) as value_ FROM accident WHERE date LIKE '%$year' AND cause_code='4 Obstruction'";
			
			$result = mysql_query($query)or die("Query failed:" . mysql_error());
			
			$row = mysql_fetch_assoc($result);
				
			$value = $row['value_'];
			
			return $value;
		
		}	
		
		function getCause3($year){
			
			$query = "select crash_id, COUNT(crash_id) as value_ FROM accident WHERE date LIKE '%$year' AND cause_code='3 Pedestrians'";
			
			$result = mysql_query($query)or die("Query failed:" . mysql_error());
			
			$row = mysql_fetch_assoc($result);
				
			$value = $row['value_'];
			
			return $value;
		
		}	
		
		
		function getCause2($year){
			
			$query = "select crash_id, COUNT(crash_id) as value_ FROM accident WHERE date LIKE '%$year' AND cause_code='2 Pedal cyclists'";
			
			$result = mysql_query($query)or die("Query failed:" . mysql_error());
			
			$row = mysql_fetch_assoc($result);
				
			$value = $row['value_'];
			
			return $value;
		
		}		
			
		function getCause1($year){
			
			$query = "select crash_id, COUNT(crash_id) as value_ FROM accident WHERE date LIKE '%$year' AND cause_code='1 Drivers and M/Cycles'";
			
			$result = mysql_query($query)or die("Query failed:" . mysql_error());
			
			$row = mysql_fetch_assoc($result);
				
			$value = $row['value_'];
			
			return $value;
		
		}	
	
	?>
	<TR> <TD>2012</TD> <TD> 23</TD> <TD>17</TD> <TD>67</TD>  <TD>27</TD> <TD>19</TD> <TD>49</TD> <TD>8</TD> <TD>4</TD> </TR>





</TBODY>


</TABLE>
	

</body>
</html>
