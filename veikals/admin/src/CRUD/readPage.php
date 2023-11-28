<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Pārbauda vai back poga nospiesta
        if (isset($_POST['back'])) {
            header('Location: index.php');
            exit();
        }
    }

    $tableName = $data['table-name'];
    $idColumnName = $data['id-column-name']; 
    $id = $data['id'];

    $row = Database::getRowWithID($tableName, $idColumnName, $id);
    
    if(empty($row)) {
        header('Location: index.php');
        exit();
    }
    return $row;    
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>

        <div class="main-container">
            <h4><?php echo $pageTitle; ?></h4>
            <?php 
                displayData($data['id-column-name'], $data['form-data'], $row); 
            ?>
            <form method="post" action="">
                <input type="submit" name="back" value="Atpakaļ" class="btn btn-primary execution-button">
            </form>
        </div>
    </body>
</html>
