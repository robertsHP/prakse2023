<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    include 'data.php';

    $id = null;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $row = CRUDFunctions::read($tableName, $idColumnName, $id);
?>


<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>

        <div class="main-container">
            <h4>Statusa informācija</h4>
            <table class="table table-hover">
                <tr>
                    <th>ID: </th>
                    <th><?php echo $row[$idColumnName] ?></th>
                </tr>
                <tr>
                    <th>Nosaukums: </th>
                    <th><?php echo $row['name'] ?></th>
                </tr>
            </table>
            <form method="post" action="">
                <input type="submit" name="back" value="Atpakaļ" class="btn btn-primary execution-button">
            </form>
        </div>
    </body>
</html>
