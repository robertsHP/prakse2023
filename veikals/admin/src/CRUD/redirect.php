<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
        if (isset($_POST['redirectPath'])) {
            header('Location: '.$_POST['redirectPath']);
            exit();
        }
    }
?>