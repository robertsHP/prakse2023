
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/TagLoader.php';
    include 'rowLoader.php';

    //Iegūst produktu datus
    $originalData = $data;
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/products/data.php';
    $productsData = $data;
    $data = $originalData;

    $rowCount = 1;
?>

<div style="overflow-y: scroll; height:300px;">
    <table class="table table-hover" id="editable-table">
        <thead class="thead-custom">
            <tr>
                <th></th>
                <th>ID</th>
                <?php
                    foreach ($productsData['form-data'] as $column)
                        if (isset($column['title']))
                            echo '<th>'.$column['title'].'</th>';
                    echo '<th></th>';
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                if($originalData['id'] != null) {
                    $rows = null;
                    try {
                        $conn = Database::openConnection();
    
                        $stmt = $conn->prepare(
                            "SELECT * FROM products WHERE product_id IN (SELECT product_id FROM purchased_goods WHERE order_id=:id);"
                        );
                        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
                        $stmt->execute();
                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        Database::closeConnection($conn);

                        if(count($rows) != 0) {
                            $tempProductsData = $productsData;
                            $keys = array_keys($rows[0]);
                            
                            foreach ($rows as $row) {
                                $tempProductsData['id'] = $row[$tempProductsData['id-column-name']];
                                foreach ($tempProductsData['form-data'] as $key => &$var) {
                                    $var['value'] = $row[$key];
                                }
                                loadRow($tempProductsData, $keys, $rowCount);
                                $rowCount++;
                            }
                        }
                    } catch (PDOException $exception) {
                        echo "PDO Exception: " . $exception->getMessage();
                        echo "Error Code: " . $exception->getCode();
                    }
    
                }
                include 'loadAddRowButton.php';
            ?> 
        </tbody>
    </table>
</div>