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
        <div class="container">
            <h4>Your dashboard</h4>
            <div class="search-container">
                <select class="super-users">
                    <option selected disabled> * Super Users</option>
                </select>
                <button type="button" class="panel-button btn btn-primary">Manage</button>
            </div>
            <div class="sub-container">
                <h4>Quicklinks</h4>
                <div id="quicklinks">
                    <div class="quicklink"><a href="/veikals/admin/src/users/index.php">Lietotāji</a></div>
                </div>
            </div>
        </div>
    </body>
</html>