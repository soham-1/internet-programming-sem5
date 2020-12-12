<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	include '../models/connDB.php';
$cust_id = $_POST['CUST_ID'];
$amount = $_POST['TXN_AMOUNT'];
$payment_method = "Paytm";

$balance = 0;
$cart_items = $conn->query("select * from cart where customer_id='{$cust_id}'  ");
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
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$checkSum = "";
$paramList = array();

$ORDER_ID = $_POST["ORDER_ID"];
$CUST_ID = $_POST["CUST_ID"];
$INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
$CHANNEL_ID = $_POST["CHANNEL_ID"];
$TXN_AMOUNT = $_POST["TXN_AMOUNT"];

// Create an array having all required parameters for creating checksum.
$paramList["MID"] = PAYTM_MERCHANT_MID;
$paramList["ORDER_ID"] = $ORDER_ID;
$paramList["CUST_ID"] = $CUST_ID;
$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
$paramList["CHANNEL_ID"] = $CHANNEL_ID;
$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;

//Here checksum string will return by getChecksumFromArray() function.
$checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);

?>
<html>
<head>
<title>Merchant Check Out Page</title>
</head>
<body>
	<center><h1>Please do not refresh this page...</h1></center>
		<form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
		<table border="1">
			<tbody>
			<?php
			foreach($paramList as $name => $value) {
				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
			}
			?>
			<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
			</tbody>
		</table>
		<script type="text/javascript">
			document.f1.submit();
		</script>
	</form>
</body>
</html>