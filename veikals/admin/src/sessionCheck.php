<?php
    //$redirect = ...

    if(session_status() === PHP_SESSION_NONE) {
        session_start();

        // if (empty($_SESSION['token'])) {
        //     $_SESSION['token'] = bin2hex(random_bytes(32));
        // }
        // $token = $_SESSION['token'];

        if(!isset($_SESSION["id"])) {
            header('Location: '.$redirect);
            exit();
        }
    }
?>