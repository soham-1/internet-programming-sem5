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

    <div class="container col-lg-10 col-md-12 col-sm-12">
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>shop</th>
                <th>description</th>
                <th>Avail qty</th>
                <th>price</th>
                <th>discount</th>
            </tr>
        </thead>
        <tbody>
        <?php
            for ($i=0; $i< count($shop_names); $i++) {
                echo '<tr>
                <td><a href="shop_prod_view.php?product_id='. $product_id . '&shop_id='. $shop_names[$i][0] .' ">' . $shop_names[$i][2] .'</a></td>
                <td><a href="shop_prod_view.php?product_id='. $product_id . '&shop_id='. $shop_names[$i][0] .' ">' . $price_array[$i]['description'] .'</a></td>
                <td><a href="shop_prod_view.php?product_id='. $product_id . '&shop_id='. $shop_names[$i][0] .' ">' . $price_array[$i]['qty'] .'</a></td>
                <td><a href="shop_prod_view.php?product_id='. $product_id . '&shop_id='. $shop_names[$i][0] .' ">' . $price_array[$i]['price'] .'</a></td>
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