<?php
    require 'welcome.php';
    require 'includeCDN.php';
    require '../models/connDB.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/inventory.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
</head>

<?php
$shop_id = $conn->query("select shop_id from shop where shop_owner='{$_SESSION['user_id']}' ")->fetch_row();

if (count($_POST)>0) {
    if (isset($_POST['remove'])) {
        $conn->query("delete from inventory where prod_id='{$_POST['product_id']}' and shop_id='{$shop_id[0]}' ");
    }
    if (is_numeric($_POST['qty']) && is_numeric($_POST['discount']) && $_POST['discount']>=0 && $_POST['qty']>=0){
        $conn->query("update inventory set description='{$_POST['description']}', qty='{$_POST['qty']}', discount='{$_POST['discount']}', price='{$_POST['price']}' where shop_id='{$shop_id[0]}' and prod_id='{$_POST['product_id']}' ");
    } else {
        echo '<script> alert("wrong inputs") </script>';
    }

}
$products = $conn->query("select * from inventory where shop_id='{$shop_id[0]}' ");
?>

<body>
<div class="outer-container">

    <div class="container col-lg-11 col-md-12 col-sm-12">
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Category</th>
                <th>price</th>
                <th>Qty</th>
                <th>Discount</th>
                <th>Actions</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if ($products->num_rows > 0) {
                $count = 0;
                while ($row=$products->fetch_assoc()) {
                    $product_id = $row['prod_id'];
                    $product_name = $conn->query("select name, category from products where product_id='{$product_id}' limit 1")->fetch_row();
                    echo '<tr id="'. $product_id .'">
                            <form action="inventory.php" method="post" id="'. $product_id .'form">
                            <td>'. $product_name[0] .' <br><input type="text" name="product_id" value="'. $product_id .'" style="visibility:hidden"> </td>
                            <td>'. $row['description'] .' <br> <input type="text" value="'. $row['description'] .'" name="description" id="'. $product_id .'description" style="visibility:hidden"></td>
                            <td>'. $product_name[1] .'</td>
                            <td>'. $row['price'] .' <br> <input type="text" value="'. $row['price'] .'" name="price" id="'. $product_id .'price" style="visibility:hidden"></td>
                            <td>'. $row['qty'] .' <br> <input type="text" value="'. $row['qty'] .'" name="qty" id="'. $product_id .'qty" style="visibility:hidden"></td>
                            <td>'. $row['discount'] .' <br> <input type="text" value="'. $row['discount'] .'" name="discount" id="'. $product_id .'discount" style="visibility:hidden"></td>
                            <td> <span id="'. $product_id .'" class="edit-button"><i class="fas fa-edit"></i> Edit</span> <span class="cancel-button" style="visibility:hidden" id="'. $product_id .'cancel"><i class="fas fa-times"></i> Cancel</span> <br> <button class="bsbtn btn-primary" id="'. $product_id .'save" style="visibility:hidden">save</buton></td>
                            <td><button type="submit" class="bsbtn btn-outline-pink" name="remove" value="remove">remove item</button></td>
                            </form>
                        </tr>';
                    $count += 1;
                }
            } else {
                echo '<tr>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><a href="add_inventory.php"><i class="fas fa-plus-circle"></i> Add</a></td>
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
        $('#table_id').DataTable({
            responsive: true
        });

        $('.edit-button').click(function() {
            var id = this.id;
            var desc = id + "description";
            var qty = id + "qty";
            var price = id + "price";
            var discount = id + "discount";
            var save = id + "save";
            var cancel = id + "cancel"
            document.getElementById(desc).style.visibility = "visible";
            document.getElementById(qty).style.visibility = "visible";
            document.getElementById(price).style.visibility = "visible";
            document.getElementById(discount).style.visibility = "visible";
            document.getElementById(save).style.visibility = "visible";
            document.getElementById(cancel).style.visibility = "visible";
        });
        $('.cancel-button').click(function() {
            // var id = this.id[0];
            var id = this.id.match(/\d/g);
            id = id.join("");
            var desc = id + "description";
            var qty = id + "qty";
            var price = id + "price";
            var discount = id + "discount";
            var save = id + "save";
            var cancel = id + "cancel"
            document.getElementById(desc).style.visibility = "hidden";
            document.getElementById(qty).style.visibility = "hidden";
            document.getElementById(price).style.visibility = "hidden";
            document.getElementById(discount).style.visibility = "hidden";
            document.getElementById(save).style.visibility = "hidden";
            document.getElementById(cancel).style.visibility = "hidden";
        });
        // $('.bsbtn').click(function () {
        //     var id = this.id[0];
        //     var form = id + "form";
        //     var inputs = document.getElementById(form);
        //     var values = {};
        //     for (i=0; i<inputs.length; i++) {
        //         values[inputs[i].name] = inputs[i].value;
        //     }
        //     $.ajax({
        //         type: 'get',
        //         url: 'inventory.php',
        //         data: values,
        //         success: function (response) {
        //         // alert('updated successfully !');
        //         $(form).html(response);
        //         }
        //     });
        // });
    });
</script>
</html>