<?php 
    /*
        $tableName = ...
        $idColumnName = ...

        $pageTitle = ...
        $redirectPath = ...
        $columns = ...
        $data = []
    */

    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDTable.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDOptions.php';
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>
        <div class="main-container">
            <h4><?php echo $pageTitle; ?></h4>
            <?php 
                CRUDOptions::load();
                CRUDTable::load($columns, $data['table-name']);
            ?>
        </div>
    </body>
</html>