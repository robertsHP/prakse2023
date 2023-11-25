<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    $row = CRUDFunctions::read($tableName, $idColumnName, $id);
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>

        <div class="main-container">
            <h4><?php echo $pageTitle; ?></h4>
            <?php displayData($idColumnName, $data, $row); ?>
            <form method="post" action="">
                <input type="submit" name="back" value="Atpakaļ" class="btn btn-primary execution-button">
            </form>
        </div>
    </body>
</html>
