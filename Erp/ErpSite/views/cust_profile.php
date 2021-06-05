<?php
    require 'welcome.php';
    require '../models/connDB.php';
    require 'includeCDN.php';
?>
<!DOCTYPE html>
<html lang="en">
<!-- profile page for customer, same logic used as profile.php -->
<head>   
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/profile.css">
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

$email; $picture; $address; $phone_no;

    function get_user_details() {
        global $conn, $picture, $address, $phone_no, $email;
        $picture = $conn->query("Select picture from customer where customer_id = " . $_SESSION['user_id'] . " limit 1")->fetch_row();
        $email = $conn->query("Select email from user where user_id = " . $_SESSION['user_id'] . " limit 1")->fetch_row()[0];
        $address = $conn->query("Select * from address where user_id = " . $_SESSION['user_id'] . " limit 1")->fetch_row();
        $phone_no = $conn->query("Select phone_no from phone_no where user_id = " . $_SESSION['user_id'])->fetch_row();
        
        if ($picture) {
            $picture = $picture[0];
        }
        if (!$address) {
            $address = array_fill(1,5, "");
        }
        $phone_no = $conn->query("Select phone_no from phone_no where user_id = " . $_SESSION['user_id']);
    }

    if (count($_POST)>0 && isset($_POST['new_email'])) {
        $phone_no_array = array();
        foreach ($_POST as $key => $val){
            if (is_numeric($val) || $val=="") {
                array_push($phone_no_array, $val);
            }
        }
        $phone_flag=true;
        $phone_flag1=true;
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
        if ($_FILES['profile_picture']['tmp_name'] != "") {
            $res = $conn->query("Select customer_id from customer where customer_id = " . $_SESSION['user_id'] . " limit 1");
            $imgData = addslashes(file_get_contents($_FILES['profile_picture']['tmp_name']));
            $imageProperties = getimageSize($_FILES['profile_picture']['tmp_name']);
            if ($res->num_rows > 0) {
                $sql = "Update customer set picture='{$imgData}' where customer_id='{$_SESSION['user_id']}'";
                $conn->query($sql);
            }
            else {
                $sql = "INSERT INTO customer(customer_id,picture)
                        VALUES('{$_SESSION['user_id']}', '{$imgData}')";
                $conn->query($sql);
            }
        }
        $old_email = $_POST['old_email'];
        $new_email = $_POST['new_email'];
        $email_exist = false;
        $email_flag=true;
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

    if (count($_POST)>0 && isset($_POST['building'])) {
        $res = $conn->query("Select user_id from address where user_id='{$_SESSION['user_id']}' limit 1");
        $details_flag=true;
        if ($res->num_rows > 0 && is_numeric($_POST['pincode'])) {
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
    get_user_details()
?>
<body>
    <div class="container">
        <div class="side-section col-lg-3 col-md-6 col-sm-12">
            <form enctype="multipart/form-data" name="sideForm" action="cust_profile.php" method="post">
                <div class="profile-image">
                    <?php
                        if(isset($picture))
                            echo '<img src="data:image/png;charset=utf8;base64,' . base64_encode($picture) . '" class="rounded-img" />';
                        else
                            echo '<img src="css/defaultC.png" class="rounded-img" >';
                    ?>
                    <i class="fa fa-camera fa-3x" id="camera-icon" aria-hidden="true"></i>
                    <input type="file" name="profile_picture" id="profile-upload" hidden>
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

        <div class="form-section col-lg-7 col-md-6 col-sm-12">
            <form name="mainForm" action="cust_profile.php" method="post">
                <div class="details">
                    <div class="header">
                        <h2><?php echo $_SESSION['username']; ?></h2>
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