<?php
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

$SQL = $odb -> prepare("SELECT attacklogs.date FROM attacklogs WHERE date >= :fistdate ORDER BY attacklogs.date DESC");
$SQL -> execute(array(':fistdate' => $value1));
while ($row = $SQL->fetch()) {

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

$numbers_data= "".$seven.", ".$six.", ".$five.", ".$four.", ".$three.", ".$two.", ".$one."";



$SQLGetMethods = $odb -> prepare("SELECT * FROM `methods` where `group` ='layer4'");
$SQLGetMethods -> execute();
$i = 0;
$numbers_data_methods = array();
$methods_label_array = array();
while ($methods = $SQLGetMethods -> fetch(PDO::FETCH_ASSOC)) {
    if ($i!=0) {
        $numbers_methods .= ',';
    }
    $avg_per_value = $stats->totalBootsForAllMethod($odb, $methods['method']);

    $numbers_data_methods[$i] .= $avg_per_value;
    $numbers_methods .= "'".$avg_per_value."'";

    $methods_label_array[$i] .= $methods['method'];
    $total_methods += $avg_per_value;
    $i++;
}
$i=0;
foreach ($numbers_data_methods as $n_m){
  if ($i!=0) {

      $methods_label .= ',';
  }
  //$numbers_methods .=  round(($n_m*100)/$total_methods,2);

  $methods_label .= "'".$methods_label_array[$i] ." ".round(($n_m*100)/$total_methods,2)."%'";
  $i++;
}

?>                      


<script>

$(function(){

  var ctx1 = document.getElementById('AttackChart').getContext('2d');

  var myChart1 = new Chart(ctx1, {

    responsive: true,

    type: 'bar',

    data: {

      labels: [<?php echo $days; ?>],

      datasets: [{

        label: '# of Attacks',

        data: [<?php echo $numbers_data; ?>],

        backgroundColor: '#5B93D3'

      }]

    },

    options: {

      legend: {

        display: false,

          labels: {

            display: false

          }

      },

      scales: {

        yAxes: [{

          ticks: {

            beginAtZero:true,

            fontSize: 10,

            max: <?php echo max($one, $two, $three, $four, $five, $six, $seven); ?>,

            stepSize: 10

          }

        }],

        xAxes: [{

          ticks: {

            beginAtZero:true,

            fontSize: 15

          }

        }]

      }

    }

  });


  });

  
  



</script>

<script>

$(function(){


  var myChart2 = new Chart('AllMethodsChart', {

    responsive: true,

    type: 'doughnut',

    data: {

      labels: [<?php echo $methods_label; ?>],

      datasets: [{

        label: 'Usage',

        backgroundColor: ["#3383FF", "#2D73DF","#2863BF","#1F52A1","#194281","#16376A","#0365FC","#055BDF","#0651C4","#0545A7","#0643A1","#043785","#032B68","#021E4A"],

        data: [<?php echo $numbers_methods; ?>]

      }]

    },

    options: {

      legend: {   
        position: 'bottom', 
        align: 'start', 

          labels: {
            usePointStyle: true
          }
      },
      layout: {
            padding: {
                left: 10,             
                top: 0,
               
            }
        }

    }

  });


  });

  



</script>