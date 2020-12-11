<?php 

include '../app_start.php';

header('Content-Type: application/json');

$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

insert_message((int)$data['from'], (int)$data['to'], $data['message']);

echo json_encode(["success"=>true]);
?>