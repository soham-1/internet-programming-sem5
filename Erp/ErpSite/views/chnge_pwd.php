<?php
    require 'includeCDN.php';
    require 'welcome.php';
    require '../models/connDB.php';
    $showalert = false;
    $showerror = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$pwd = $_POST['pwd'];
$new_pwd = $_POST['new_pwd'];
$cnf_pwd = $_POST['cnf_pwd'];
$user_id = $_SESSION['user_id'];
$sql = "Select * from user where user_id='$user_id'";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
if ($num ==1){
            $row=mysqli_fetch_assoc($result);
          if(password_verify($pwd,$row['password'])){
              if($new_pwd==$cnf_pwd){
            $hash = password_hash($new_pwd, PASSWORD_DEFAULT);
            $sql1 = "UPDATE user set password='" . $new_pwd . "' WHERE user_id='" . $user_id . "'";
            $result = mysqli_query($conn,$sql);
            $showalert = true;
        }
        else{
            $showerror = "Passwords do not match";
        }
    }
        else{
            $showerror = "old Password not correct";
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </head>
  <body>
  <?php
   if($showalert){
       echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your password has been updated.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
   }
   if($showerror){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
<strong>Error!</strong> '.$showerror.'
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
 <span aria-hidden="true">&times;</span>
</button>
</div>';
}
?>
<div class=outer-container>
    <div class="container col-lg-5 col-md-5 col-sm-5">
<header> Change Password </header>

<div class="form-outer">
<form  method=POST >
<div class="row">
      <div class="field">
        <label for="pwd">Old Password<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-75">
        <input type="password" id="pwd" name="pwd" placeholder="Old Password" style="width:50%; height:30px; float:left;">
      </div>
      </div>
      <div class="row">
      <div class="field">
        <label >New Password<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-75">
        <input type="password" id="new_pwd" name="new_pwd" placeholder="New Password" style="width:50%; height:30px; float:left;">
      </div>
      </div>
      <div class="row">
      <div class="field">
        <label >Confirm Password<sup style="color:red;">*</sup></label>
      </div>
      <div class="col-75">
        <input type="password" id="cnf_pwd" name="cnf_pwd" placeholder="Confirm Password" style="width:50%; height:30px; float:left; ">
      </div>
      </div>


              <button type=submit class="bsbtn btn-primary" style="float:left; margin-top:10px;" >Submit</button>


</form>
</div>
</div>

</div>
</div>

</body>
</html>
