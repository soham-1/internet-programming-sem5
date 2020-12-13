<?php
    require 'welcome.php';
    require '../models/connDB.php';
    $showalert = false;
    $showerror = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($_POST['new_product']!="") {
      $shop_id = $conn->query("select shop_id from shop where shop_owner='{$_SESSION['user_id']}' limit 1")->fetch_row()[0];
      $product = $_POST['new_product'];
      $res = $conn->query("select name from products where name='{$_POST['new_product']}' limit 1");
      if ($res->num_rows>0) {
        echo "<script>alert('product already in options !')</script>";
      } else if ($_FILES['prod_image']['tmp_name']=="") {
        echo "<script>alert('image required while entering a new product')</script>";
      } else if ($_POST['category']=="") {
        echo "<script>alert('category required while entering a new product')</script>";
      } else if (is_numeric($_POST['price'])==false || is_numeric($_POST['discount'])==false || (int)$_POST['price']<0 || (int)$_POST['discount']<0 || $_POST['qty']<=0) {
        echo "<script>alert('wrong details !')</script>";
      } else {
        $imgData = addslashes(file_get_contents($_FILES['prod_image']['tmp_name']));
        $conn->query("insert into products(name,category,image) values('{$_POST['new_product']}', '{$_POST['category']}', '{$imgData}')");
        $prod_id = $conn->query("select * from products where name='{$_POST['new_product']}' limit 1")->fetch_assoc()['product_id'];
        $conn->query("insert into inventory(shop_id, prod_id, qty, discount, description, price) values('{$shop_id}', '{$prod_id}', '{$_POST['qty']}', '{$_POST['discount']}', '{$_POST['description']}', '{$_POST['price']}')");
        echo '<script>alert("product added")</script>';
      }
    } else {
      $prod_id = $_POST['product_name'];
      $qty = $_POST['qty'];
      $description = $_POST['description'];
      $price = $_POST['price'];
      $discount = $_POST['discount'];
      if (is_numeric($_POST['price'])==false || is_numeric($_POST['discount'])==false || (int)$_POST['price']<0 || (int)$_POST['discount']<0 || $_POST['qty']<=0) {
        echo "<script>alert('wrong details !')</script>";
      } else {
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
<form action="add_inventory.php" enctype="multipart/form-data" method=POST>
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
    <div class="row" style="justify-content:center;">
      -- or enter a new product --
    </div>
    <div class="row">
      <div class="field col-lg-2 col-md-4 col-sm-12">
        <label for="new_product">product</label>
      </div>
      <div class="col-75">
        <input type="text" id="new_product" name="new_product">
      </div>
    </div>
    <div class="row">
      <div class="field col-lg-2 col-md-4 col-sm-12">
        <label for="description">Description<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-75">
        <input type="text" id="description" name="description" required>
      </div>
    </div>
    <div class="row">
      <div class="field col-lg-2 col-md-4 col-sm-12">
        <label for="price">Price<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-25">
        <input type="text" id="price" name="price" required>
      </div>
    </div>
    <div class="row">
      <div class="field col-lg-2 col-md-4 col-sm-12">
        <label for="price">qty<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-25">
        <input type="text" id="qty" name="qty" required>
      </div>
    </div>
    <div class="row">
      <div class="field col-lg-2 col-md-4 col-sm-12">
        <label for="price">discount<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-25">
        <input type="text" id="discount" name="discount" value="0" required>
      </div>
    </div>
    <div class="row">
      <div class="field col-lg-2 col-md-4 col-sm-12">
        <label for="price">category if new product<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-25">
        <input type="text" id="discount" name="category">
      </div>
    </div>
    <div class="row">
      <div class="field col-lg-2 col-md-4 col-sm-12">
        <label for="price">image if new product<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-25">
        <input type="file" id="discount" name="prod_image">
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