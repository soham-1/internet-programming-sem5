<?php

$dir = explode('htdocs\\', dirname(dirname(__FILE__)), 2)[1];
$basedir = explode('htdocs\\', dirname($dir))[0];

if ($_POST) {
    // require '../models/register.php';
    require '../models/connDB.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $group = $_POST['group'];
    function register($username, $password, $email, $group) {
        global $conn;
        try {
            $groupsql = "SELECT `id` FROM `groups` where 1";
            // $result = mysqli_query($conn, $groupsql);
            $result = $conn->query($groupsql);
            $row = $result->fetch_row();
            $usersql = "INSERT INTO `user`(`username`, `password`, `email`, `groups`) VALUES ('$username', '$password', '$email', 1)";
            // $usersql = "SELECT `id` FROM `groups` where `group_name` = `$group`";
            $result = $conn->query($usersql);          
            return array(200, "account created successfully");
        } catch(Execption $e) {
            return array(500, $e->getMessage());
        }
    }
    $status = register($username, $password, $email, $group);



    if ($status[0]==200) {
        switch($group) {
            case 'admin':
                {
                    $url = $dir . "/templates/adminHome.html";
                    header('Location: /'.$url);
                    break;
                }
            case 'customer':
                {
                    $url = $basedir . "/Retailer/templates/retailHome.html";
                    header('Location: /'.$url);
                    break;
                }
            case 'shop':
                {
                    $url = $basedir . "/Enduser/templates/enduserHome.html";
                    header('Location: /'.$url);
                    break;
                }
        }
    } else if ($status[0]==500) {
        echo $status[1];
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
    <form action="./signup.php" method="post">
        username
        <input type="text" name="username" id="username">
        password
        <input type="text" name="password" id="password">
        email
        <input type="text" name="email" id="email">
        group
        <select name="group" id="group">
            <option value="admin">admin</option>
            <option value="shop">shop</option>
            <option value="customer">customer</option>
        </select>
        <button type="submit">submit</button>
    </form>
</body>
</html>