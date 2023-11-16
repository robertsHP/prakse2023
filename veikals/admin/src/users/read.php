<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUDFunctions.php';

    include 'data.php';

    $id = null;
    $pageTitle = null;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $pageTitle = "Lietotāja informācija";
    } else if (isset($_SESSION["id"])) {
        $id = $_SESSION["id"];
        $pageTitle = "Konts";
    }

    $row = CRUDFunctions::read($tableName, $idColumnName, $id);
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>

        <div class="main-container">
            <h4><?php echo $pageTitle; ?></h4>
            <table class="table table-hover">
                <tr>
                    <th>ID: </th>
                    <th><?php echo $row['user_id'] ?></th>
                </tr>
                <tr>
                    <th>Vārds: </th>
                    <th><?php echo $row['name'] ?></th>
                </tr>
                <tr>
                    <th>Uzvārds: </th>
                    <th><?php echo $row['surname'] ?></th>
                </tr>
                <tr>
                    <th>E-pasts: </th>
                    <th><?php echo $row['email'] ?></th>
                </tr>
            </table>
            <form method="post" action="">
                <input type="submit" name="back" value="Atpakaļ" class="btn btn-primary execution-button">
            </form>
        </div>
    </body>
</html>