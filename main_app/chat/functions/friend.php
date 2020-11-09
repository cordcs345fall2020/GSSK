<?php

// $a and $b represents two user ID's
function add_friend($a, $b){
    // Friends will show up as a request 
    // If $a sends a request to $b this will need confirmed before being added to friend list
    global $db;
    $sql = "INSERT INTO friend (`id`,`a`,`b`,`friends`,`added`) VALUES (NULL,?,?,0,current_timestamp())";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $a, $b);
    return (!friend_exist($a, $b) && $stmt->execute()) ? true : false;
    $stmt->close();
    $db->close();
}

function remove_friend($a, $b){
    global $db;
    $sql = "SELECT id FROM friend WHERE (a = ? AND b = ?) OR (a = ? AND b = ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("iiii", $a, $b, $b, $a);
    $stmt->execute(); 
    $stmt->bind_result($id);
    $stmt->store_result();
    if($stmt->fetch()) { 
        $sql1 = "DELETE FROM `friend` WHERE `id`=?";
        $stmt2 = $db->prepare($sql1); 
        echo $db->error;
        $stmt2->bind_param("i", $id);
        return ($stmt2->execute()) ? true : false;
        $stmt2->close();
    }
    $stmt->close();
    $db->close();
}

function friend_exist($a, $b){
    global $db;
    $sql = "SELECT a, b FROM friend WHERE (a = ? AND b = ?) OR (a = ? AND b = ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("iiii", $a, $b, $b, $a);
    $stmt->execute();
    $stmt->store_result();
    return ($stmt->num_rows > 0) ? true : false;
    $stmt->close();
    $db->close();
}

function deleteFriend($id){
    global $db;
    $sql = "DELETE FROM `friend` WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return ($stmt->affected_rows === 1) ? true : false;
    $stmt->close();
    $db->close();
}

function approveFriend($id){
    global $db;
    $sql = "UPDATE `friend` SET `friends` = 1 WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return ($stmt->affected_rows === 1) ? true : false;
    $stmt->close();
    $db->close();
}

// Decision will be a 1 or 0 
// 1 being accepted and 0 to delete
function friend_update_decision($a, $b, $decision){
    global $db;
    $sql = "SELECT id FROM friend WHERE (a = ? AND b = ?) OR (a = ? AND b = ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("iiii", $a, $b, $b, $a);
    $stmt->execute(); 
    $stmt->bind_result($id);
    $stmt->store_result();
    if($stmt->fetch()) { 
        $sql1 = "UPDATE `friend` SET `friends`=? WHERE `id`=?";
        $stmt2 = $db->prepare($sql1); 
        echo $db->error;
        $stmt2->bind_param("ii", $decision, $id);
        return ($stmt2->execute()) ? true : false;
        $stmt2->close();
    }
    $stmt->close();
    $db->close();
}

function get_friends($id){
    global $db;
    $sql = "SELECT friend.id, friend.a, friend.b, CONCAT(user.first_name, ' ', user.last_name) AS 'AName', CONCAT(u2.first_name, ' ', u2.last_name) AS 'BName', user.email AS 'AEmail', u2.email AS 'BEmail' FROM friend INNER JOIN user ON user.id = friend.a INNER JOIN user u2 ON u2.id = friend.b WHERE (a = ? OR b = ?) AND friend.friends = '1'";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $id, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        $data[] = $row;
    }
    $stmt->close();
    return (!empty($data)) ? $data : array();  
}

function get_requests($id){
    global $db;
    $sql = "SELECT friend.id, friend.a, friend.b, CONCAT(user.first_name, ' ', user.last_name) AS 'AName', CONCAT(u2.first_name, ' ', u2.last_name) AS 'BName', user.email AS 'AEmail', u2.email AS 'BEmail' FROM friend INNER JOIN user ON user.id = friend.a INNER JOIN user u2 ON u2.id = friend.b WHERE (a = ? OR b = ?) AND friend.friends = '0'";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $id, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        $data[] = $row;
    }
    $stmt->close();
    return (!empty($data)) ? $data : array();    
}

?>