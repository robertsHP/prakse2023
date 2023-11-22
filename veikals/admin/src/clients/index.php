<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/elements/BasicFormTagLoader.php';

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
            <h4>Klienti</h4>
            <?php 
                CRUDOptions::load();
                CRUDTable::load(
                    [
                        'ID' => $idColumnName,
                        'Vārds/Nosaukums' => 'name',
                        'E-pasts' => 'email',
                        'Telefona numurs' => 'phone_number',
                        'Adrese' => 'adress'
                    ],
                    $tableName
                );
            ?>
        </div>
    </body>
</html>