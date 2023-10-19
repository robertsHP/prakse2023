<?php 
    session_start();

    if(!isset($_SESSION["id"])) {
        header('Location: /veikals/admin/index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include 'head.php'; ?>
    <body>
        <?php
            include 'header.php';
        ?>
    </body>
</html>