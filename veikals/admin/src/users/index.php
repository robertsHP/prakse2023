<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUDTable.php';

    include 'data.php';
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>
        <div class="main-container">
            <h4>Lietotāji</h4>
            <div class="option-container">
                <a class="link-button" href="create.php">
                    <button type="button" class="btn btn-primary">
                        Pievienot jaunu
                    </button>
                </a>
            </div>
            <?php 
                CRUDTable::outputIndexTable([
                    'columns' => [
                        'ID' => $idColumnName,
                        'Vārds' => 'name',
                        'Uzvārds' => 'surname',
                        'E-pasts' => 'email'
                    ],
                    'DBTableName' => $tableName
                ]); 
            ?>
        </div>
    </body>
</html>