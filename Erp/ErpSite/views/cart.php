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
// select i.price, p.image, p.name, c.qty from inventory i inner join cart c on i.prod_id=c.prod_id inner join products p on p.product_id=i.prod_id where i.shop_id=
while ($row=$cart_items->fetch_assoc()) {
    $sql = "select i.price, p.image, p.name, c.qty from cart c inner join products p on c.prod_id=p.product_id inner join inventory i on i.prod_id=p.product_id where c.shop_id='{$row['shop_id']}'";
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
    while ($row=$res->fetch_assoc()){
        $total_quantity = 0;
        $total_price = 0;
		?>
				<tr>
				<td><?php echo '<img src="data:image/png;charset=utf8;base64,' . base64_encode($row['image']) . '" class="cart-item-image" />' ?><?php echo $row["name"]; ?> </td>
				<td><?php echo "dfsf" ?></td>
				<td style="text-align:right;"><?php echo $row["qty"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ".$row["price"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ". number_format($row["price"]*$row["qty"],2); ?></td>
				<td style="text-align:center;"><a href="index.php?action=remove&code=<?php echo "sfds"; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
				</tr>
				<?php
				$total_quantity += $row["qty"];
				$total_price += ($row["price"]*$row["qty"]);
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