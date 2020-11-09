<?php
    require 'welcome.php';
    require '../models/connDB.php';
    $showerror = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$shop_name = $_POST['shop_name'];
$reg_no = $_POST['reg_no'];
$category = $_POST['category'];
$shop_owner = $_SESSION['username'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$alt_phone_number = $_POST['alt_phone_number'];
$bldg = $_POST['bldg'];
$lane = $_POST['lane'];
$city =$_POST['city'];
$pincode = $_POST['pin_code'];

$sql = "INSERT INTO `shop` (`reg_no`, `shop_name`, `shop_owner`, `category`) VALUES ('$reg_no', '$shop_name',  '$shop_owner', '$category')";
    $result = mysqli_query($conn,$sql);
    if ($result){
            $showalert = true;
    }


}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/shop_form.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </head>
  <body>

<div class=outer-container>
    <div class="container">
      <header>Shop Form</header>
      <div class="progress-bar">
        <div class="step">
          <p>
Details</p>
<div class="bullet">
            <span>1</span>
          </div>
<div class="check fas fa-check">
</div>
</div>
<div class="step">
          <p>
Contact</p>
<div class="bullet">
            <span>2</span>
          </div>
<div class="check fas fa-check">
</div>
</div>
<div class="step">
          <p>
Address</p>
<div class="bullet">
            <span>3</span>
          </div>
<div class="check fas fa-check">
</div>
</div>
<div class="step">
          <p>
Gallery</p>
<div class="bullet">
            <span>4</span>
          </div>
<div class="check fas fa-check">
</div>
</div>
</div>
<div class="form-outer">
<form action="shop_info.php" method=POST>
          <div class="page slide-page">
            <div class="title">
Shop Info:</div>
<div class="field">
              <div class="label">Shop Name<sup style="color:red;">*</sup></div>
<input type="text" name="shop_name" id="shop_name" required>
            </div>
<div class="field">
              <div class="label">Reg no<sup style="color:red;">*</sup></div>
<input type="text" name="reg_no" id="reg_no" required>
            </div>
            <div class="field">
              <div class="label">Category<sup style="color:red;">*</sup></div>
<input type="text" name="category" id="category" required>
            </div>
<div class="field">
              <button class="firstNext next">Next</button>
            </div>
</div>
<div class="page">
            <div class="title">
Contact Info:</div>
<div class="field">
              <div class="label">
Email Address<sup style="color:red;">*</sup></div>
<input type="email" name="email" id="email" required>
            </div>
<div class="field">
              <div class="label">
Phone Number<sup style="color:red;">*</sup></div>
<input type="Number" max=12 name="phone_number" id="phone_number" required>
            </div>
            <div class="field">
              <div class="label">
Alternate Phone Number</div>
<input type="Number" max=12 name="alt_phone_number" id="alt_phone_number">
            </div>
<div class="field btns">
              <button class="prev-1 prev">Previous</button>
              <button class="next-1 next">Next</button>
            </div>
</div>
<div class="page">
            <div class="title">
Address:</div>
<div class="field">
              <div class="label">BLDG/Gala no.<sup style="color:red;">*</sup></div>
<input type="text" name="bldg" id="bldg" required>
            </div>
<div class="field">
              <div class="label">Lane/Landmark<sup style="color:red;">*</sup></div>
              <input type="text" name="lane" id="lane" required>
            </div>
            <div class="field">
              <div class="label">City<sup style="color:red;">*</sup></div>
              <input type="text" name="city" id="city" required>
            </div>
            <div class="field">
              <div class="label">Pincode<sup style="color:red;">*</sup></div>
              <input type="text" name="pin_code" id="pin_code" required>
            </div>
<div class="field btns">
              <button class="prev-2 prev">Previous</button>
              <button class="next-2 next">Next</button>
            </div>
</div>
<div class="page">
            <div class="title">
Gallery:</div>
<div class="field">
              <div class="label">Images</div>
              <input type='file' onchange="readURL(this);" >
<img id="blah" src="http://placehold.it/180" alt="your image" style="width:300px;" name="image" id="image">
            </div>
            <div class="field">
              <div class="label">Desciption</div>

            </div>
<div class="field btns">
              <button class="prev-3 prev">Previous</button>
              <button type=submit class="submit" >Submit</button>
            </div>
</div>
</form>
</div>
</div>
<!-- Somehow I got an error, so I comment the script tag, just uncomment to use -->
<!-- <script src="script.js"></script> -->
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
const slidePage = document.querySelector(".slide-page");
const nextBtnFirst = document.querySelector(".firstNext");
const prevBtnSec = document.querySelector(".prev-1");
const nextBtnSec = document.querySelector(".next-1");
const prevBtnThird = document.querySelector(".prev-2");
const nextBtnThird = document.querySelector(".next-2");
const prevBtnFourth = document.querySelector(".prev-3");
const submitBtn = document.querySelector(".submit");
const progressText = document.querySelectorAll(".step p");
const progressCheck = document.querySelectorAll(".step .check");
const bullet = document.querySelectorAll(".step .bullet");
let current = 1;

nextBtnFirst.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "-25%";
  bullet[current - 1].classList.add("active");
  progressCheck[current - 1].classList.add("active");
  progressText[current - 1].classList.add("active");
  current += 1;
});
nextBtnSec.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "-50%";
  bullet[current - 1].classList.add("active");
  progressCheck[current - 1].classList.add("active");
  progressText[current - 1].classList.add("active");
  current += 1;
});
nextBtnThird.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "-75%";
  bullet[current - 1].classList.add("active");
  progressCheck[current - 1].classList.add("active");
  progressText[current - 1].classList.add("active");
  current += 1;
});
submitBtn.addEventListener("click", function(){
  bullet[current - 1].classList.add("active");
  progressCheck[current - 1].classList.add("active");
  progressText[current - 1].classList.add("active");
  current += 1;
});

prevBtnSec.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "0%";
  bullet[current - 2].classList.remove("active");
  progressCheck[current - 2].classList.remove("active");
  progressText[current - 2].classList.remove("active");
  current -= 1;
});
prevBtnThird.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "-25%";
  bullet[current - 2].classList.remove("active");
  progressCheck[current - 2].classList.remove("active");
  progressText[current - 2].classList.remove("active");
  current -= 1;
});
prevBtnFourth.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "-50%";
  bullet[current - 2].classList.remove("active");
  progressCheck[current - 2].classList.remove("active");
  progressText[current - 2].classList.remove("active");
  current -= 1;
});

</script>
</div>
  </body>
</html>
