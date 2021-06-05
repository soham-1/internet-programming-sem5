<?php
    require 'welcome.php';
    require 'includeCDN.php';
    require '../models/connDB.php';

$cust_id = $_SESSION['user_id'];

$shop_id = $conn->query("select shop_id from shop where shop_owner='{$cust_id}'");
$id_s = mysqli_fetch_assoc($shop_id);

$items = $conn->query("select * from payments where shop_id='{$cust_id}'  ");

?>
<!DOCTYPE html>
<html lang="en">

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
                <th>Customer id</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Mode</th>
                <th>Products</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while($row=$items->fetch_assoc()) {
                echo '<tr>
                <td>' . $row['payment_id'] .'</td>
                <td>' . $row['cust_id'] .'</td>
                <td>' . $row['pay_date'] .'</td>
                <td>' . $row['amount'] .'</td>
                <td>'. $row['payment_method'] .'</td>
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