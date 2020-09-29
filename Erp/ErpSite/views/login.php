<?php

$dir = explode('htdocs\\', dirname(dirname(__FILE__)), 2)[1]; // refers to ErpSite folder
$basedir = explode('htdocs\\', dirname($dir))[0]; // refers to Erp folder

if ($_POST['username']) {
    require '../models/handleAuth.php';
    $userArray = get_user($_POST['username']);
    echo $userArray[0];

    switch($userArray[1]) {
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
        default:
            echo "in default";
        
    }
}

?>