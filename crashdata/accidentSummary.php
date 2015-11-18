<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Yearly Accident Summery</title>
</head>

<body bgcolor="#CCCCCC">
<TABLE CELLPADDING=6 FRAME=BOX  width="50%" align="center">
<THEAD align="center">
<TR  width="50%"> <TH></TH> <TH></TH> <TH>Yearly summery</TH> <TH></TH> <TH></TH></TR>
</THEAD>

<THEAD align="center">
<TR  width="50%"> <TH>Year</TH> <TH>Number of Accidents</TH> <TH>Number of Deaths</TH> <TH>Serious injuries</TH> <TH>Minor injuries</TH></TR>
</THEAD>

<TBODY align="center">

<?php
	include('DB_connect.php');
	
	$startYear = 2011;
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
	
	$i = 0; //this the array Of Years Index
	
	do{
	
		$yearLabel = $arrayOfYears[$i];
		$accidentCount = getNumberOfAccidents($arrayOfYears[$i]);
		$deaths = getNumberOfDeaths ($arrayOfYears[$i]);
		$seriousInj = getNumberOfSeriousInjuries ($arrayOfYears[$i]);
		$monorInj = getNumberOfSlightInjuries ($arrayOfYears[$i]);
		
		echo "<TR> <TD>" . $yearLabel . "</TD> <TD>" . $accidentCount . "</TD> <TD>" . $deaths . "</TD> <TD>" . $seriousInj . "</TD>  <TD>" . $monorInj . "</TD></TR>";
	
		$i++;
		
	}while ($i<$size);
	
	
	
	
	//Functions
	function getNumberOfSlightInjuries ($year){
	
		$query = "select crash_id, SUM(minor_injuries) as value_ FROM crash_vehicle WHERE _date LIKE '%$year'";
			
		$result = mysql_query($query)or die("Query failed:" . mysql_error());
			
		$row = mysql_fetch_assoc($result);
				
		$value = $row['value_'];
			
		return $value;
	
	
	}
	
	
	function getNumberOfSeriousInjuries ($year){
	
		$query = "select crash_id, SUM(serious_injuries) as value_ FROM crash_vehicle WHERE _date LIKE '%$year'";
			
		$result = mysql_query($query)or die("Query failed:" . mysql_error());
			
		$row = mysql_fetch_assoc($result);
				
		$value = $row['value_'];
			
		return $value;
	
	
	}
	
	
	function getNumberOfDeaths ($year){
	
		$query = "select crash_id, SUM(deaths) as value_ FROM crash_vehicle WHERE _date LIKE '%$year'";
			
		$result = mysql_query($query)or die("Query failed:" . mysql_error());
			
		$row = mysql_fetch_assoc($result);
				
		$value = $row['value_'];
			
		return $value;
	
	
	}
	
	
	function getNumberOfAccidents($year){
		$query = "select crash_id, COUNT(DISTINCT crash_id) as value_ FROM crash_vehicle WHERE _date LIKE '%$year'";
			
			$result = mysql_query($query)or die("Query failed:" . mysql_error());
			
			$row = mysql_fetch_assoc($result);
				
			$value = $row['value_'];
			
			return $value;
	
	}

?>

</TBODY>


</TABLE>
</body>
</html>
