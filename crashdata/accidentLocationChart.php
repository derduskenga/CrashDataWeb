<?php # PHPlot Example: Bar chart, 3 data sets, unshaded
	require_once 'phplot.php';
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
	
	
	
	//get years in an array by exploding.
	//an array of years of size $size
	
	$arrayOfYears = explode(",",$commaSepStr);

	//make an array of regions of size 8
	
	$arrayOfRegions = array("Central",
							"Coast",
							"Eastern",
							"Nairobi",
							"North Eastern",
							"Nyanza",
							"Rift Valley",
							"Western");
	
	//echo fetch("2014","Central");
	
	
	//Loop year, then loop regions inside the year
	
	$graphInput="";
	$finalGrapthInput = "";
	$j=0;
	
//	do{
//		
//		
//		for($i=0;$i<8;$i++){
//		
//			$graphInput.= fetch($arrayOfYears[$j],$arrayOfRegions[$i]) . ",";
//		}
//		
//		$graphInput = $graphInput . "'" . $arrayOfYears[$j] . "'" . "||";
//		$j = $j+1;
//		
//	}while($j<$size);
//	
//	echo $graphInput;
	
	
	
//	
//		for($i=0;$i<$size;$i++){//years
//		$j=0;
//		
//			do{
//				
//				$graphInput.= fetch($arrayOfYears[$i],$arrayOfRegions[$j]) . ",";
//				$j++;
//				
//			}while($j<8);
//			
//			$graphInput =  $graphInput. "'" . $arrayOfYears[$i] . "'" . "||";
//		}
//	
//	echo $graphInput;
	
	
	$data = array();
	
	for($i=0;$i<$size;$i++){
	
		 // fetch($arrayOfYears[$i],$arrayOfRegions,8);
		
		array_push($data, fetch($arrayOfYears[$i],$arrayOfRegions,8));
	}
		
	$data;
	
	
	function fetch($year,$arrayOfRegions,$size){
	
	$k=0;
	$value = "";
	do{
	
		$query = "SELECT _date,region,COUNT(sys_id) as value_ FROM crash_location where _date LIKE '%$year' and region='$arrayOfRegions[$k]'";
		
			$result = mysql_query($query);// or die("Query failed:" . mysql_error());
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
	$plot->SetTitle('Number of accidents per regions');
	# No 3-D shading of the bars:
	$plot->SetShading(4);
	$plot->SetYTitle('Number of accidents');
	$plot->SetXTitle('Years');
	# Make a legend for the 3 data sets plotted:
	$plot->SetLegend(array('Central', 'Coast', 'Eastern',"Nairobi","North Eastern","Nyanza","Rift Valley","Western"));
	# Turn off X tick labels and ticks because they don't apply here:
	$plot->SetXTickLabelPos('none');
	$plot->SetXTickPos('none');
	$plot->DrawGraph();

?>