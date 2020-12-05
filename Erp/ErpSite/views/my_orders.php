<!DOCTYPE html>
<html lang="en">

<?php
    require 'includeCDN.php';
    require 'welcome.php';
    require '../models/connDB.php';

$cust_id = $_SESSION['user_id'];

$cart_items = $conn->query("select * from payments where cust_id='{$cust_id}'  ");
$pay_details = array();
$payment = array();

while ($row=$cart_items->fetch_assoc()) {
$sql3 = "select * from payment_details where payment_id='{$row['payment_id']}'";
array_push($pay_details,$conn->query($sql3)->fetch_row());
array_push($payment,$row);


}


$shop_id = $row['shop_id'];

$sql5 = "SELECT * from shop WHERE shop_id='{$shop_id}'";
$result5 = mysqli_query($conn, $sql5);
$id3 = mysqli_fetch_assoc($result5);
$sql6 = "SELECT * from address WHERE user_id='{$id3['shop_owner']}'";
$result6 = mysqli_query($conn, $sql6);
$address = mysqli_fetch_assoc($result6);
?>

<head>
<style type="text/css">
      /* Set the size of the div element that contains the map */
      #map {
        width: 30%;
        /* The width is the width of the web page */
      }
    </style>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/prod_form.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
</head>
<body>
<div class=outer-container>
    <div class="container col-lg-12 col-md-12 col-sm-12">

<header>
        <span class="price" style="color:black">

        </span></header>
        <table id="table_id" class="display">
        <thead>
            <tr>
                <!-- <th>product</th> -->
                <th>Order id</th>
                <th>Shop id</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Mode</th>
                <th>Products</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // echo '<a href="shop_prod_view.php?product_id=1&shop_id=1"> '.$product_id.'</a>';
            for ($i=0; $i< count($payment); $i++) {
                // $product_id = $row['prod_id'];
                // $product_name = $conn->query("select name, category from products where product_id='{$product_id}' limit 1")->fetch_row();
                echo '<tr>
                <td>' . $payment[$i]['payment_id'] .'</td>
                <td>' . $payment[$i]['shop_id'] .'</td>
                <td>' . $payment[$i]['pay_date'] .'</td>
                <td>' . $payment[$i]['amount'] .'</td>
                <td>'. $payment[$i]['payment_method'] .'</td>
                <td>11</td>
                </tr>';
            }
            ?>
        </tbody>
    </table>
<?php
?>


        </div>
    </div>
</body>
<script>
    $(document).ready( function () {
        $('#table_id').DataTable();
    } );
</script>

</html>