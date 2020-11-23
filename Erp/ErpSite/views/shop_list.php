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
    <script src="js/shopping.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
</head>
<?php
    $price = $conn->query("select * from inventory where prod_id='{$_GET['product_id']}' ");
    $product_id = $_GET['product_id'];
    $price_array = array();
    $shop_names = array();
    $shop_ids = array();
    while ($row = $price->fetch_assoc()) {
        array_push($shop_names,$conn->query("select * from shop where shop_id='{$row['shop_id']}'")->fetch_row());
        array_push($price_array, $row);
    }
?>
<body>
<div class="outer-container">

    <div class="container col-lg-10 col-md-10 col-sm-12">
    <table id="table_id" class="display">
        <thead>
            <tr>
                <!-- <th>product</th> -->
                <th>shop</th>
                <th>description</th>
                <th>Avail qty</th>
                <th>price</th>
                <th>discount</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // echo '<a href="shop_prod_view.php?product_id=1&shop_id=1"> '.$product_id.'</a>';
            for ($i=0; $i< count($shop_names); $i++) {
                // $product_id = $row['prod_id'];
                // $product_name = $conn->query("select name, category from products where product_id='{$product_id}' limit 1")->fetch_row();
                echo '<tr>
                        <a href="shop_prod_view.php?product_id='. $product_id . '&shop_id='. $shop_names[$i][0] .' "> <td>'. $shop_names[$i][2] .'</td></a>
                        <a href="shop_prod_view.php?product_id='. $product_id . '&shop_id='. $shop_names[$i][0] .' "><td>'. $price_array[$i]['description'] .'</td></a>
                        <a href="shop_prod_view.php?product_id='. $product_id . '&shop_id='. $shop_names[$i][0] . '"> <td>'. $price_array[$i]['qty'] .'</td> </a>
                        <a href="shop_prod_view.php?"><td>'. $price_array[$i]['price'] .'</td></a>
                        <td>'. $price_array[$i]['discount'] .'</td>
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