<?php 
    session_start();

    if(!isset($_SESSION["id"])) {
        header('Location: '.$_SERVER['DOCUMENT_ROOT'].'/veikals/admin/index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php
            include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php';
        ?>
        <h1>USERS</h1>
    </body>
</html>