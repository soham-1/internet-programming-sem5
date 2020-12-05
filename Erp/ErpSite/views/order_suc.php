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
$sql5 = "SELECT * from shop WHERE shop_id='{$shop_id}'";
$result5 = mysqli_query($conn, $sql5);
$id3 = mysqli_fetch_assoc($result5);
$sql6 = "SELECT * from address WHERE user_id='{$id3['shop_owner']}'";
$result6 = mysqli_query($conn, $sql6);
$address = mysqli_fetch_assoc($result6);
?>

<head>
<style type="text/css">
      /* Set the size of the div element that contains the map */
      #map {
        width: 30%;
        /* The width is the width of the web page */
      }
    </style>
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
        <img src=js/3.gif style=width:5%>
        Your order is Confirmed
</div>
Please collect your order from
<p>
Shop Name:<strong> <?php echo$id3['shop_name'] ?></strong>
<br>
Shop reg_no:<strong> <?php echo$id3['reg_no'] ?></strong>
<br>
Shop Category:<strong> <?php echo$id3['category'] ?></strong>
<br>
Shop Address:<strong>
<?php echo $address['blg'], $address['lane'], $address['landmark'], $address['city'], $address['pincode'];

echo'<img src="data:image/png;charset=utf8;base64,' . base64_encode($id3['picture']) . '" class="rounded-img" />' ?>
</strong>
    </p>


        </div>
    </div>
</body>
<script
      src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap&libraries=&v=weekly"
      defer
    ></script>
    <style type="text/css">
      /* Set the size of the div element that contains the map */
      #map {
        height: 400px;
        /* The height is 400 pixels */
        width: 100%;
        /* The width is the width of the web page */
      }
    </style>
    <script>
      // Initialize and add the map
      function initMap() {
        // The location of Uluru
        const uluru = { lat: -25.344, lng: 131.036 };
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 4,
          center: uluru,
        });
        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
          position: uluru,
          map: map,
        });
      }
    </script>

    <!--The div element for the map -->

</html>