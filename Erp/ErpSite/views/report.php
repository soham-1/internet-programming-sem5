<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php 
    require 'includeCDN.php';
    require 'welcome.php';
    require '../models/connDB.php';
    if (isset($_GET['shop_id'])) {
        $result = $conn->query("select shop_id, prod_id from inventory")->fetch_all();
        $result = $conn->query("SELECT * FROM payments where shop_id='{$_GET['shop_id']}' ORDER BY time");
        // $dataPoints = array();
        // foreach($result as $row){
        //         array_push($dataPoints, array("x"=> $row[0], "y"=> $row[1]));
        //     }
        //     $dataPoints[4]['x'] = 2;
            $dataPoints = array(
                array("y" => 25, "label" => "Sunday"),
                array("y" => 15, "label" => "Monday"),
                array("y" => 25, "label" => "Tuesday"),
                array("y" => 5, "label" => "Wednesday"),
                array("y" => 10, "label" => "Friday"),
                array("y" => 0, "label" => "Thursday"),
                array("y" => 20, "label" => "Saturday")
            );
    }
?>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/contact_us.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
</head>
<script>
window.onload = function () {
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "PHP Column Chart from Database"
	},
	data: [{
		type: "line", //change type to bar, line, area, pie, etc  
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
<?php
$var = "test";
    // if (count($_POST)>0) {
    //     $conn->query("insert into feedback(user_id, first_name, last_name, recovery_email, ratings, message) values('{$_SESSION['user_id']}','{$_POST['first_name']}','{$_POST['last_name']}','{$_POST['email']}','{$_POST['rating']}','{$_POST['message']}') ");
    //     echo '<script>alert("thanks for the feedback")</script>';
    // }
?>

<body>
    <div class="outer-container">
        <div class="container col-lg-10 col-md-10 col-sm-12">
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        </div>
    </div>
</body>
</html>