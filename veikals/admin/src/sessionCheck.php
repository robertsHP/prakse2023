<?php
    //$redirect = ...

    if(session_status() === PHP_SESSION_NONE) {
        session_start();

        if(!isset($_SESSION["id"])) {
            header('Location: '.$redirect);
            exit();
        }
    }
?>