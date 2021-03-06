<?php
    require 'welcome.php';
    require 'includeCDN.php';
    require '../models/connDB.php';
    if (isset($_GET['type'])) {
        $dataPoints = array();
        $shop_id = $conn->query("select shop_id from shop where shop_owner='{$_SESSION['user_id']}' limit 1")->fetch_row()[0];
        if ($_GET['type']=='sale') {
            if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                $result = $conn->query("SELECT amount, pay_date FROM payments where shop_id='{$shop_id}' and pay_date>='{$_GET['start_date']}' and pay_date<='{$_GET['end_date']}' ORDER BY pay_date");
            } else {
                $result = $conn->query("SELECT SUM(amount) as amount, pay_date FROM payments where shop_id='{$shop_id}' GROUP BY pay_date ORDER BY pay_date");
            }
            while($row=$result->fetch_assoc()) {
                array_push($dataPoints, array("y"=> $row["amount"], "label" => $row["pay_date"]));
            }
        } else if ($_GET['type']=='category') {
            // gets the category and price of sold items for a particular shops
            $sql = "select i.price, p.category, pd.qty from payments py inner join payment_details pd on py.payment_id=pd.payment_id inner join products p on pd.prod_id=p.product_id inner join inventory i on p.product_id=i.prod_id where py.shop_id='{$shop_id}'";
            if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                $sql .= " and py.pay_date>='{$_GET['start_date']}' and pay_date<='{$_GET['end_date']}' order by p.category";
                $result = $conn->query($sql);
            } else {
                $sql .= "order by p.category";
                $result = $conn->query($sql);
            }
            $i=0; $cat_price=0;
            $row = $result->fetch_assoc();
            $prev_category = $row['category'];
            while ($i<$result->num_rows) {
                if ($prev_category == $row['category']) {
                    $cat_price += ((int)$row["price"] * (int)$row['qty']);
                } else {
                    array_push($dataPoints, array("y"=>($cat_price), "label" => $prev_category));
                    $cat_price=0;
                    $prev_category = $row['category'];
                    continue;
                }
                $row = $result->fetch_assoc();
                if ($row == null) {
                    array_push($dataPoints, array("y"=>($cat_price), "label" => $prev_category));
                    break;
                }
                $row["price"];
                $i++;
            }
        }
    }
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
    // get url parameter "type"
const queryString = window.location.search;
console.log(queryString);
const urlParams = new URLSearchParams(queryString);
const type = urlParams.get('type');
let diagram, title;
if (type=="sale") {
    diagram="line";
    title = "sales graph";
} else if (type=="category") {
    diagram="pie";
    title = "category distribution";
}
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: title
	},
	data: [{
		type: diagram, //change type to bar, line, area, pie, etc
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
            <form action="#" method="get">
                <?php echo '<input type="hidden" name="type" value="' . $_GET['type'] .'">'; ?>
                <input type="date" name="start_date" id="start_date">
                <input type="date" name="end_date" id="end_date">
                <button type="submit">go</button>
            </form>
        </div>
    </div>
</body>
</html>