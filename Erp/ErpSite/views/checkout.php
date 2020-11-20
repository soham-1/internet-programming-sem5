<?php
    header("Pragma: no-cache");
    header("Cache-Control: no-cache");
    header("Expires: 0");
    require 'welcome.php';
    require '../models/connDB.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/prod_form.css">
    <title>Document</title>
</head>
<body>
<div class=outer-container>
    <div class="container">

      <header>Checkout Form</header>

      <h4>Cart
        <span class="price" style="color:black">
          <i class="fa fa-shopping-cart"></i>
          <b>4</b>
        </span>
      </h4>
      <p><a href="#">Product 1</a> <span class="price">$15</span></p>
      <p><a href="#">Product 2</a> <span class="price">$5</span></p>
      <p><a href="#">Product 3</a> <span class="price">$8</span></p>
      <p><a href="#">Product 4</a> <span class="price">$2</span></p>
      <hr>
      <p>Total <span class="price" style="color:black"><b>$30</b></span></p>
      <div class="form-outer">
    <form method="POST" action="pgRedirect.php">
    <div class="row">
    <div class="field">
    <label for="">Order ID</label>
    </div>
    <div class="col-75">
    <input id="ORDER_ID"  name="ORDER_ID" value="<?php echo "OD".rand(10000,500000) ?>" type="text"/>
    </div>
    </div>
    <div class="row">
    <div class="field">
    <label for=""> Customer ID</label>
    </div>
    <div class="col-75">
    <input type="text" id="CUST_ID" name="CUST_ID" value="CUST001"/>
    </div>
    </div>
    <div class="row">
    <div class="field">
    <label for="">INDUSTRY TYPE ID</label>
    </div>
    <div class="col-25">
    <input id="INDUSTRY_TYPE_ID" name="INDUSTRY_TYPE_ID" type="text" value="Film" />
    </div>
    </div>
    <div class="row">
    <div class="field">
    <label for="CHANNEL_ID">CHANNEL ID</label>
    </div>
    <div class="col-75">
    <input id="CHANNEL_ID" name="CHANNEL_ID" type="text" value="WEB"/>
    </div>
    </div>
    <div class="row">
    <div class="field">
    <label for="TXN_AMOUNT">Transaction Amount</label>
    </div>
    <div class="col-75">
    <input type="text" id="TXN_AMOUNT" name="TXN_AMOUNT" value="1" />
    </div>
    <button type=submit>Submit</button>
    </div>

</div>
    </form>
    </div>
    </div>
</body>
</html