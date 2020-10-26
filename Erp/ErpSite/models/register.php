<?php

require 'connDB.php';

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

?>