<?php

require 'connDB.php';

function get_user($username, $password) {
    global $conn;
    try {
        $sql = "SELECT * FROM `users` where `username` = '$username' and `password` = '$password' LIMIT 1 ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_row()) {
                $currentUser = $row[0];
                $userGroup = get_group($username);
                return array($currentUser, $userGroup);
            };
        } else {
            return false;
        }
    }
    catch(Exception $e) {
        echo "ERROR ! \n cause of error: "  .$e->getMessage();
    }
}

function get_group($username) {
    global $conn;
    try {
        $sql = "SELECT * FROM usergroups where username = '$username' LIMIT 1 ";
        $result = $conn->query($sql);
        while ($row = $result->fetch_row()) {
            return $row[2];
        };
}
    catch(Exception $e) {
        echo "ERROR ! \n cause of error: "  .$e->getMessage();
    }
}

?>