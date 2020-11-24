<!DOCTYPE html>
<html lang="en">

<?php
    require 'includeCDN.php';
    require 'welcome.php';
    require '../models/connDB.php';
?>
<head>
    <link rel="stylesheet" href="css/common.css">
</head>
<body>
<div id="shopping-cart">
<div class="txt-heading">Shopping Cart</div>

<a id="btnEmpty" href="cart.php?action=empty">Empty Cart</a>
<?php
$cust_id = $_SESSION['user_id'];
$cart_items = $conn->query("select * from cart where customer_id='{$cust_id}'  ");
$price_array = array();
$prod_names = array();
$qty_llol = array();
while($row = $cart_items->fetch_assoc()){
array_push($price_array,$conn->query("select * from inventory where prod_id='{$row['prod_id']}' AND shop_id='{$row['shop_id']}' "));
array_push($prod_names,$conn->query("select * from products where product_id='{$row['prod_id']}'"));
array_push($qty_llol,$row);
}

if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
        //code for adding product in cart
        case "add":
        break;
        // code for removing product from cart
        case "remove":
        break;
        // code for if cart is empty
        case "empty":
            $del_cart = $conn->query("DELETE FROM `cart` WHERE `customer_id` = '{$cust_id}'");
            echo '<script>alert("All Product Removed from Cart")</script>';
        break;
    }
    }
?>
<table class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;">Name</th>
<th style="text-align:left;">Code</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right;" width="10%">Price</th>
<th style="text-align:center;" width="5%">Remove</th>
</tr>
<?php
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["price"];
		?>
				<tr>
				<td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
				<td><?php echo $item["code"]; ?></td>
				<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
				<td style="text-align:center;"><a href="index.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
				</tr>
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
		?>

<tr>
<td colspan="2" align="right">Total:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>
</div>
</body>
</html>