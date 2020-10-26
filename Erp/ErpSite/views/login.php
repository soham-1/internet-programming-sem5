<?php
$dir = explode('htdocs\\', dirname(dirname(__FILE__)), 2)[1]; // refers to ErpSite folder
$basedir = explode('htdocs\\', dirname($dir))[0]; // refers to Erp folder
session_start();

if ($_POST) {
    require '../models/handleAuth.php';
    $userArray = get_user($_POST['username'], $_POST['password']);
    if ($userArray) {
        $_SESSION['login_user'] = $_POST['username'];
        switch($userArray[1]) {
            case 'admin':
                {
                    $url = $dir . "/views/adminHome.html";
                    header('Location: /'.$url);
                    break;
                }
            case 'shop':
                {
                    $url = $basedir . "/Retailer/views/retailHome.html";
                    header('Location: /'.$url);
                    break;
                }
            case 'customer':
                {
                    $url = $basedir . "/Enduser/views/enduserHome.html";
                    header('Location: /'.$url);
                    break;
                }
            default:
                echo "in default";
            
        }
    }else {
        echo "<script>alert('wrong username or password');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP</title>
</head>
<body>
    <form action="" method="post">
        username
        <input type="text" name="username" id="username">
        password
        <input type="text" name="password" id="password">
        <button type="submit">submit</button>
    </form>
</body>
</html>