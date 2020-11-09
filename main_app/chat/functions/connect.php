<?php

$host = "localhost:3306";
$user = "root";
$pass = "V6n2a9f8n7v1";
$database = "chat";

$db = new mysqli($host, $user, $pass, $database);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

?>
