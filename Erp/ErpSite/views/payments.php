<?php
    require 'welcome.php';
    require 'includeCDN.php';
    require '../models/connDB.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/shop_list.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
</head>
<?php
    if ($_GET['user']=="shop") {
        $shop_id = $conn->query("select shop_id from shop where shop_owner={$_SESSION['user_id']}")->fetch_row()[0];
        $payments = $conn->query("select * from payments where shop_id={$shop_id}");
    } else if ($_GET['user']=="customer") {
        $payments = $conn->query("select * from payments where cust_id={$_SESSION['user_id']}");
    }
?>
<body>
<div class="outer-container">

    <div class="container col-lg-10 col-md-12 col-sm-12">
    <table id="table_id" class="display">
        <thead>
            <tr>
            <?php
                if ($_GET['user']=="shop") {
                    echo '<th>customer</th>';
                } else if ($_GET['user']=="customer") {
                    echo '<th>shop</th>';
                }
                
            ?>
                <th>date</th>
                <th>product</th>
                <th>qty</th>
                <th>amount</th>
                <th>balance</th>
                <th>method</th>
            <?php
            if ($_GET['user']=="shop") {
                echo '<th>notes</th>';
            }
                
            ?>
                <!-- <th>notes</th> -->
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $payments->fetch_assoc()) {
                if ($_GET['user']=="shop")
                    $name = $conn->query("select username from user where user_id={$row['cust_id']}")->fetch_row()[0];
                else
                    $name = $conn->query("select shop_name from shop where shop_id={$row['shop_id']}")->fetch_row()[0];
                $details = $conn->query("select * from payment_details where payment_id={$row['payment_id']}");
                while ($row1 = $details->fetch_assoc()) {
                    $prod_name = $conn->query("select * from products where product_id={$row1['prod_id']}")->fetch_row()[1];
                    $price = $conn->query("select price from inventory where shop_id={$row['shop_id']} and prod_id={$row1['prod_id']}")->fetch_row();
                    $total_price = $price[0] * $row1['qty'];
                    echo '<tr>
                        <td>' . $name .'</td>
                        <td>' . $row['pay_date'] .'</td>
                        <td>' . $prod_name .'</td>
                        <td>' . $row1['qty'] .'</td>
                        <td>' . $total_price .'</td>
                        <td>' . $row['balance'] .'</td>
                        <td>' . $row['payment_method'] .'</td>';
                        if ($_GET['user']=="shop") echo '<td>' . $row['notes'] .'</td>';
                        '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
    </div>

</div>
</body>
<script>
    $(document).ready( function () {
        $('#table_id').DataTable();
    } );
</script>
</html>