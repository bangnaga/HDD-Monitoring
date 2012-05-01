	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>HDD disk space checker by tr4c3r</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="http://rully.tr4c3r.dev/HDD-Monitoring/hdd_monitor/public/highcharts/js/highcharts.js" type="text/javascript"></script>
		<script src="http://rully.tr4c3r.dev/HDD-Monitoring/hdd_monitor/public/highcharts/js/modules/exporting.js"></script>

	<style type="text/css">

	body {
	 background-color: #fff;
	 margin: 40px;
	 font-family: Lucida Grande, Verdana, Sans-serif;
	 font-size: 14px;
	 color: #4F5155;
	}

	a {
	 color: #003399;
	 background-color: transparent;
	 font-weight: normal;
	}

	h1 {
	 color: #444;
	 background-color: transparent;
	 border-bottom: 1px solid #D0D0D0;
	 font-size: 16px;
	 font-weight: bold;
	 margin: 24px 0 2px 0;
	 padding: 5px 0 6px 0;
	}

	code {
	 font-family: Monaco, Verdana, Sans-serif;
	 font-size: 12px;
	 background-color: #f9f9f9;
	 border: 1px solid #D0D0D0;
	 color: #002166;
	 display: block;
	 margin: 14px 0 14px 0;
	 padding: 12px 10px 12px 10px;
	}

	</style>
	<?php 
	    function switch_month($month) {
		switch($month) {
		    case "01" : return "January";
		    case "02" : return "February";
		    case "03" : return "March";
		    case "04" : return "April";
		    case "05" : return "May";
		    case "06" : return "June";
		    case "07" : return "July";
		    case "08" : return "August";
		    case "09" : return "September";
		    case "10" : return "October";
		    case "11" : return "November";
		    case "12" : return "December";
		}
	    }

	    function total_days_month($month,$year) {
		if (($year %4) == 0) {	
		    switch($month) {
			case "01" : return "31";
			case "02" : return "29";
			case "03" : return "31";
			case "04" : return "30";
			case "05" : return "31";
			case "06" : return "30";
			case "07" : return "31";
			case "08" : return "31";
			case "09" : return "30";
			case "10" : return "31";
			case "11" : return "30";
			case "12" : return "31";
		    }
		} else {	
		    switch($month) {
			case "01" : return "31";
			case "02" : return "28";
			case "03" : return "31";
			case "04" : return "30";
			case "05" : return "31";
			case "06" : return "30";
			case "07" : return "31";
			case "08" : return "31";
			case "09" : return "30";
			case "10" : return "31";
			case "11" : return "30";
			case "12" : return "31";
		    }
		}
	    }

	    function get_data_percent($IP,$device,$month, $year) {
		    if($device == "all") { 
			$sql = mysql_query("select device from hdd_device where IP = '$IP'");
			while ($row = mysql_fetch_assoc($sql)) {
			    $devices[] = $row['device'];
			}
			foreach ($devices as $device) {
			    $sql2 = mysql_query("select percent, mount_on, device, day, month, year from hdd_status where IP = '$IP' and device = '$device' and month = '$month' and year = '$year' order by day");
			    while ($row2 = mysql_fetch_assoc($sql2)) {
				$device = $row2['device'];
				$mount_point = $row2['mount_on'];
				$day = $row2['day'];
				$month = $row2['month'];
				$year = $row2['year'];
				$percent = $row2['percent'];
				$values[] = explode(",","$day,$percent");
			    }
			    #var_dump($values);
			    $days = total_days_month($month,$year);
			    $n = "0";
			    for($i=1;$i<=$days;$i++) {
				if(($i %$values[$n][0]) == 0) {
				    $data_single[] = $values[$n][1];
				    $n++;
				} else {
				    $data_single[] = "0";
				}
			    }
			    #$data_graph[] = $data_single;
			    $data_graph[] = "{
				name: '$device ($mount_point)',
				data: [".implode(",",$data_single)."]
			     }";
			    $data_single = "";
			    $values = "";
			}
			return $data_graph;
			#var_dump($day_percent);

		    } else { 
			$sql2 = mysql_query("select percent, mount_on, device, day, month, year from hdd_status where IP = '$IP' and device = '$device' and month = '$month' and year = '$year' order by day");
			while ($row2 = mysql_fetch_assoc($sql2)) {
			    $device = $row2['device'];
			    $mount_point = $row2['mount_on'];
			    $day = $row2['day'];
			    $month = $row2['month'];
			    $year = $row2['year'];
			    $percent = $row2['percent'];
			    $values[] = explode(",","$day,$percent");
			}
			#var_dump($values);
			$days = total_days_month($month,$year);
			$n = "0";
			for($i=1;$i<=$days;$i++) {
			    if(($i %$values[$n][0]) == 0) {
				$data_single[] = $values[$n][1];
				$n++;
			    } else {
				$data_single[] = "0";
			    }
			}
			#$data_graph[] = $data_single;
			$data_graph[] = "{
			    name: '$device ($mount_point)',
			    data: [".implode(",",$data_single)."]
			}";
			$data_single = "";
			$values = "";
		    }
			return $data_graph;
		} 
	?>
	<script type="text/javascript">

	    var chart1; // globally available
		$(document).ready(function() {
		    chart1 = new Highcharts.Chart({
		    chart: {
		        renderTo: 'container',
		        type: 'line'
		     },
		     title: {
		        text: 'HDD Space Consumption Month <?php echo switch_month($month) ?>'
		     },
		     subtitle: {
		        text: 'Source : http://<?php echo $IP ?>'
		     },
		     xAxis: {
		        categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']
		     },
		     yAxis: {
		        title: {
		           text: 'Percentage Used'
		        },
			labels: {
		            formatter: function() {
		                return this.value +'%'
		            }
		        }
		     },
		     tooltip: {
		        crosshairs: true,
		        shared: true
		     },
		     plotOptions: {
		        spline: {
		            marker: {
		                radius: 4,
		                lineColor: '#666666',
		                lineWidth: 1
		            }
		        }
		     },
		     series: [
			<?php
			$data_array =  get_data_percent($IP,$device,$month, $year);
			echo implode(",",$data_array);
			?>
			]
		  });
	       });
	</script>

	</head>
	<body>

	<h1>Testing Highcharts</h1>

		<?php echo $grafik == "no" ? "no result for your query" : "<div id='container'></div>" ; ?>
	
	<div id="bottom_nav">
		<input type=button value="Back" onClick="window.history.back()">
	</div>


	</body>
	</html>
