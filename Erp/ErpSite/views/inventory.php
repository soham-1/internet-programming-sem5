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
</head>
<?php

$shop_id = $conn->query("select shop_id from shop where shop_owner='{$_SESSION['user_id']}' ")->fetch_row();
$products = $conn->query("select * from inventory where shop_id='{$shop_id[0]}' ");
?>

<body>
<div class="outer-container">

    <div class="container col-lg-10 col-md-10 col-sm-12">
        <div class="filter">
            <input type="text" class="filter-input col-lg-7" id="filter-input" onkeyup="filter()" placeholder="Search for product names..">
            <select name="filter-by" id="filter-by" class=" filter-input col-lg-3" onchange=placeholder()>
                <option value="product" selected>product</option>
                <option value="category">category</option>
                <option value="qty">qty</option>
            </select>
        </div>
        <table class="table" id="inventory-list">
            <tr class="thead">
                <td scope="col" class="table-header">product</td>
                <td scope="col" class="table-header">description</td>
                <td scope="col" class="table-header">category</td>
                <td scope="col" class="table-header">qty</td>
                <td scope="col" class="table-header">discount</td>
            </tr>
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
        </table>
    </div>

</div>
</body>
<script>
    function filter() {
        let option = document.getElementById('filter-by').value;
        let input = document.getElementById('filter-input').value.toLowerCase();
        let table = document.getElementById("inventory-list");
        let tr = $("tr:not(.thead)");
        let index;
        switch (option) {
            case "category": index=2;
            break;
            case "product": index=0;
            break;
            case "qty": index=3;
            break;
        }
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[index];
            if (td) {
                txtValue = td.innerText;
                if (txtValue.toLowerCase().indexOf(input) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function placeholder() {
        let option =  document.getElementById('filter-by').value;
        switch (option) {
            case "category": {
                document.getElementById('filter-input').placeholder = "search by category";
            };
            break;
            case "product": {
                document.getElementById('filter-input').placeholder = "search for product names..";
            };
            break;
            case "qty": {
                document.getElementById('filter-input').placeholder = "search by quantity";
            };
            break;
        }
    }
</script>
</html>