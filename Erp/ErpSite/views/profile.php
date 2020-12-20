<!DOCTYPE html>
<html lang="en">
<!-- profile page for shops -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
      /* Set the size of the div element that contains the map */
      #map {
        width: 30%;
        /* The width is the width of the web page */
      }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php require 'welcome.php'; ?>
    <?php include('../models/connDB.php'); ?>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/profile.css">
    <title>ERP</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfwUiO930s5L_dYjM3L10rSKLcXciNGEE&callback=initMap&libraries=&v=weekly"></script>
    <script>
      function writeAddressName(latLng) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
          "location": latLng
        },
        function(results, status) {
          if (status == google.maps.GeocoderStatus.OK)
            document.getElementById("address").innerHTML = results[0].formatted_address;
          else
            document.getElementById("error").innerHTML += "Unable to retrieve your address" + "<br />";
        });
      }

      function geolocationSuccess(position) {
        var userLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        // Write the formatted address
        writeAddressName(userLatLng);

        var myOptions = {
          zoom : 16,
          center : userLatLng,
          mapTypeId : google.maps.MapTypeId.ROADMAP
        };
        // Draw the map
        var mapObject = new google.maps.Map(document.getElementById("map"), myOptions);
        // Place the marker
        new google.maps.Marker({
          map: mapObject,
          position: userLatLng
        });
        // Draw a circle around the user position to have an idea of the current localization accuracy
        var circle = new google.maps.Circle({
          center: userLatLng,
          radius: position.coords.accuracy,
          map: mapObject,
          fillColor: '#0000FF',
          fillOpacity: 0.5,
          strokeColor: '#0000FF',
          strokeOpacity: 1.0
        });
        mapObject.fitBounds(circle.getBounds());
      }

      function geolocationError(positionError) {
        document.getElementById("error").innerHTML += "Error: " + positionError.message + "<br />";
      }

      function geolocateUser() {
        // If the browser supports the Geolocation API
        if (navigator.geolocation)
        {
          var positionOptions = {
            enableHighAccuracy: true,
            timeout: 10 * 1000 // 10 seconds
          };
          navigator.geolocation.getCurrentPosition(geolocationSuccess, geolocationError, positionOptions);
        }
        else
          document.getElementById("error").innerHTML += "Your browser doesn't support the Geolocation API";
      }

      window.onload = geolocateUser;
    </script>
    <style type="text/css">
      #map {
        width: 200px;
        height: 200px;
      }
    </style>
</head>
<?php
$email; $picture; $address; $phone_no; $shop;

    function get_user_details() { // sets the profile details
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
            $address = array_fill(1,8, "");
        }
        $phone_no = $conn->query("Select phone_no from phone_no where user_id = " . $_SESSION['user_id']);
    }

    if (count($_POST)>0 && isset($_POST['new_email'])) { // checks if side form is submitted
        $exist = $conn->query("Select shop_id from shop where shop_owner = " . $_SESSION['user_id'] . " limit 1");
        if ($exist->num_rows<=0) {  // checks if the shop name, etc are set or not, if not then doesn't allow to set profile picture
            echo "<script>alert('first fill in the shop details !')</script>";
        } else {
            $phone_no_array = array();
            foreach ($_POST as $key => $val){
                if (is_numeric($val) || $val=="") {
                    array_push($phone_no_array, $val); // gets all phone nos. from POST into variable
                }
            }
            $phone_flag=true; // check phone no. validity
            $phone_flag1=true; // checks if phone no is already registered into database
            if (count($phone_no_array) > 0) {
                $result = $conn->query("select * from phone_no where user_id='{$_SESSION['user_id']}'");
                $count1=0;
                while($row=$result->fetch_assoc()){
                    if (is_numeric($phone_no_array[$count1]) && strlen($phone_no_array[$count1])==10) {
                        $conn->query("update phone_no set phone_no='{$phone_no_array[$count1]}' where user_id='{$_SESSION['user_id']}' and phone_no='{$row['phone_no']}' ");
                        $count1++;
                    } else {
                        $phone_flag=false;
                    }
                }
                if (isset($phone_no_array[$count1]) && $phone_no_array[$count1]!="" && strlen($val)==10) {
                    $res = $conn->query("insert into phone_no(phone_no, user_id) values('{$phone_no_array[$count1]}', '{$_SESSION['user_id']}')");
                    if ($res==false) $phone_flag1=false;
                }
            }
            try{
                if ($_FILES['profile_picture']['tmp_name'] != "") {
                    $imgData = addslashes(file_get_contents($_FILES['profile_picture']['tmp_name'])); // gets image data into binary form
                    $imageProperties = getimageSize($_FILES['profile_picture']['tmp_name']);
                    $res = $conn->query("Select shop_id from shop where shop_owner = " . $_SESSION['user_id'] . " limit 1");
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
            } catch (Exception $e) {
                echo 'alert("we couldnt update your profile pic, please try again")' ;
            }
            $old_email = $_POST['old_email'];
            $new_email = $_POST['new_email'];
            $email_exist = false;
            $email_flag=true; // checks email validity
            if ($old_email!=$new_email) {
                $email_exist = $conn->query("select email from user where email='{$_POST['new_email']}'");
                if (filter_var($_POST['new_email'], FILTER_VALIDATE_EMAIL) && $email_exist->num_rows<=0) {
                    $conn->query("Update user set email='{$_POST['new_email']}' where user_id='{$_SESSION['user_id']}'");
                } else {
                    $email_flag=false;
                }
            }
            if ($phone_flag==false) {
                echo "<script>alert('wrong phone no !')</script>";
            } else if ($phone_flag1==false) {
                echo "<script>alert('phone no already registered')</script>";
            } else if ($email_exist==true && $email_exist->num_rows>0) {
                echo "<script>alert('email already registered')</script>";
            } else if ($email_flag==false) {
                echo "<script>alert('wrong email !')</script>";
            } else {
                echo "<script>alert('profile updated')</script>";
            }
        }
    }
    if (count($_POST)>0 && isset($_POST['building'])) { // checks if main form is submitted
        $shop_exist = $conn->query("select shop_name from shop where shop_owner='{$_SESSION['user_id']}'");
        $name_exist = $conn->query("select shop_name from shop where shop_name='{$_POST['shop_name']}'");
        $reg_exist = $conn->query("select shop_name from shop where reg_no='{$_POST['reg_no']}'");
        if ($shop_exist->num_rows>0) {
            $sql = "Update shop set shop_name='{$_POST['shop_name']}', category='{$_POST['category']}' where shop_owner='{$_SESSION['user_id']}'";
            $conn->query($sql);
        } else if ($name_exist->num_rows>0) {
            echo "<script>alert('shop name already exist')</script>";
        } else if ($reg_exist->num_rows>0) {
            echo "<script>alert('already registered')</script>";
        }else {
            $sql = "insert into shop(shop_name, category, reg_no, shop_owner) values('{$_POST['shop_name']}', '{$_POST['category']}', '{$_POST['reg_no']}', '{$_SESSION['user_id']}')";
            $conn->query($sql);
        }
        $res = $conn->query("select * from address where user_id='{$_SESSION['user_id']}'");
        $details_flag=true;
        if ($res->num_rows > 0  && is_numeric($_POST['pincode'])) {
            $sql = "update address set blg='{$_POST['building']}', lane='{$_POST['lane']}',
                    landmark='{$_POST['landmark']}', city='{$_POST['city']}', pincode='{$_POST['pincode']}'
                    where user_id='{$_SESSION['user_id']}' ";
            $conn->query($sql);
        } else if (is_numeric($_POST['pincode'])) {
            $sql = "Insert into address(user_id, blg, lane, landmark, city, pincode)"."
                    values('{$_SESSION['user_id']}', '{$_POST['building']}', '{$_POST['lane']}', '{$_POST['landmark']}', '{$_POST['city']}', '{$_POST['pincode']}')";
            $conn->query($sql);
        } else {
            $details_flag=false;
        }
        if ($details_flag==false) {
            echo "<script>alert('wrong info added')</script>";
        } else {
            echo "<script>alert('details updated')</script>";
        }
    }
?>
<body>
    <?php get_user_details(); ?>

    <div class="container col-sm-11">
        <div class="side-section col-lg-3 col-md-6 col-sm-10">
            <form enctype="multipart/form-data" name="updateForm" action="profile.php" method="post" id="side-form">
                <div class="profile-image">
                    <?php
                        if(isset($shop[5]) && $shop[5]!="")
                            echo '<img src="data:image/png;charset=utf8;base64,' . base64_encode($shop[5]) . '" class="rounded-img" />';
                        else
                            echo '<img src="css/defaultS.png" class="rounded-img" />';
                    ?>
                    <i class="fa fa-camera fa-3x" id="camera-icon" aria-hidden="true"></i>
                    <input type="file" name="profile_picture" id="profile-upload" style="visibility:hidden;">
                    <div class="row" style="visibility:hidden;"></div>
                </div>
                <div id="map"></div>
                <div class="row">
                    <label for="email" class="detail-field values" id="email">email id</label>
                    <input type="text" class="detail-field values" id="email-val" name="new_email" value=<?php echo $email; ?>>
                    <input type="hidden" class="detail-field values" id="email-val" name="old_email" value=<?php echo $email; ?>>
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
                    echo '<div class="row">
                                <label for="email" class="detail-field values" id="email">phone_no '.$count.'</label>
                                <input type="text" class="detail-field " id="email-val1" name="'.(string)$count.'" value="" >
                            </div>';
                ?>
                <button class="bsbtn btn-success" id="form-btn" type="submit">update</button>
            </form>
        </div>

        <div class="form-section col-lg-7 col-md-7 col-sm-11">
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
                        <input type="text" class="detail-field values" id="reg_no" name="reg_no" value="<?php echo $shop[1]; ?>">
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

        $('#camera-icon').bind("click", function () {
            $("#profile-upload").trigger("click");
        });
</script>
</html>