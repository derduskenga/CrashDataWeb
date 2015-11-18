<?php

	# PHPlot Example: Bar chart, 3 data sets, unshaded
	require_once 'phplot.php';
	include('DB_connect.php');
	
	/*"Matatus","Cars and utilities", "Lorries", "Trailers", "Petroleum tankers",
            "Other tankers", "Passenger","Tractors", "Urban buses", "Country buses",
            "School/College buses", "Other Institutional buses", "Tourist vans", "Taxis",
            "Motor cycles", "Motor tricycles/Tuktuks", "Invalid carriages", "Hand carts","Animals drawn carts", "Pedal cycles", 
            "Animals", "Not known"*/
			
			
			$vehicleTypeArray = array("Matatus",
							"Cars and utilities",
							"Passenger",
							"Urban buses",
							"Country buses",
							"Taxis",
							"School/College buses",
							"Invalid carriages",
							"Trailers",
							"Petroleum tankers");
							
			
			
			countByVehicleType($vehicleTypeArray,10);
							
			$data = array(
						array('Matatus',countByVehicleType($vehicleTypeArray,10)[0]),
						array('Cars/utilities',countByVehicleType($vehicleTypeArray,10)[1]),
						array('Passenger',countByVehicleType($vehicleTypeArray,10)[2]),
						array('Urban buses',countByVehicleType($vehicleTypeArray,10)[3]),
						array('Country buses',countByVehicleType($vehicleTypeArray,10)[4]),
						array('Taxis',countByVehicleType($vehicleTypeArray,10)[5]),
						array('Instution buses',countByVehicleType($vehicleTypeArray,10)[6]),
						array('Invalid carriages',countByVehicleType($vehicleTypeArray,10)[7]),
						array('Trailers',countByVehicleType($vehicleTypeArray,10)[9]),
						array('Petroleum tankers',countByVehicleType($vehicleTypeArray,10)[9]),
);






		$plot = new PHPlot(800, 600);
	$plot->SetImageBorderType('plain');
	$plot->SetPlotType('bars');
	$plot->SetDataType('text-data');
	
	$plot->SetDataValues($data);
	# Main plot title:
	$plot->SetTitle('Distribution of Accident by Vehicle Type');
	# No 3-D shading of the bars:
	$plot->SetShading(4);
	$plot->SetYTitle('Number of accidents');
	$plot->SetXTitle('Vehicle type');
	
	//$plot->SetLegendWorld(0.1, 95);
	# Turn off X tick labels and ticks because they don't apply here:
	$plot->SetXTickLabelPos('none');
	$plot->SetXTickPos('none');
	$plot->DrawGraph();
		
			
		function countByVehicleType ($type,$size){
		
		$k=0;
		$value = "";
		
		do{
			$query = "select vehicle_type, COUNT(sys_id) as value_ FROM crash_vehicle WHERE vehicle_type='$type[$k]'";
			
			$result = mysql_query($query)or die("Query failed:" . mysql_error());
			
			$row = mysql_fetch_assoc($result);
				
			$value .= $row['value_']. ",";
			
			$k++;
		}while($k<$size);
			
			
			return explode(",",$value);
		
		}


?>