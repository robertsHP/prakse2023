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
            <h4>Preču kategorijas informācija</h4>
            <table class="table table-hover">
                <tr>
                    <th>ID: </th>
                    <th><?php echo $row[$idColumnName] ?></th>
                </tr>
                <tr>
                    <th>Numurs: </th>
                    <th><?php echo $row['number'] ?></th>
                </tr>
                <tr>
                    <th>Klients: </th>
                    <th>
                        <?php 
                            $catRow = Database::getRowWithID(
                                'client', 
                                'client_id', 
                                $row['client']);
                            echo $catRow['name'];
                        ?>
                    </th>
                </tr>
                <tr>
                    <th>Date: </th>
                    <th><?php echo $row['date'] ?></th>
                </tr>
                <tr>
                    <th>Price: </th>
                    <th><?php echo $row['total_price'].' eiro' ?></th>
                </tr>
                <tr>
                    <th>Statuss: </th>
                    <th>
                        <?php 
                            $catRow = Database::getRowWithID(
                                'order_state', 
                                'state_id', 
                                $row['state_id']);
                            echo $catRow['name'];
                        ?>
                    </th>
                </tr>
            </table>
            <form method="post" action="">
                <input type="submit" name="back" value="Atpakaļ" class="btn btn-primary execution-button">
            </form>
        </div>
    </body>
</html>
