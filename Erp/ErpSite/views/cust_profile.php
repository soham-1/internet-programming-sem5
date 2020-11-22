<!DOCTYPE html>
<html lang="en">

<?php 
    $dir = explode('htdocs\\', dirname(dirname(__FILE__)), 2)[1]; // refers to user folder
    $basedir = realpath($_SERVER['DOCUMENT_ROOT']) . '/Erp/Erp'; // refers to Erp folder
    require 'includeCDN.php';
    require 'welcome.php';
    require '../models/connDB.php';
?>

<head>
    <!-- <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmCmocdc-FcRhLg4bxhzuAca9jXJ3mGSo&callback=initMap&libraries=&v=weekly"
      defer
    ></script> -->
    
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/profile.css">
</head>
<?php 

$email; $picture; $address; $phone_no; $group;

    function get_user_details() {
        global $conn, $picture, $address, $phone_no, $group, $email;
        $sql = "Select group_name from groups where id = " . $_SESSION['group_id'];
        $group = $conn->query($sql)->fetch_row();
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
    }

    if (count($_POST)>0 && isset($_POST['email'])) {
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
        
        $conn->query("Update user set email='{$_POST['email']}' where user_id='{$_SESSION['user_id']}'");

        echo "<script>alert('profile updated')</script>";
    }

    if (count($_POST)>0 && isset($_POST['building'])) {
        $res = $conn->query("Select user_id from address where user_id='{$_SESSION['user_id']}' limit 1");
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
                <div id="mapholder">map</div>
                <div class="row">
                    <label for="email" class="detail-field values" id="email">email id</label>
                    <input type="text" class="detail-field values" id="email" name="email" value=<?php echo $email; ?>>
                </div>
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