<?php

// start session
session_start();
ob_start();

// Define consts
define("URL", "");
define("SITE", "Chat Application");

// Require all files
require_once('connect.php');
require_once('auth.php');
require_once('chat.php');
require_once('friend.php');
require_once('helper.php');
require_once('encrypt.php');


$key = "vR5sH6gZ7sK6bD6m";

function encrypt($content) {
	$aes = new EasyAESCrypt('****************', 128, '################');
	return $aes->encrypt($content);
}
 
function decrypt($content) {
	$aes = new EasyAESCrypt('****************', 128, '################');
	return $aes->decrypt($content);
}
