<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    include 'data.php';

    CRUDFunctions::delete(
        $tableName, 
        $idColumnName);
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>
        
        <div class="main-container">
            <h4>Vai tiešām vēlaties dzēst ierakstu?</h4>

            <form method="post" action="">
                <input type="submit" name="back" value="Atpakaļ" class="btn btn-primary execution-button">
                <input type="submit" name="delete" value="Dzēst" class="btn btn-danger execution-button">
            </form>
        </div>
    </body>
</html>