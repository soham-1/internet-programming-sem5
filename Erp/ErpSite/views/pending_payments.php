<!DOCTYPE html>
<html lang="en">

<?php
    require 'includeCDN.php';
    require 'welcome.php';
    require '../models/connDB.php';
?>

<head>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/shop_list.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
</head>
<?php
    if (isset($_POST['payment_id'])) {
        $conn->query("update payments set balance=0 where payment_id={$_POST['payment_id']}");
    }
    if ($_GET['user']=="shop") {
        $shop_id = $conn->query("select shop_id from shop where shop_owner={$_SESSION['user_id']}")->fetch_row()[0];
        $pending = $conn->query("select * from payments where shop_id={$shop_id} and balance>0 ");
    } else if ($_GET['user']=="customer") {
        $pending = $conn->query("select * from payments where cust_id={$_SESSION['user_id']} and balance>0 ");
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
                <th>total amount</th>
                <th>balance left</th>
                <?php
                    if ($_GET['user']=="shop") {
                        echo '<th>Action</th>';
                    }
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $pending->fetch_assoc()) {
                if ($_GET['user']=="shop")
                    $name = $conn->query("select username from user where user_id={$row['cust_id']}")->fetch_row()[0];
                else
                    $name = $conn->query("select shop_name from shop where shop_id={$row['shop_id']}")->fetch_row()[0];
                echo '<tr> <form method="post">
                <td>' . $name .' <input type="hidden" name="payment_id" value="'. $row['payment_id'] .'"></td>
                <td>' . $row['pay_date'] .'</td>
                <td>' . $row['amount'] .'</td>
                <td>' . $row['balance'] .'</td>';
                if ($_GET['user']=="shop") {
                    echo '<td><button type="submit" class="bsbtn btn-outline-pink">Clear payment</button>
                            <button class="bsbtn btn-primary">send reminder</button></td>';
                }
                echo '</form></tr>';
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