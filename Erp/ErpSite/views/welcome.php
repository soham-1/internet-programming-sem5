<?php
  session_start();
  if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit;
  }
  require '../models/connDB.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/sidebar_style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </head>
  <style>

.topnav {
  overflow: hidden;
  background-color: rgb(25,39,59);
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 20px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #4CAF50;
  color: white;
}

.topnav-right {
  float: right;
}
.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

/* The dropdown container */
.dropdown {
  overflow: hidden;
  float:left;
}
/* dropdown css */
 .dropdown .dropbtn {
  font-size: 16px;
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;} /* Important for vertical align on mobile phones
  margin: 0; /* Important for vertical align on mobile phones
}

/*  Dropdown content (hidden by default)*/
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}


.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

/* Add a grey background color to dropdown links on hover */
.dropdown-content a:hover {
  background-color: #ddd;
}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}
    </style>

  <body>
  <?php
  if(implode($_SESSION['group_name'])=='shop'){
    echo '<div class="topnav">
    <div class="topnav-right">
      <div class="dropdown">
      <button class="dropbtn"><i class="fas fa-user"></i>
        <i class="fa fa-caret-down"></i>
      </button>
      <div class="dropdown-content">
        <a href="profile.php"><i class="fas fa-user-circle"></i>My Profile</a>
        <a href="chnge_pwd.php"><i class="fas fa-cog"></i>Settings</a>
        <br>
        <a href="logout.php"><i class="fas fa-power-off"></i>Logout</a>
      </div>
    </div>
    <a href="alt_home.php">Shop</a>
    </div>

  </div>';
  $profile_set = $conn->query("select shop_id from shop where shop_owner='{$_SESSION['user_id']}' limit 1");
  if ($profile_set->num_rows<=0) {
    echo '<div class="btn">
      <span class="fas fa-bars" style="margin-left: 0px;"></span>
      </div>
      <nav class="sidebar">
      <a href="alt_home.php"><div class="text">LOCCO ERP</div></a>
      <ul>
        <li><a href="profile.php">first set your profile</a></li>
      </ul>
      </nav>';
  } else {
      echo'
      <div class="btn">
        <span class="fas fa-bars" style="margin-left: 0px;"></span>
      </div>
      <nav class="sidebar">
      <a href="alt_home.php"><div class="text">LOCCO ERP</div></a>
      <ul>
      <li><a href="add_inventory.php">Add Product</a></li>
      <li>
                <a href="#" class="serv-btn">Payment
                  <span class="fas fa-caret-down second"></span>
                </a>
                <ul class="serv-show">
      <li><a href="pending_payments.php?user=shop">Pending Payments</a></li>
      <li><a href="payments.php?user=shop">All Payments</a></li>
      </ul>
      </li>
      <li><a href="inventory.php">Inventory</a></li>
      <li>
        <a href="#" class="serv-btn">Sales Report
          <span class="fas fa-caret-down second"></span>
        </a>
        <ul class="serv-show">
          <li><a href="report.php?type=category">category wise</a></li>
          <li><a href="report.php?type=sale">sales</a></li>
        </ul>
      </li>
      <li><a href="contact_us.php">Feedback</a></li>
      </ul>
      </nav>';
        }
  }
elseif(implode($_SESSION['group_name'])=='customer'){
  echo'
    <div class="topnav">
      <div class="topnav-right">
        <a href="alt_home.php">home</a>
        <div class="dropdown">
        <button class="dropbtn"><i class="fas fa-user"></i>
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
          <a href="cust_profile.php"><i class="fas fa-user-circle"></i>My Profile</a>
          <a href="chnge_pwd.php"><i class="fas fa-cog"></i>Settings</a>
          <br>
          <a href="logout.php"><i class="fas fa-power-off"></i>Logout</a>
        </div>
      </div>
      <a href="cart.php"><i class="fas fa-shopping-cart"></i>Cart<sup>'.$_SESSION['cart'].'</sup></a>
      </div>
    </div>';
  $profile_set = $conn->query("select customer_id from customer where customer_id='{$_SESSION['user_id']}' limit 1");
  if ($profile_set->num_rows<=0) {
    echo '<div class="btn">
        <span class="fas fa-bars" style="margin-left: 0px;"></span>
        </div>
        <nav class="sidebar">
        <a href="alt_home.php"><div class="text">LOCCO ERP</div></a>
        <ul>
          <li><a href="cust_profile.php">first set your profile</a></li>
        </ul>
        </nav>';
  } else {
    echo '
      <div class="btn">
        <span class="fas fa-bars"></span>
      </div>
      <nav class="sidebar">
      <a href="alt_home.php"><div class="text">LOCCO ERP</div></a>
      <ul>
        <li class="active"><a href="my_orders.php">My Orders</a></li>
          <li>
            <a href="#" class="serv-btn">Payment
              <span class="fas fa-caret-down second"></span>
            </a>
            <ul class="serv-show">
              <li><a href="pending_payments.php?user=customer">Pending Payments</a></li>
              <li><a href="payments.php?user=customer">All Payment</a></li>
            </ul>
        </li>
        <li><a href="#"></a></li>
        <li><a href="shopping.php">Shop by Category</a></li>
        <li><a href="contact_us.php">Feedback</a></li>
      </ul>
      </nav>';
    }
  }
else{
  echo'
  <div class="topnav">

  <div class="topnav-right">

    <div class="dropdown">
    <button class="dropbtn"><i class="fas fa-user"></i>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="#"><i class="fas fa-user-circle"></i>My Profile</a>
      <a href="#"><i class="fas fa-cog"></i>Settings</a>
      <br>
      <a href="logout.php"><i class="fas fa-power-off"></i>Logout</a>
    </div>
  </div>
  <a href="alt_home.php">Admin info</a>
  </div>
</div>

    <div class="btn">
      <span class="fas fa-bars"></span>
    </div>
<nav class="sidebar">
<a href="welcome.php"><div class="text">LOCCO ERP</div></a>
<ul>
<li>
          <a href="#" class="feat-btn">users
            <span class="fas fa-caret-down first"></span>
          </a>
          <ul class="feat-show">
<li><a href="admin_user.php?type=shop">Shops</a></li>
<li><a href="admin_user.php?type=customer">Customers</a></li>
</ul>
</li>
<li>
  <a href="#" class="serv-btn">Feedback
    <span class="fas fa-caret-down second"></span>
  </a>
  <ul class="serv-show">
    <li><a href="feedback_list.php">List</a></li>
    <li><a href="feedback_analysis.php">analysis</a></li>
  </ul>
</li>
</ul>
</nav>';}

  ?>

<script>
      $(document).ready(function(){
        $('.btn').click(function(){
          $('.items').toggleClass("show");
          $('ul li').toggleClass("hide");
        });
      });
    </script>
<script>
    $('.btn').click(function(){
      $(this).toggleClass("click");
      $('.sidebar').toggleClass("show");
    });
      $('.feat-btn').click(function(){
        $('nav ul .feat-show').toggleClass("show");
        $('nav ul .first').toggleClass("rotate");
      });
      $('.serv-btn').click(function(){
        $('nav ul .serv-show').toggleClass("show1");
        $('nav ul .second').toggleClass("rotate");
      });
      $('nav ul li').click(function(){
        $(this).addClass("active").siblings().removeClass("active");
      });
    </script>

  </body>
</html>
