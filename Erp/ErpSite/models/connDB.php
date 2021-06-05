<?php

// development
$host = "db";
$username = "root";
$password = "rootpswd";
$db = "ErpDb";

$conn = new mysqli($host, $username, $password, $db);

if ($conn->connect_error) {
    die("connection failed" . $conn->connect_error);
}

?>