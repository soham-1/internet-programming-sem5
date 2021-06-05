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
if($_GET['type']=='customer'){
    $res = $conn->query("select * from user where groups1=1");
} else if($_GET['type']=='shop') {
    $res = $conn->query("select * from user where groups1=2");
}
if (count($_POST)>0) {
    $conn->query("delete from address where user_id={$_POST['user_id']}");
    $conn->query("delete from phone_no where user_id={$_POST['user_id']}");
    $conn->query("delete from user where user_id={$_POST['user_id']}");
    if ($_GET['type']=='customer') {
        $conn->query("delete from customer where user_id={$_POST['user_id']}");
    } else if ($_GET['type']=='shop') {
        $shop_id_row = $conn->query("select shop_id from shop where shop_owner={$_POST['user_id']}")->fetch_assoc();
        if (isset($shop_id_row)) {
            $shop_id = $shop_id_row;
            $conn->query("delete from inventory where shop_id={$_POST['user_id']}");
            $conn->query("delete from shop where user_id={$_POST['user_id']}");
        }
    }
}
?>
<body>
<div class="outer-container">
    <div class="container col-lg-10 col-md-12 col-sm-12">
        <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>email id</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($row=$res->fetch_assoc()) {
                            echo '<tr>
                            <form method="post">
                                <td>'.$row["username"].' <input type="hidden" value="'. $row['user_id'] .'" name="user_id"></td>
                                <td>'.$row["email"].'</td>
                                <td><button type="submit" class="bsbtn btn-outline-pink">remove user</button></td>
                            </form>
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