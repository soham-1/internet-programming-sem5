<?php
    require 'welcome.php';
    require '../models/connDB.php';
    $showalert = false;
    $showerror = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $prod_id = $_POST['product_name'];
    $qty = $_POST['qty'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];

    $shop_id = $conn->query("select shop_id from shop where shop_owner='{$_SESSION['user_id']}' limit 1")->fetch_row()[0];
    $res = $conn->query("select prod_id from inventory where shop_id='{$shop_id}' and prod_id='{$prod_id}' limit 1");
    if ($res->num_rows > 0) {
      $conn->query("update inventory set price='{$price}', description='{$description}', qty='{$qty}', discount='{$discount}' where shop_id='{$shop_id}' and prod_id='{$prod_id}' limit 1");
      echo '<script>alert("product updated")</script>';
    } else {
      $conn->query("insert into inventory(shop_id, prod_id, price, discount, qty, description) values('{$shop_id}', '{$prod_id}', '{$price}', '{$discount}', '{$qty}', '{$description}') ");
      echo '<script>alert("product added")</script>';
      
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/prod_form.css">

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </head>
  <body>

<div class=outer-container>
    <div class="container col-lg-10 col-md-11 col-sm-12">
 
      <header>Product Form</header>

<div class="form-outer">
<form action="add_inventory.php" method=POST>
    <div class="row">
      <div class="field col-lg-2 col-md-4 col-sm-12">
        <label for="category">products</label>
      </div>
      <div class="col-75">
        <select id="category" name="product_name">
          <?php
            $options = $conn->query('select product_id, name from products');
            while($row=$options->fetch_assoc()) {
              echo '<option value="'. $row['product_id'] . '">'. $row['name'] .'</option>';
            }
          ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="field col-lg-2 col-md-4 col-sm-12">
        <label for="description">Description<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-75">
        <input type="text" id="description" name="description">
      </div>
    </div>
    <div class="row">
      <div class="field col-lg-2 col-md-4 col-sm-12">
        <label for="price">Price<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-25">
        <input type="text" id="price" name="price" >
      </div>
    </div>
    <div class="row">
      <div class="field col-lg-2 col-md-4 col-sm-12">
        <label for="price">qty<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-25">
        <input type="text" id="qty" name="qty" >
      </div>
    </div>
    <div class="row">
      <div class="field col-lg-2 col-md-4 col-sm-12">
        <label for="price">discount<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-25">
        <input type="text" id="discount" name="discount" value="0">
      </div>
    </div>
    <div class="field btns">
        <button type=submit class="submit" >Submit</button>
    </div>

</form>
</div>
</div>


</div>
</body>
</html>