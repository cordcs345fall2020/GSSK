<?php

function redirect($page, $status = 303){
    if((empty($page))){
        $page = "index";
    }
    header("Location: " . URL . $page . '.php', true, $status);
    die();
}
