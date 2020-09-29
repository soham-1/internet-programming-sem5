<?php

require 'connDB.php';

function get_user($username) {
    global $conn;
    try {
        $sql = "SELECT * FROM users where username = '$username' LIMIT 1 ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $tp = get_group($username);
            while ($row = $result->fetch_row()) {
                $currentUser = $row[0];
                $userGroup = get_group($username);
                return array($currentUser, $userGroup);
            };
        } else {
            echo "in get user else";
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
            echo "in get group else";
            return $row[1];
        };
}
    catch(Exception $e) {
        echo "ERROR ! \n cause of error: "  .$e->getMessage();
    }
}

?>