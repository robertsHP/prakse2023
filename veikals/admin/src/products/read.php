<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUDFunctions.php';

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
                    <th><?php echo $row['category_id'] ?></th>
                </tr>
                <tr>
                    <th>Nosaukums: </th>
                    <th><?php echo $row['name'] ?></th>
                </tr>
                <tr>
                    <th>Apraksts: </th>
                    <th><?php echo $row['description'] ?></th>
                </tr>
                <tr>
                    <th>Bilde: </th>
                    <th>
                        <img 
                            src="<?php 
                                if(isset($row['photo_file_loc']))
                                    echo $row['photo_file_loc'];
                            ?>" 
                            name="photo_file_loc"
                            id="photo_file_loc"
                            class="img-thumbnail img-product-photo" 
                            alt="">
                    </th>
                </tr>
                <tr>
                    <th>Cena: </th>
                    <th><?php echo $row['price'] ?></th>
                </tr>
                <tr>
                    <th>Pieejamais daudzums: </th>
                    <th><?php echo $row['available_amount'] ?></th>
                </tr>
                <tr>
                    <th>Kategorija: </th>
                    <th>
                        <?php 
                            $catRow = Database::getRowWithID(
                                'product_category', 
                                'category_id', 
                                $row['category_id']);
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
