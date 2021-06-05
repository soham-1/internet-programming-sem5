<?php
    require 'welcome.php';
    require '../models/connDB.php';
    require 'includeCDN.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>

.outer-container{
    display: flex;
    align-items: center;
    /* justify-content: center; */
    min-height: 60vh;
    overflow: hidden;
    background-image: linear-gradient(15deg, rgb(10,193,236) 0%, rgb(86,203,143) 100%);
}
body {
  font-family: Arial, Helvetica, sans-serif;
}
h3{
    float:center;
    text-align:center;
    margin-top:15px;
}
/* Float four columns side by side */
.column {
  float: left;
  width: 25%;
  padding: 0 10px;
  margin-bottom:15px;
}

/* Remove extra left and right margins, due to padding */
.row {margin-top:20px ;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #ffffff;

  color:black;
  height:200px;
}
.text{
float:center;
text-align:center;
}
.video{
    float:right;
    margin-top:30px;
    margin-right:20px;
}
footer p {
    background-color:rgb(26,30,37);
    padding: 20px 0;
    text-align: center;
    color:white;
    margin-top:10px;
}

footer img {
    width: 44px;
}
</style>
</head>
<body>
<div class=outer-container>
<div class="col-sm-12 col-md-6">
            <h1 style="float; color:white; margin-left:35px; margin-bottom:20px">Tools to learn</h1>
            <h3 class="text-justify" style="color:white;">Get access to dozens of free tools for client management, tasks and projects, customer support, internal communications and e-commerce.</h3>
          </div>
<iframe width="560" height="315" style="float:right;" src="https://www.youtube.com/embed/6qys-562kp4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>


<h3>CRM Facilities</h3>


<div class="row">
  <div class="column">
    <div class="card">
      <img src="css\cash-register-icon-png-17.jpg" style="width:20%">
      <h3>Pipeline management</h3>
      <p>Deal and sales pipeline management with unlimited pipelines.</p>
    </div>
  </div>

  <div class="column">
    <div class="card">
    <img src="css\analysis_img.jpg" style="width:20%">
      <h3>Indepth Analysis</h3>
      <p>Deal and sales pipeline management with unlimited pipelines.</p>
    </div>
  </div>

  <div class="column">
    <div class="card">
    <img src="css\two-color-catalogue.jpg" style="width:20%">
      <h3>Product Catalog</h3>
      <p>Deal and sales pipeline management with unlimited pipelines.</p>
    </div>
  </div>

  <div class="column">
    <div class="card">
    <img src="css\support-20-512.png" style="width:20%">
      <h3>Email Assistance</h3>
      <p>Deal and sales pipeline management with unlimited pipelines.</p>
    </div>
  </div>
</div>
<div class="row">
  <div class="column">
    <div class="card">
    <img src="css\wide_rch.jpg" style="width:20%">
      <h3>Wide reach</h3>
      <p>Deal and sales pipeline management with unlimited pipelines.</p>
    </div>
  </div>

  <div class="column">
    <div class="card">
    <img src="css\pay.png" style="width:20%">
      <h3>Online payments</h3>
      <p>Deal and sales pipeline management with unlimited pipelines.</p>
    </div>
  </div>

  <div class="column">
    <div class="card">
    <img src="css\notify.png" style="width:20%">
      <h3>Timely Notifications</h3>
      <p>Deal and sales pipeline management with unlimited pipelines.</p>
    </div>
  </div>

  <div class="column">
    <div class="card">
    <img src="css\icon_dark_salesautomation.png" style="width:20%">
      <h3>Sales Automation</h3>
      <p>Deal and sales pipeline management with unlimited pipelines.</p>
    </div>
  </div>
</div>
</div>

</body>
<footer>
        <p>Copyright &copy; 2020-2021 <img src="https://i.ibb.co/QDy827D/ak-logo.png" alt="logo"> All Rights Reserved.</p>
    </footer>
</html>