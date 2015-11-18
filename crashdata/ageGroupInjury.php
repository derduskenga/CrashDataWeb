<?php
	# PHPlot Example: Bar chart, 3 data sets, unshaded
	require_once 'phplot.php';
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
	
	
	
	//get years in an array by exploding.
	//an array of years of size $size
	
	$arrayOfYears = explode(",",$commaSepStr);

	//make an array of regions of size 8
	
	$arrayOfAgeBracket = array("0-5 years",
							"6-10 years",
							"11-16 years",
							"17-25 years",
							"26-35 years",
							"36-45 years",
							"46-55 years",
							"56-65 years",
							"over 65 years");
	
	//echo fetch("2014","Central");
	
	
	//Loop year, then loop regions inside the year
	
	$graphInput="";
	$finalGrapthInput = "";
	$j=0;

	
	
	$data = array();
	
	for($i=0;$i<$size;$i++){
	
		 // fetch($arrayOfYears[$i],$arrayOfRegions,8);
		
		array_push($data, fetch($arrayOfYears[$i],$arrayOfAgeBracket,9));
	}
		
	$data;
	
	
	function fetch($year,$arrayOfAgeBracket,$size){
	
	$k=0;
	$value = "";
	
	do{
	
		$query = "SELECT status,age_group,_date,COUNT(sys_casuality_id) as value_ FROM casuality where _date LIKE '%$year' and age_group='$arrayOfAgeBracket[$k]'";
		
			$result = mysql_query($query)or die("Query failed:" . mysql_error());
			$row = mysql_fetch_assoc($result);
				
			$value .= $row['value_']  . ",";
			$k++;
			
		}while ($k<$size);
			
			return explode(",","'" . $year . "'" .  "," . $value);
	}
	
	
	
	$plot = new PHPlot(800, 600);
	$plot->SetImageBorderType('plain');
	$plot->SetPlotType('bars');
	$plot->SetDataType('text-data');
	
	$plot->SetDataValues($data);
	# Main plot title:
	$plot->SetTitle('Number of Deaths/Serious injuries per age group');
	# No 3-D shading of the bars:
	$plot->SetShading(4);
	$plot->SetYTitle('Number of Deaths/Serious injuries');
	$plot->SetXTitle('Years');
	# Make a legend for the 3 data sets plotted:
	$plot->SetLegend(array("0-5 years",
							"6-10 years",
							"11-16 years",
							"17-25 years",
							"26-35 years",
							"36-45 years",
							"46-55 years",
							"56-65 years",
							"over 65 years"));
	//$plot->SetLegendWorld(0.1, 95);
	# Turn off X tick labels and ticks because they don't apply here:
	$plot->SetXTickLabelPos('none');
	$plot->SetXTickPos('none');
	$plot->DrawGraph();

?>