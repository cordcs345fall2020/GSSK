<?php

// Check login
function user_login($email, $password){
    global $db;
    $password = salt_password($password);
    $sql = "SELECT email, password FROM user WHERE email = ? AND password = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();
    return ($stmt->num_rows == 1) ? true : false;
    $stmt->close();
    $db->close();   
}

function user_exists($email){
    global $db;
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    return ($stmt->num_rows > 0) ? true : false;
    $stmt->close();
    $db->close();    
}

function register($email, $password, $first_name, $last_name){
    global $db;
    $password = salt_password($password);
    $sql = "INSERT INTO user (`id`,`email`,`password`,`first_name`,`last_name`) VALUES (NULL, ?,?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ssss", $email, $password, $first_name, $last_name);
    return (!user_exists($email) && $stmt->execute()) ? true : false;
    $stmt->close();
    $db->close();
}

function salt_password($password){
    return md5($password.sha1(md5($password)));
}

function generate_session($email){
    $date = new DateTime();
    return md5($email.sha1(md5(sha1($date->format('Y-m-d H:i:s')))));
}

function update_session($email, $update = false){
    global $db; 
    $session = ($update) ? generate_session($email) : NULL;
    $sql = "UPDATE `user` SET `session` = ? WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $session, $email);
    $stmt->execute();
    if($stmt->affected_rows === 1 && $update){
        $_SESSION['user'] = $session;
        return true;
    } else {
        session_unset();
        return false;
    }
}

function check_session($session) {
    global $db;
    $sql = "SELECT `session` FROM `user` WHERE `session` = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $session);
    $stmt->execute();
    $stmt->store_result();
    return ($stmt->num_rows === 1) ? true : false;
    $stmt->close();
    $db->close();
}

function get_email_session($session){
    global $db;
    $sql = "SELECT `email` FROM `user` WHERE `session` = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $session);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->store_result();
    if($stmt->fetch()){
        return $email;
    }
    $stmt->close();
    $db->close();    
}

function get_id_session($session){
    global $db;
    $sql = "SELECT `id` FROM `user` WHERE `session` = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $session);
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->store_result();
    if($stmt->fetch()){
        return $id;
    }
    $stmt->close();
    $db->close();    
}

function get_name_from_id($id){
    global $db;
    $sql = "SELECT `first_name`, `last_name` FROM `user` WHERE `id` = ? LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($first_name, $last_name);
    $stmt->store_result();
    if($stmt->fetch()){
        return "$first_name $last_name";
    }
    $stmt->close();
    $db->close();    
}

function get_email_from_id($id){
    global $db;
    $sql = "SELECT `email` FROM `user` WHERE `id` = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->store_result();
    if($stmt->fetch()){
        return "$email";
    }
    $stmt->close();
    $db->close();    
}

function get_id_from_email($email){
    global $db;
    $sql = "SELECT `id` FROM `user` WHERE `email` = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id);
    $stmt->store_result();
    if($stmt->fetch()){
        return $id;
    }
    $stmt->close();   
}


?>