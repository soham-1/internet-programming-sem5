<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php require 'welcome.php'; ?>
    <?php include('../models/connDB.php'); ?>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/profile.css">
    <title>ERP</title>
</head>
<?php 
$email; $picture; $address; $phone_no; $group; $shop;

    function get_user_details() {
        global $conn, $picture, $address, $phone_no, $group, $shop, $email;
        $sql = "Select group_name from groups where id = " . $_SESSION['group_id'];
        $group = $conn->query($sql)->fetch_row();

        if ($group[0]=='customer') {
            $picture = $conn->query("Select picture from customer where customer_id = " . $_SESSION['user_id'] . " limit 1")->fetch_row();
            $email = $conn->query("Select email from user where user_id = " . $_SESSION['user_id'] . " limit 1")->fetch_row()[0];
            $address = $conn->query("Select * from address where user_id = " . $_SESSION['user_id'] . " limit 1")->fetch_row();
            $phone_no = $conn->query("Select phone_no from phone_no where user_id = " . $_SESSION['user_id'])->fetch_row();
        }
        elseif($group[0]=='shop'){
            $shop = $conn->query("Select * from shop where shop_owner = " . $_SESSION['user_id'] . " limit 1")->fetch_row();
            $email = $conn->query("Select email from user where user_id = " . $_SESSION['user_id'] . " limit 1")->fetch_row()[0];
            $address = $conn->query("Select * from address where user_id = " . $_SESSION['user_id'] . " limit 1")->fetch_row();
            $phone_no = $conn->query("Select phone_no from phone_no where user_id = " . $_SESSION['user_id'])->fetch_row();
        }
        
    }

    if (count($_POST)>0) {
        $sql = "UPDATE shop SET reg_no=".$_POST['reg-no'].", category=".$_POST['category']." WHERE shop_owner=" . $_SESSION['user_id'];
        if ($conn->query($sql)==TRUE) {
            $response = array(
                "status_code" => 200,
                "message" => "updates were made successfully !"
            );
            echo json_encode($response);
            http_response_code(200);
        }
        else {
            http_response_code(502);
        }
    }

?>
<body>
    <?php get_user_details(); ?>

    <div class="container">
        <div class="side-section col-lg-3 col-md-6 col-sm-12">
            <form name="updateForm" action="profilp" method="post">
                <div class="profile-image">
                    <?php
                        if($group[0]=='shop' && isset($shop[5]))
                            echo '<img src="data:image/png;charset=utf8;base64,' . base64_encode($shop[5]) . '" class="rounded-img" />';
                        elseif($group[0]=='customer' && isset($picture))
                            echo '<img src="data:image/png;charset=utf8;base64,' . base64_encode($picture) . '" />';
                    ?>      
                </div>
                <div id="mapholder">map</div>
                <div class="row">
                    <label for="email" class="detail-field values" id="email">email id</label>
                    <input type="text" class="detail-field values" id="email" name="email" value=<?php echo $email; ?>>
                </div>
            <form name="updateForm" action="profilp" method="post">
        </div>

        <div class="form-section col-lg-7 col-md-6 col-sm-12">
            <form name="updateForm" action="profilp" method="post">
                <div class="details">
                    <div class="header">
                        <h2><?php echo $shop[2]; ?></h2>
                    </div>
                    <div class="row">
                        <label for="owner" class="detail-field">shop owner</label>
                        <input type="text" class="detail-field values" id="owner" name="owner" value=<?php echo $_SESSION['username']; ?>>
                    </div>
                    <div class="row">
                        <label for="reg-no" class="detail-field">registration no.</label>
                        <input type="text" class="detail-field values" id="reg-no" name="reg-no" value=<?php echo $shop[1]; ?>>
                    </div>
                    <div class="row">
                        <label for="category" class="detail-field">category</label>
                        <input type="text" class="detail-field values" id="category" name="category" value=<?php echo $shop[4]; ?>>
                    </div>
                </div>
                <button class="btn btn-success" id="form-btn" type="submit">save</button>
            </form>
        </div>
    </div>

    
</body>
<script type="text/javascript">
        //  function showLocation(position) {
        //     var latitude = position.coords.latitude;
        //     var longitude = position.coords.longitude;
        //     var latlongvalue = position.coords.latitude + ","
        //     + position.coords.longitude;
        //     var img_url = "https://maps.googleapis.com/maps/api/staticmap?center="
        //     +latlongvalue+"&amp;zoom=14&amp;size=400x300&amp;key=AIzaSyAmCmocdc-FcRhLg4bxhzuAca9jXJ3mGSo";
        //     document.getElementById("mapholder").innerHTML =
        //     "<img src='"+img_url+"'>";
        //  }
        //  function errorHandler(err) {
        //     if(err.code == 1) {
        //        alert("Error: Access is denied!");
        //     } else if( err.code == 2) {
        //        alert("Error: Position is unavailable!");
        //     }
        //  }
        //  function getLocation(){
        //     if(navigator.geolocation){
        //        // timeout at 60000 milliseconds (60 seconds)
        //        var options = {timeout:60000};
        //        navigator.geolocation.watchPosition(showLocation, errorHandler, options);
        //     } else{
        //        alert("Sorry, browser does not support geolocation!");
        //     }
        //  }
        //  getLocation();

        $(function () {

            $('form').on('submit', function (e) {

            e.preventDefault();

            $.ajax({
                type: 'post',
                data: $('form').serialize(),
                success: function (response) {
                    alert(response);
                    let res = $.parseJSON(response)
                    if (res.status_code==200){
                        alert('updates were made !');
                    }
                },
                error: function (error) {
                    alert("some error occured");
                }
            });

            });

        });
</script>
</html>