<?php
    require 'welcome.php';
    require '../models/connDB.php';
    $showalert = false;
    $showerror = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$prod_name = $_POST['prod_name'];
$category = $_POST['category'];
$description = $_POST['description'];
$price = $_POST['price'];
if(isset($_POST['image']))
    {
        $_useImagePost = 1;
        $_imagePost = file_get_contents($_FILES['image']['tmp_name']);
    }
$sql = "INSERT INTO `products` (`name`, `category`, `image`,`price`,`Description`) VALUES ('$prod_name', '$category', '$_imagePost','$price','$description')";
    $result = mysqli_query($conn,$sql);
    if ($result){
            $showalert = true;
    }
    else{
        $showerror = 'Cannot insert';
    }


}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/prod_form.css">

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </head>
  <body>

<div class=outer-container>
    <div class="container">

      <header>Product Form</header>

<div class="form-outer">
<form action="add_product.php" method=POST enctype="multipart/form-data">
<div class="row">
      <div class="field">
        <label for="pname">Product Name<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-75">
        <input type="text" id="pname" name="prod_name" placeholder="Product name..">
      </div>
    </div>

    <div class="row">
      <div class="field">
        <label for="category">Category</label>
      </div>
      <div class="col-75">
        <select id="category" name="category">
          <option value="biscuits">Biscuits</option>
          <option value="grocery">Grocery</option>
          <option value="others">Others</option>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="field">
        <label for="description">Description<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-75">
        <input type="text" id="description" name="description">
      </div>
    </div>
    <div class="row">
      <div class="field">
        <label for="price">Price<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-25">
        <input type="text" id="price" name="price" >
      </div>
    </div>
    <div class="field" style="margin-top:20px">
              <div class="label">Images:</div>
              <input type='file' onchange="readURL(this);" >
<img id="blah" src="http://placehold.it/180" alt="your image" name="image" id="image">
            </div>


    <div class="field btns">
              <button type=submit class="submit" >Submit</button>
            </div>

</form>
</div>
</div>


</div>

<script>
         function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
  </body>
</html>
