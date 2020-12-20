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
    $products = $conn->query("select * from products where category='{$_GET['category']}' ")->fetch_all();
    $qty_array = array();
    for ($i=0; $i<count($products); $i++) {
        $count = 0;
        $count += $conn->query("select count(shop_id) from inventory where prod_id='{$products[$i][0]}'")->fetch_row()[0];
        array_push($qty_array, $count);
    }

?>
<body>
<div class="outer-container">

    <div class="container col-lg-10 col-md-10 col-sm-12">
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>name</th>
                <th>image</th>
                <th>available qty</th>
            </tr>
        </thead>
        <tbody>
        <?php
            for ($i=0; $i< count($products); $i++) {
                echo '<tr>
                        <td>'. $products[$i][1] .'</td>
                        <td> <a href="shop_list.php?product_id='. $products[$i][0] .'">
                        <img src="data:image/png;charset=utf8;base64,' . base64_encode($products[$i][3]) . '" alt="image not available" style="width:50%">
                        </a>
                        </td>
                        <td>'. $qty_array[$i] .'</td>
                        
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