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
    $feedbacks = $conn->query("select * from feedback");
?>
<body>
<div class="outer-container">
    <div class="container col-lg-10 col-md-12 col-sm-12">
        <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>email id</th>
                        <th>rating</th>
                        <th>message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($feedbacks->num_rows>0) {
                            while ($row=$feedbacks->fetch_assoc()) {
                                echo '<tr>
                                
                                    <td>'.$row["first_name"] .' '. $row["last_name"]  .'</td>
                                    <td>'.$row["recovery_email"].'</td>
                                    <td>'.$row["ratings"].'</td>
                                    <td>'.$row["message"].'</td>
                                
                                    </tr>';
                            }
                        } else {
                            echo '<td></td>
                                <td></td>
                                <td></td>
                                <td></td>';
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