<?php

include '../app_start.php';

header('Content-Type: application/json');

$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

$last_id = $data['last_id'];

$messages = get_messages($data['id'], $data['friend'], 100000000);
$messages = array_slice($messages, (int)$last_id);

echo json_encode($messages);
?>