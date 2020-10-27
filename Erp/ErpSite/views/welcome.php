<?php

session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
  header("location: login.php");
  exit;
}

?>

<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- Somehow I got an error, so I comment the title, just uncomment to show -->
    <!-- <title>Sidebar Menu with sub-menu | CodingNepal</title> -->
    <link rel="stylesheet" href="css/sidebar_style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </head>
  <body>
    <div class="btn">
      <span class="fas fa-bars"></span>
    </div>
<nav class="sidebar">
      <div class="text">
Side Menu</div>
<ul>
<li class="active"><a href="#">Dashboard</a></li>
<li>
          <a href="#" class="feat-btn">Features
            <span class="fas fa-caret-down first"></span>
          </a>
          <ul class="feat-show">
<li><a href="#">Pages</a></li>
<li><a href="#">Elements</a></li>
</ul>
</li>
<li>
          <a href="#" class="serv-btn">Services
            <span class="fas fa-caret-down second"></span>
          </a>
          <ul class="serv-show">
<li><a href="#">App Design</a></li>
<li><a href="#">Web Design</a></li>
</ul>
</li>
<li><a href="#">Portfolio</a></li>
<li><a href="#">Overview</a></li>
<li><a href="#">Shortcuts</a></li>
<li><a href="#">Feedback</a></li>
</ul>
</nav>
    <div class="content">
    <h4 class="alert-heading">Welcome!  <?php echo $_SESSION['username'] ?> </h4>
    <p class="mb-0">Whenever you need to, Logout <a href="logout.php">using this link.</a></p>

</div>
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
