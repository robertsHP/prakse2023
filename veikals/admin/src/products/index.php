<?php 
    $redirect = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUDTable.php';
?>

<!DOCTYPE html>
<html lang="en">  
    <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/head.php'; ?>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/header.php'; ?>
        <div class="main-container">
            <h4>Produkti</h4>
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
                        'ID' => 'product_id',
                        'Nosaukums' => 'name',
                        'Cena' => 'price',
                        'Pieejamais daudzums' => 'available_amount',
                        'Kategorija' => ['category_id', 'product_category', 'name']
                    ],
                    'DBTableName' => 'product'
                ]); 
            ?>
        </div>
    </body>
</html>