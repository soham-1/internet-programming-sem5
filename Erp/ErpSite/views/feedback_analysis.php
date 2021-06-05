<?php 
    require 'welcome.php';
    require 'includeCDN.php';
    require '../models/connDB.php';
    $dataPoints = array();
    $feedbacks = $conn->query("select * from feedback");
    $message_array = array();
    $positive = 0;
    $negative = 0;
    $negative_array = ["bad", "worst", "ridiculous"];
    $positive_array = ["good", "better", "best", "excellent", "nice"];
    while ($row = $feedbacks->fetch_assoc()) { // gets all feedback into an array
        array_push($message_array, $row['message']);
    }
    // for each message, checks if any positive word is present in sentence.
    foreach ($message_array as $message) {
        foreach ($positive_array as $positive_word) {
            if (strpos($message, $positive_word)!==false) {
                $positive++;
                break;
            }
        }
    }
    foreach ($message_array as $message) {
        foreach ($negative_array as $negative_word) {
            if (strpos($message, $negative_word)!==false) {
                $negative++;
                break;
            }
        }
    }
    // total count of positive or negative statements
    array_push($dataPoints, array("y"=> $positive, "label" => "positive"));
    array_push($dataPoints, array("y"=> $negative, "label" => "negative"));
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/contact_us.css">
    <link rel="stylesheet" href="css/common.css">
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
		text: 'feedbacks'
	},
	data: [{
		type: 'bar', //change type to bar, line, area, pie, etc  
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>

<body>
    <div class="outer-container">
        <div class="container col-lg-10 col-md-10 col-sm-10">
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        </div>
    </div>
</body>
</html>