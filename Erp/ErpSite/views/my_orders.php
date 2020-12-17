<!DOCTYPE html>
<html lang="en">

<?php
    require 'includeCDN.php';
    require 'welcome.php';
    require '../models/connDB.php';

$cust_id = $_SESSION['user_id'];

$cart_items = $conn->query("select * from payments where cust_id='{$cust_id}'  ");
$orders = $conn->query("select py.payment_id, p.name, py.pay_date, py.shop_id, py.amount, py.payment_method, s.shop_name from payments py inner join payment_details pd on py.payment_id=pd.payment_id inner join products p on pd.prod_id=p.product_id inner join shop s on s.shop_id=py.shop_id where py.cust_id='{$cust_id}'");

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
                <th>Order id</th>
                <th>Shop</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Mode</th>
                <th>Products</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row=$orders->fetch_assoc()) {
                echo '<tr>
                <td>' . $row['payment_id'] .'</td>
                <td>' . $row['shop_name'] .'</td>
                <td>' . $row['pay_date'] .'</td>
                <td>' . $row['amount'] .'</td>
                <td>'. $row['payment_method'] .'</td>
                <td>'. $row['name'] .'</td>
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