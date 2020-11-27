<?php

$host = "localhost";
$user = "root";
$pass = "";
$database = "chat";

$db = new mysqli($host, $user, $pass, $database);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

?>
