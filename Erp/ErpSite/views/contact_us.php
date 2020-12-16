<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php 
    require 'includeCDN.php';
    require 'welcome.php';
    require '../models/connDB.php';
?>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/contact_us.css">
    <link rel="stylesheet" href="css/common.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
<?php
    if (count($_POST)>0) {
      if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $conn->query("insert into feedback(user_id, first_name, last_name, recovery_email, ratings, message) values('{$_SESSION['user_id']}','{$_POST['first_name']}','{$_POST['last_name']}','{$_POST['email']}','{$_POST['rating']}','{$_POST['message']}') ");
        print_r($conn);
        echo '<script>alert("thanks for the feedback")</script>';
      } else {
        echo '<script>alert("wrong email")</script>';
      }
    }
?>

  <body>
      <div class="outer-container">
    <div class="container col-lg-10 col-md-10 col-sm-10">
      <div class="text">Contact us</div>
<form action="contact_us.php" method="post">
        <div class="form-row">
          <div class="input-data">
            <input type="text"  name="first_name" required>
            <div class="underline">
</div>
<label for="">First Name</label>
          </div>
<div class="input-data">
            <input type="text"  name="last_name" required>
            <div class="underline">
</div>
<label for="">Last Name</label>
          </div>
</div>
<div class="form-row">
          <div class="input-data">
            <input type="text"  name="email" required>
            <div class="underline">
</div>
<label for="">recovery Email Address</label>
          </div>
<div class="input-data">
            <input type="text" name="rating" required>
            <div class="underline">
</div>
<label for="">rate our service out of 5</label>
          </div>
</div>
<div class="form-row">
          <div class="input-data textarea">
            <textarea rows="8" cols="80" name="message" required></textarea> 
            <br />
<div class="underline">
</div>
<label for="">Write your message</label>
          
        
        <br />
<div class="form-row submit-btn">
          <div class="input-data">
            <div class="inner"></div>
            <input type="submit" value="submit">
            </div>
          </div>
      </form>
    </div>
    </div>
  </body>
</html>
