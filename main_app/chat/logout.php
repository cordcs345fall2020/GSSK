<?php

include_once 'templates/header.php';

if((check_session($_SESSION['user']) && update_session(get_email_session($_SESSION['user']))) || !isset($_SESSION['user'])){
    redirect("login");
}

?>