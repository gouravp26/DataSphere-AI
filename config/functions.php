<?php

function sanitize($data){

    return htmlspecialchars(trim($data));

}

function redirect($location){

    header("Location: $location");

    exit();

}

function isLoggedIn(){

    return isset($_SESSION['user_id']);

}