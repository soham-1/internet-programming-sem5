<!DOCTYPE html>
<html lang="en">

<?php 
    require 'includeCDN.php';
    require 'welcome.php';
    require '../models/connDB.php';
?>

<head>    
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/inventory.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
</head>

<?php
$shop_id = $conn->query("select shop_id from shop where shop_owner='{$_SESSION['user_id']}' ")->fetch_row();
$products = $conn->query("select * from inventory where shop_id='{$shop_id[0]}' ");
?>

<body>
<div class="outer-container">

    <div class="container col-lg-10 col-md-10 col-sm-12">
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>product</th>
                <th>description</th>
                <th>category</th>
                <th>qty</th>
                <th>discount</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($products->num_rows > 0) {
                while ($row=$products->fetch_assoc()) {
                    $product_id = $row['prod_id'];
                    $product_name = $conn->query("select name, category from products where product_id='{$product_id}' limit 1")->fetch_row();
                    echo '<tr>
                            <td>'. $product_name[0] .'</td>
                            <td>'. $row['description'] .'</td>
                            <td>'. $product_name[1] .'</td>
                            <td>'. $row['qty'] .'</td>
                            <td>'. $row['discount'] .'</td>
                        </tr>';
                }
            } else {
                echo '<tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                      </tr>';
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