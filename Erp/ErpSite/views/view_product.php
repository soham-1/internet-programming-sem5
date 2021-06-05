<?php
    require 'welcome.php';
    require 'includeCDN.php';
    require '../models/connDB.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/datatable.css">
    <link rel="stylesheet" href="css/inventory.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
</head>
<style>
    .table{
        margin:10px;
        border:1px;
    }
    </style>
<?php

$shop_id = $conn->query("select shop_id from shop where shop_owner='{$_SESSION['user_id']}' ")->fetch_row();
$products = $conn->query("select * from products ");
?>

<body>
<div class="outer-container">

    <div class="container col-lg-12 col-md-12 col-sm-12">
    <div class="table-responsive mb-4">
        <table class="table table-striped table-bordered table-hover" id="prod_list">
        <thead>
            <tr class="thead">
                <th scope="col" class="table-header">Name</td>
                <th scope="col" class="table-header">category</td>
                <th scope="col" class="table-header">Price</td>
                <th scope="col" class="table-header">description</td>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($products->num_rows > 0) {
                while ($row=$products->fetch_assoc()) {
                    echo '<tr>
                            <td>'. $row['name'] .'</td>
                            <td>'. $row['category'] .'</td>

                            <td>'. $row['price'] .'</td>
                            <td>'. $row['Description'] .'</td>
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

</div>
</body>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script>
$(document).ready(function() {
    $('#prod_list').DataTable( {

    } );
} );
</script>
</html>