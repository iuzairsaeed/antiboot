<?php

$conex = new mysqli("localhost","altspink_staff","Lo3?!@X#3_!#","altspink_root");
$one=0;
$two=0;
$three=0;
$four=0;
$five=0;
$six=0;
$seven=0;

$day7=date('D');
$day6=date("D",strtotime($day7."- 1 days"));
$day5=date("D",strtotime($day7."- 2 days"));
$day4=date("D",strtotime($day7."- 3 days"));
$day3=date("D",strtotime($day7."- 4 days"));
$day2=date("D",strtotime($day7."- 5 days"));
$day1=date("D",strtotime($day7."- 6 days"));
$days="'".$day1."', '".$day2."', '".$day3."', '".$day4."', '".$day5."', '".$day6."', '".$day7."'";

$value7=date('Y-m-d');
$value6=date('Y-m-d',strtotime($value7."- 1 days"));
$value5=date('Y-m-d',strtotime($value7."- 2 days"));
$value4=date('Y-m-d',strtotime($value7."- 3 days"));
$value3=date('Y-m-d',strtotime($value7."- 4 days"));
$value2=date('Y-m-d',strtotime($value7."- 5 days"));
$value1=date('Y-m-d',strtotime($value7."- 6 days"));

$sql="SELECT attacklogs.date FROM attacklogs ORDER BY attacklogs.date DESC";
$result=mysqli_query($conex, $sql);
while ($row=mysqli_fetch_assoc($result)) {

	$date=date('Y-m-d', $row['date']);
	$date2=$row['date'];

	if ($date==$value7) {

		$one++;
	} elseif ($date==$value6) {

		$two++;
	} elseif ($date==$value5) {

		$three++;
	} elseif ($date==$value4) {

		$four++;
	} elseif ($date==$value3) {

		$five++;
	} elseif ($date==$value2) {

		$six++;
	} elseif ($date==$value1) {

		$seven++;
	}
}

?>

<script type="text/javascript">
	Highcharts.chart('attackChart', {
		chart: {
			type: 'line'
		},
		title: {
			text: 'Total Attacks'
		},
		subtitle: {
			text: 'Source: nullbooter.club'
		},
		xAxis: {
			categories: [<?php echo $days; ?>]
		},
		yAxis: [{ // left y axis
			title: {
				text: 'Attacks'
			},
			labels: {
				align: 'left',
				x: 0,
				y: -3
			},
			showFirstLabel: true
		}],
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true
				},
				enableMouseTracking: false
			}
		},
		series: [{
			name: 'Attacks',
			data: [<?php echo($seven.",".$six.",".$five.",".$four.",".$three.",".$two.",".$one); ?>]
		}]
	});
	
</script>