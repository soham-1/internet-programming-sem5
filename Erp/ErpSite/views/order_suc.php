<!DOCTYPE html>
<html lang="en">

<?php
    require 'includeCDN.php';
    require 'welcome.php';
    require '../models/connDB.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){


$cust_id = $_POST['CUST_ID'];
$amount = $_POST['TXN_AMOUNT'];
$payment_method = "COD";

$balance = $amount;
$cart_items = $conn->query("select * from cart where customer_id='{$cust_id}'  ");
// select i.price, p.image, p.name, c.qty from inventory i inner join cart c on i.prod_id=c.prod_id inner join products p on p.product_id=i.prod_id where i.shop_id=
while ($row=$cart_items->fetch_assoc()) {
$sql3 = "select i.price, p.image, p.name, c.qty,p.product_id from cart c inner join products p on c.prod_id=p.product_id inner join inventory i on i.prod_id=p.product_id where c.shop_id='{$row['shop_id']}'";
$res = $conn->query($sql3);
$shop_id = $row['shop_id'];

}
$sql = "INSERT INTO `payments` ( `cust_id`, `amount`, `shop_id`,`balance`,`payment_method`) VALUES ('$cust_id', '$amount',  '$shop_id', '$balance','$payment_method')";
$result = mysqli_query($conn,$sql);
$payment_id=mysqli_insert_id($conn);
while ($row=$res->fetch_assoc()){
$sql2 = "INSERT INTO `payment_details` ( `payment_id`, `prod_id`, `qty`) VALUES ('$payment_id', '{$row['product_id']}','{$row['qty']}')";

$result2 = mysqli_query($conn,$sql2);
}
}
?>
<head>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/prod_form.css">
</head>
<body>
<div class=outer-container>
    <div class="container">

<header>Order Confirmed
        <span class="price" style="color:black">
          <i class="fa fa-shopping-cart"></i>
        </span></header>
        <div class=row>
        <img src=js/3.gif style=width:15%>
        Your order is Confirmed
</div>
Please collect your order from
<div id=map></div>

        </div>
    </div>
</body>
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRtriDLo0bnzuCz9xL5wQmclzUTEeh69Y&callback=initMap&libraries=&v=weekly"
      defer
    ></script>

    <script>
      // Initialize and add the map
      function initMap() {
        // The location of Uluru
        const uluru = { lat: <?php echo $address[6]; ?>,lng: <?php echo $address[7]; ?> };
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 14,
          center: uluru,
        });
        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
          position: uluru,
          map: map,
        });
      }
    </script>
</html>