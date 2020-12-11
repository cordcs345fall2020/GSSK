<?php

$host = "localhost";
$user = "sachirki_sachin";
$pass = "C,gh8u{mCax[";
$database = "sachirki_chat";

$db = new mysqli($host, $user, $pass, $database);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

?>
