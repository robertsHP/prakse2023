<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDTable.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDOptions.php';

    include 'data.php';
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>
        <div class="main-container">
            <h4>Preces</h4>
            <?php 
                CRUDOptions::load();
                CRUDTable::load(
                    [
                        'ID' => $idColumnName,
                        'Numurs' => 'number',
                        'Klients' => ['client_id', 'clients', 'name'],
                        'Datums' => 'date',
                        'Cena' => 'total_price',
                        'Pasūtījuma statuss' => ['state_id', 'order_states', 'name']
                    ],
                    $tableName
                );
            ?>
        </div>
    </body>
</html>