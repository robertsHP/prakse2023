<?php 
    session_start();

    if(!isset($_SESSION["id"])) {
        header('Location: /veikals/admin/index.php');
        exit();
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>
        <div class="container">
            <h4 id="page-title">Rediģēt lietotāja informāciju</h4>
        </div>
    </body>
</html>