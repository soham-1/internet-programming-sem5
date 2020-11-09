<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
  }

  .topnav {
    overflow: hidden;
    background-color: rgb(12,19,29);
  }

  .topnav a {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
  }

  .topnav a:hover {
    background-color: #ddd;
    color: black;
  }


  .topnav .icon {
    display: none;
  }

  @media screen and (max-width: 600px) {
    .topnav a:not(:first-child) {display: none;}
    .topnav a.icon {
      float: right;
      display: block;
    }
  }

  @media screen and (max-width: 600px) {
    .topnav.responsive {position: relative;}
    .topnav.responsive .icon {
      position: absolute;
      right: 0;
      top: 0;
    }
    .topnav.responsive a {
      float: none;
      display: block;
      text-align: left;
    }
  }
    </style>

</head>
<body>
<?php
$dir = '/' . explode('htdocs\\', dirname(dirname(__FILE__)), 2)[1]; // refers to ErpSite folder
$basedir = '/' . explode('htdocs\\', dirname($dir))[0]; // refers to Erp folder
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
  $loggedin = true;
}
else{
  $loggedin = false;
}
$index_url = $dir . "/index.php";
$login_url = $dir . "/login.php";
$signup_url = $dir . "/signup.php";
$logout_url = $dir . "/logout.php";
echo'
<div class="topnav" id="myTopnav">
  <a href="' . $index_url . '" class="active">Home</a>';
  if(!$loggedin){
  echo '<a href="' . $login_url . '">Login</a>
  <a href="' . $signup_url . '">Signup</a>';}
  if($loggedin){
  echo '<a href="' . $logout_url . '">Logout</a>';}
  echo '<a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a>
</div>';
?>
<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>

</body>
</html>