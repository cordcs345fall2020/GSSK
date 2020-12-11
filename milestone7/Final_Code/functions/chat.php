<?php

function get_messages($id, $friend, $limit = 1, $offset = 0){
    global $db; 
    global $key;
    $sql = "SELECT * FROM `messages` WHERE `to` = ? AND `from` = ? OR `from`=? AND `to` =? LIMIT ?, ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("iiiiii", $id, $friend, $id, $friend, $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        $data[] = array(
            "id"=>$row['id'],
            "from"=>$row['from'],
            "to"=>$row['to'],
            "status"=>$row['status'],
            "message"=>decrypt($row['message'], $key),
            "sent"=>$row['sent']
        );
    }
    $stmt->close();
    return (!empty($data)) ? $data : array();
}

function insert_message(Int $from, Int $to, String $message){
    global $db;
    global $key;
    //$sql = "INSERT INTO `messages` (`id`, `from`, `to`, `message`, `status`, `sent`) VALUES (NULL, ?, ?, ?, 0, CURRENT_TIMESTAMP())";
    $sql = "INSERT INTO `messages` (`id`, `from`, `to`, `message`, `status`, `sent`) VALUES (NULL, ?, ?, ?, '0', current_timestamp());";
    $stmt = $db->prepare($sql);
    $message = encrypt($message, $key);
    $stmt->bind_param("iis", $from, $to, $message);
    $stmt->execute();
}

?>