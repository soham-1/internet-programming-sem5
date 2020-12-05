<!DOCTYPE html>
<html lang="en">

<?php 
    $dir = explode('htdocs\\', dirname(dirname(__FILE__)), 2)[1]; // refers to user folder
    $basedir = explode('htdocs\\', dirname($dir))[0]; // refers to Erp folder
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmCmocdc-FcRhLg4bxhzuAca9jXJ3mGSo&callback=initMap&libraries=&v=weekly"
      defer
    ></script> -->
    <?php require 'welcome.php'; ?>
    <?php include('../models/connDB.php'); ?>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/profile.css">
    <title>ERP</title>
</head>
<?php 
$email; $picture; $address; $phone_no; $shop;

    function get_user_details() {
        global $conn, $picture, $address, $phone_no, $shop, $email;
        $email = $conn->query("Select email from user where user_id = " . $_SESSION['user_id'] . " limit 1")->fetch_row()[0];

        $shop_exists = $conn->query("select * from shop where shop_owner='{$_SESSION['user_id']}' limit 1");
        if ($shop_exists->num_rows>0) {
            $shop = $shop_exists->fetch_row();  
        } else {
            $shop = array_fill(1,5,"");
        }
        $address_exists = $conn->query("Select * from address where user_id='{$_SESSION['user_id']}' limit 1");
        if ($address_exists->num_rows > 0) {
            $address = $address_exists->fetch_row();
        } else {
            $address = array_fill(1,5, "");
        }
        $phone_no = $conn->query("Select phone_no from phone_no where user_id = " . $_SESSION['user_id']);
    }

    if (count($_POST)>0 && isset($_POST['email'])) {
        // $phone_no_array = array();
        // foreach ($_POST as $key => $val){
        //     if (is_numeric($val)) {
        //         array_push($phone_no_array, $val);
        //     }
        // }
        // if (count($phone_no_array) > 0) {
        //     foreach ($phone_no_array as $key => $val) {
        //         $result = $conn->query("select * from phone_no where user_id='{$_SESSION['user_id']}' and phone_no='{$val}'");
        //         if ($result->num_rows>0) {
        //             $conn->query("update phone_no set phone_no='{$val}' where user_id='{$_SESSION['user_id']}'");
        //         } else {
        //             $conn->query("inset into phone_no(phone_no, where user_id) values('{$val}', '{$_SESSION['user_id']}')");
        //         }
        //     }
        // }
        if ($_FILES['profile_picture']['tmp_name'] != "") {
            $res = $conn->query("Select shop_id from shop where shop_owner = " . $_SESSION['user_id'] . " limit 1");
            $imgData = addslashes(file_get_contents($_FILES['profile_picture']['tmp_name']));
            $imageProperties = getimageSize($_FILES['profile_picture']['tmp_name']);
            if ($res->num_rows > 0) {
                $sql = "Update shop set picture='{$imgData}' where shop_owner='{$_SESSION['user_id']}'";
                $conn->query($sql);
            }
            else {
                $sql = "INSERT INTO shop(shop_id,picture)
                        VALUES('{$_SESSION['user_id']}', '{$imgData}')";
                $conn->query($sql);
            }
        }
        $conn->query("update user set email='{$_POST['email']}' where user_id='{$_SESSION['user_id']}'");
    }
    if (count($_POST)>0 && isset($_POST['building'])) {
        $sql = "Update shop set shop_name='{$_POST['shop_name']}', category='{$_POST['category']}' where shop_owner='{$_SESSION['user_id']}'";
        $conn->query($sql);
        $res = $conn->query("select * from address where user_id='{$_SESSION['user_id']}'");
        if ($res->num_rows > 0) {
            $sql = "update address set blg='{$_POST['building']}', lane='{$_POST['lane']}',
                    landmark='{$_POST['landmark']}', city='{$_POST['city']}', pincode='{$_POST['pincode']}' 
                    where user_id='{$_SESSION['user_id']}' ";
            $conn->query($sql);
        } else {
            $sql = "Insert into address(user_id, blg, lane, landmark, city, pincode)"."
                    values('{$_SESSION['user_id']}', '{$_POST['building']}', '{$_POST['lane']}', '{$_POST['landmark']}', '{$_POST['city']}', '{$_POST['pincode']}')";
            $conn->query($sql);
        }
        echo "<script>alert('details updated')</script>";
    }

?>
<body>
    <?php get_user_details(); ?>

    <div class="container">
        <div class="side-section col-lg-3 col-md-6 col-sm-12">
            <form enctype="multipart/form-data" name="updateForm" action="profile.php" method="post" id="side-form">
                <div class="profile-image">
                    <?php
                        if(isset($shop[5]))
                            echo '<img src="data:image/png;charset=utf8;base64,' . base64_encode($shop[5]) . '" class="rounded-img" />';
                        else
                            echo '<img src="css/defaultS.png" class="rounded-img" />';
                    ?>
                    <i class="fa fa-camera fa-3x" id="camera-icon" aria-hidden="true"></i>
                    <input type="file" name="profile_picture" id="profile-upload" style="visibility:hidden;">
                    <div class="row" style="visibility:hidden;"></div>
                </div>
                <!-- <div id="mapholder">map</div> -->
                <div class="row">
                    <label for="email" class="detail-field values" id="email">email id</label>
                    <input type="text" class="detail-field values" id="email-val" name="email" value=<?php echo $email; ?>>
                </div>
                <?php
                    $count=1;
                    while ($row=$phone_no->fetch_assoc()) {
                        echo '<div class="row">
                                <label for="email" class="detail-field values" id="email">phone_no '.$count.'</label>
                                <input type="text" class="detail-field " id="email-val1" name="'.(string)$count.'" value="'.$row['phone_no'].'" >
                            </div>';
                        $count += 1;
                    }
                ?>
                <button class="bsbtn btn-success" id="form-btn" type="submit">update</button>
            </form>
        </div>

        <div class="form-section col-lg-7 col-md-6 col-sm-12">
            <form name="updateForm" action="profile.php" method="post" id="main-form">
                <div class="details">
                    <div class="header">
                        <h2><?php echo $shop[2]; ?></h2>
                    </div>
                    <div class="row">
                        <label for="owner" class="detail-field">shop name</label>
                        <input type="text" class="detail-field values" id="shop_name" name="shop_name" value=<?php echo $shop[2]; ?>>
                    </div>
                    <div class="row">
                        <label for="owner" class="detail-field">shop owner</label>
                        <input type="text" class="detail-field values" id="owner" name="owner" value=<?php echo $_SESSION['username']; ?>  disabled>
                    </div>
                    <div class="row">
                        <label for="reg_no" class="detail-field">registration no.</label>
                        <input type="text" class="detail-field values" id="reg_no" name="reg_no" value=<?php echo $shop[1]; ?> disabled>
                    </div>
                    <div class="row">
                        <label for="category" class="detail-field">category</label>
                        <input type="text" class="detail-field values" id="category" name="category" value=<?php echo $shop[4]; ?>>
                    </div>
                    <div class="row">
                        <label for="owner" class="detail-field">building</label>
                        <input type="text" class="detail-field values" id="building" name="building" value="<?php echo $address[1]; ?>" required >
                    </div>
                    <div class="row">
                        <label for="reg_no" class="detail-field">lane</label>
                        <input type="text" class="detail-field values" id="lane" name="lane" value="<?php echo $address[2]; ?>" required >
                    </div>
                    <div class="row">
                        <label for="category" class="detail-field">landmark</label>
                        <input type="text" class="detail-field values" id="landmark" name="landmark" value="<?php echo $address[3]; ?>" required >
                    </div>
                    <div class="row">
                        <label for="category" class="detail-field">city</label>
                        <input type="text" class="detail-field values" id="city" name="city" value="<?php echo $address[4]; ?>" required >
                    </div>
                    <div class="row">
                        <label for="category" class="detail-field">pincode</label>
                        <input type="text" class="detail-field values" id="pincode" name="pincode" value="<?php echo $address[5]; ?>" required >
                    </div>
                </div>
                <button class="bsbtn btn-success" id="form-btn" type="submit">save</button>
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
        $('#camera-icon').bind("click", function () {
            $("#profile-upload").trigger("click");
        });
</script>
</html>