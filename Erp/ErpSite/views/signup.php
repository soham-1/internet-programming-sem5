<?php

$dir = explode('htdocs\\', dirname(dirname(__FILE__)), 2)[1];
$basedir = explode('htdocs\\', dirname($dir))[0];

if ($_POST['username']) {
    include '../models/register.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $group = $_POST['group'];

    $status = register($username, $password, $email, $group);

    if ($status[0]==200) {
        switch($group) {
            case 'siteAdmin':
                {
                    $url = $dir . "/templates/adminHome.html";
                    header('Location: /'.$url);
                    break;
                }
            case 'retailer':
                {
                    $url = $basedir . "/Retailer/templates/retailHome.html";
                    header('Location: /'.$url);
                    break;
                }
            case 'enduser':
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