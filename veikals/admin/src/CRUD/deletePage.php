<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    include 'data.php';

    CRUDFunctions::setID($data);

    $tableName = $data['table-name'];
    $idColumnName = $data['id-column-name']; 
    $id = $data['id'];

    //Ja nav nekas tad veic redirect uz index
    if(empty(Database::getRowWithID($tableName, $idColumnName, $id))) {
        header('Location: index.php');
        exit();
    }

    //Formas pogu funkcijas
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Pārbauda vai delete poga nospiesta
        if (isset($_POST['delete'])) {
            Database::deleteWithID($tableName, $idColumnName, $id);
            header('Location: index.php');
        //Pārbauda vai back poga nospiesta
        } else if (isset($_POST['back'])) {
            header('Location: index.php');
        }
        exit();
    }

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