<!DOCTYPE html>
<html lang="en">

<?php
    require 'includeCDN.php';
    require 'welcome.php';
    require '../models/connDB.php';
?>
<head>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/prod_form.css">
</head>
<body>
<div class=outer-container>
    <div class="container">

<header>Cart
        <span class="price" style="color:black">
          <i class="fa fa-shopping-cart"></i>
        </span></header>
<div id="shopping-cart">
<a id="btnEmpty" href="cart.php?action=empty"><button class="bsbtn btn-danger">Empty Cart</button></a>
<?php
$cust_id = $_SESSION['user_id'];
$cart_items = $conn->query("select * from cart where customer_id='{$cust_id}'  ");
// select i.price, p.image, p.name, c.qty from inventory i inner join cart c on i.prod_id=c.prod_id inner join products p on p.product_id=i.prod_id where i.shop_id=
while ($row=$cart_items->fetch_assoc()) {
    $sql = "select i.price, i.discount, p.image, p.name, c.qty,p.product_id from cart c inner join products p on c.prod_id=p.product_id inner join inventory i on i.prod_id=p.product_id where c.shop_id='{$row['shop_id']}'";
    $res = $conn->query($sql);
}
// select i.price, p.image, p.name, c.qty from cart c inner join products p on c.prod_id=p.product_id inner join inventory i on i.prod_id=p.product_id where c.shop_id=$shop_id;
// $row = $cart_items->fetch_assoc();
// $prod = $conn->query("select * from inventory where prod_id='{$row['prod_id']}' AND shop_id='{$row['shop_id']}' ");
// $row = $prod->fetch_assoc();
// $prod_view = $conn->query("select * from products where product_id='{$_row['prod_id']}'");
// $prod_img = $prod_view->fetch_assoc();
//     $price = $conn->query("select * from inventory where prod_id='{$_GET['product_id']}' ");
//     $price_array = array();
//     $shop_names = array();
//     $shop_ids = array();
//     while ($row = $price->fetch_assoc()) {
//         array_push($shop_names,$conn->query("select * from shop where shop_id='{$row['shop_id']}'")->fetch_row()[0]);
//         array_push($price_array, $row);
//     }
if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
        //code for adding product in cart
        case "add":
        break;
        // code for removing product from cart
        case "remove":
            $del_cart = $conn->query("DELETE FROM `cart` WHERE `customer_id` = '{$cust_id}' and `prod_id` = '{$_GET['code']}'");
            echo '<script>alert("Product Removed from Cart")</script>';
            $_SESSION['cart'] -=1;
        break;
        // code for if cart is empty
        case "empty":
            $del_cart = $conn->query("DELETE FROM `cart` WHERE `customer_id` = '{$cust_id}'");
            echo '<script>alert("All Product Removed from Cart")</script>';
            $_SESSION['cart'] = 0;
        break;
    }
    }
?>
<table class="tbl-cart" cellpadding="10"  style="border:2px solid black;">
<tbody>
<tr>
<th >Name</th>
<th >Image</th>
<th >Code</th>
<th>Quantity</th>
<th>Unit Price</th>
<th>Price</th>
<th >Remove</th>
<br>
</tr>

<?php
$total_quantity = 0;
$total_price = 0;
if (isset($res)) {
    while ($row=$res->fetch_assoc()){
        $discount = $row['discount'];
        $discounted_price = (int)$row["price"] - ((int)$row["price"]*$discount/100);
        $total_price1 = $discounted_price*(int)$row["qty"];

		?>
            <tr>
            <td><?php echo $row["name"]; ?> </td>
            <td><?php echo '<img src="data:image/png;charset=utf8;base64,' . base64_encode($row['image']) . '" class="cart-item-image" style="width:10%"/>' ?></td>

            <td><?php echo $row["product_id"] ?></td>
            <td><?php echo $row["qty"]; ?></td>
            <td><?php echo "RS. ".$row["price"]; ?></td>
            <td><?php $total_sing=$total_price1; echo "Rs. ". number_format($total_price1,2); ?></td>
            <td><a href="cart.php?action=remove&code=<?php echo $row["product_id"]  ?>" class="btnRemoveAction"><i class="fas fa-trash"></i></a></td>
            </tr>
            <?php
            $total_quantity += $row["qty"];
            $total_price += $total_sing;
        }
    } else {
        echo '<td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>';
    }
		?>

<tr>
<br>
<td colspan="2" align="right">Total:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo "Rs. ".number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>
</div>


      <div class="form-outer">
    <form method="POST" action="pgRedirect.php">
    <div class="row">
    <div class="field">
    <label for="">Order ID</label>
    </div>
    <div class="col-50">
    <input id="ORDER_ID"  name="ORDER_ID" value="<?php echo rand(10,5000) ?>" type="text"/>
    </div>
    </div>
    <div class="row">
    <div class="field">
    <label for=""> Customer ID</label>
    </div>
    <div class="col-25">
    <input type="text" id="CUST_ID" name="CUST_ID" value="<?php echo $cust_id; ?>" readonly/>
    </div>
    </div>
    <div class="row">
    <input id="INDUSTRY_TYPE_ID"  type="hidden" name="INDUSTRY_TYPE_ID" type="text" value="Film"  />
    <input id="shop_id"  type="hidden" name="shop_id" type="text" value="1"  />

    </div>
    <div class="row">

    <input id="CHANNEL_ID" type="hidden" name="CHANNEL_ID" type="text" value="WEB" />

    </div>
    <div class="row">
    <div class="field">
    <label for="TXN_AMOUNT">Transaction Amount</label>
    </div>
    <div class="col-25">
    <input type="text" id="TXN_AMOUNT" name="TXN_AMOUNT" value=<?php echo $total_price ?> readonly/>
    </div>
    </div>
    <div class="row">
    <button class="bsbtn btn-primary" type=submit>Pay Now</button>
    </div>


</div>
    </form>

    <form method="POST" action="order_suc.php">
    <input type="hidden" id="TXN_AMOUNT" name="TXN_AMOUNT" value=<?php echo $total_price ?> />
    <input type="hidden" id="CUST_ID" name="CUST_ID" value="<?php echo $cust_id; ?>" readonly/>
    <div class="field">
    <button class="bsbtn btn-primary" type=submit>Pay Later</button>
    </div>
    </form>

    </div>
    </div>
</body>
</html>