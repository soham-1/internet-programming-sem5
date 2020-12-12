<?php

// development
// $host = "localhost";
// $username = "root";
// $password = "";
// $db = "ErpDb";

// production
$host = "remotemysql.com";
$username = "GWp5WvpzQw";
$password = "Fcsz9IwNzq";
$db = "GWp5WvpzQw";

$conn = new mysqli($host, $username, $password, $db);

if ($conn->connect_error) {
    die("connection failed" . $conn->connect_error);
}

?>