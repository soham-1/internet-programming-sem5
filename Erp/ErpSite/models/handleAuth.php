<?php

require 'connDB.php';

function get_user($username, $password) {
    global $conn;
    try {
        $sql = "SELECT * FROM `user` where `username` = '$username' and `password` = '$password' LIMIT 1 ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_row()) {
                $currentUser = $row[0];
                $sql1 = "SELECT * FROM `groups` where `id` = $row[4] LIMIT 1";
                $result1 = $conn->query($sql1);
                $row1 = $result1->fetch_row();
                $userGroup = $row1[0];
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

?>