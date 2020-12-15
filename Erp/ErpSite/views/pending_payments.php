<!DOCTYPE html>
<html lang="en">

<?php
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
    if (isset($_POST['button1'])) {
        $conn->query("update payments set balance=0 where payment_id={$_POST['payment_id']}");
    }
    if ($_GET['user']=="shop") {
        $shop_id = $conn->query("select shop_id from shop where shop_owner={$_SESSION['user_id']}")->fetch_row()[0];
        $pending = $conn->query("select * from payments where shop_id={$shop_id} and balance>0 ");
    } else if ($_GET['user']=="customer") {
        $pending = $conn->query("select * from payments where cust_id={$_SESSION['user_id']} and balance>0 ");
    }

    if(isset($_POST['button2'])) {
    $payment_id = $_POST['payment_id'];
    $items =  $conn->query("select * from payments where payment_id={$payment_id}");
    $row=$items->fetch_assoc();
    $sql5 = "SELECT * from shop WHERE shop_id='{$row['shop_id']}'";
$result5 = mysqli_query($conn, $sql5);
$id3 = mysqli_fetch_assoc($result5);
$sql6 = "SELECT * from address WHERE user_id='{$id3['shop_owner']}'";
$result6 = mysqli_query($conn, $sql6);
$address = mysqli_fetch_assoc($result6);
    require 'php mailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    $mail->Username = 'yadavhemant1716@gmail.com';
    $mail->Password = '';

    $mail->setFrom('yadavhemant1716@gmail.com');
    $mail->addAddress('2018.hemantkumar.yadav@ves.ac.in');
    $mail->addReplyTo('yadavhemant1716@gmail.com');
    $mail->isHTML(true);
    $mail->Subject='Payment reminder';
    $mail->Body='<h3>Your payment of '.$row['balance'].' for date '.$row['pay_date'].' is pending.</h3> <p>
    Shop Name:<strong>'.$id3['shop_name'] .'</strong>
    <br>
    Shop reg_no:<strong> '.$id3['reg_no'] .'</strong>
    <br>
    Shop Category:<strong> '.$id3['category'] .'</strong>
    <br>
    Shop Address:<strong>
    '. $address['blg'].''. $address['lane'] .''.$address['landmark'].''. $address['city'].''.  $address['pincode'].'

    <img src="data:image/png;charset=utf8;base64,' . base64_encode($id3['picture']) . '" class="rounded-img" />
    </strong>
        </p>';

    if($mail->send()){
        echo "<script>alert(Message sent successfully...)</script>";
     }else {
        echo "<script>alert(Message could not be sent...)</script>";
     }

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
                    echo '<td><button type="submit" class="bsbtn btn-outline-pink" name="button1"
                    value="button1">Clear payment</button>
                            <button class="bsbtn btn-primary" name="button2"
                            value="button2">Send reminder</button></td>';
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
        $('#table_id').DataTable({
        responsive: true
    });
    } );
</script>
</html>