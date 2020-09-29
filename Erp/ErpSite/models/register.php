<?php

require_once('connDB.php');

function register($username, $password, $email, $group) {
    global $conn;
    try {
        $usersql = "INSERT INTO `users`(`username`, `password`, `email`) VALUES ('$username', '$password', '$email')";
        if (check_group($group)) {
            if ($conn->query($usersql)) {
                $groupsql = "INSERT INTO `usergroups`(`username`, `groups`) VALUES ('$username', '$group')";
                $result = $conn->query($groupsql);
                // $result->execute();
                return array(200, "account created successfully");
            }
        }
    } catch(Execption $e) {
        return array(500, $e->getMessage());
    }
}

function check_group($group) {
    global $conn;
    $sql = "SELECT * FROM `groups` WHERE name = '$group' LIMIT 1";
    $result = $conn->query($sql);
    try {
        if ($result->num_rows > 0) {
            return true;
        }
    } catch(Exception $e) {
        return false;
    }
}

?>