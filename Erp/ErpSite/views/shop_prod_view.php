<!DOCTYPE html>
<html lang="en">

<?php
    require 'includeCDN.php';
    require 'welcome.php';
    require '../models/connDB.php';
?>
<?php

    $prod_id = $_GET['product_id'];
    $shop_id = $_GET['shop_id'];
    // echo $prod_id;
    // echo $shop_id;
    $prod = $conn->query("select * from inventory where prod_id='{$prod_id}' AND shop_id='{$shop_id}' ");
    $row = $prod->fetch_assoc();
    $prod_view = $conn->query("select * from products where product_id='{$_GET['product_id']}'");
    $prod_img = $prod_view->fetch_assoc();
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $qty = $_POST['qty'];
        if($qty > 0){
        $cust_id = $_SESSION['user_id'];
        $check_cart = $conn->query("select * from cart where prod_id='{$prod_id}' AND shop_id='{$shop_id}' AND customer_id='{$cust_id}' ");
        $cart_row = $check_cart->fetch_assoc();
        if($cart_row > 1){
            echo '<script>alert("Product is already in your cart")</script>';}

        else{
        $conn->query("insert into cart(customer_id,shop_id,prod_id,qty) values('{$cust_id}', '{$shop_id}', '{$prod_id}','{$qty}') ");
        echo '<script>alert("product added to cart")</script>';
        $_SESSION['cart'] = $_SESSION['cart']+1;}
        // echo $qty;
        }
    }

?>
<head>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/shop_list.css">
    <script src="js/shopping.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

</head>
<body>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

        <!--jQuery library-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <!--Latest compiled and minified JavaScript-->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>

<body>

 <section>
   <div class="container-fluid">
     <div class="row">
       <!-- Product picture -->
       <div class="col-sm-5">
         <div class="thumbnail">
        <?php echo'<img src="data:image/png;charset=utf8;base64,' . base64_encode($prod_img['image']) . '" alt="image not available" style="width:80%">';?>

           <div class="caption">
             <div class="row buttons">

                 <button class="btn  col-sm-4 col-sm-offset-2 btn-lg add-cart" style="background-color:#ff9f00; color:#fff;font-size:1em;">ADD TO CART</button>



               <button class="btn col-sm-4 col-sm-offset-1 btn-lg" style="background-color:#fb641b; color:#fff;font-size:1em;"><i class="fa fa-bolt" style="font-size:1.2em;"></i> BUY NOW</button>
               </div>
               <br><br>
                 <div class="cart-form">
                 <form action="shop_prod_view.php?product_id=<?php echo $prod_id; ?>&shop_id=<?php echo $shop_id; ?>" method="post" id="qty_form">
                 <input type="text" name="qty" id="qty" value="0" max="<?php echo $row['qty']; ?>" >
                 <button class="bsbtn btn-primary" type="submit" id="cart" >Save</buton>
</form>
</div>
           </div>
         </div>

         </div>

       <!-- Product Description -->
       <div class="col-sm-7 desc">

         <div>

           <h4><?php echo $prod_img['name']; ?></h4>




          </div>

         <div>
          <h3>RS.<?php echo $row['price']; ?></h3>
          <strong class="col-xs-3">Category:<?php echo $prod_img['category'] ?></strong>
         </div>
<br>

           <div id="highlights">
            <strong class="col-xs-3">Description</strong>
            <br>
             <ul class="col-xs-6">
               <li><?php echo $row['description']; ?> </li>

               <li>Available Qty:<?php echo $row['qty']; ?>  </li>
             </ul>
           </div>

         </div>

  </section>



</body>
</html>