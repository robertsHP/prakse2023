
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/TagLoader.php';
    include 'editableTableFunctions.php';

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
                <?php loadProductColumns($productsData['form-data']); ?>
            </tr>
        </thead>
        <tbody>
            <?php
                if($data['id'] != null) {
                    $rows = getOrderProducts($data['id']);

                    if(count($rows) != 0) {
                        $tempProductsData = $productsData;
                        
                        foreach ($rows as $row) {
                            populateProductDataWithRow($tempProductsData, $row);
                            if($data['id'] != null) {
                                populatePurchGoods($data['id'], $row['product_id'], $purchGoodsData);
                            }
                            loadEditableRow($tempProductsData, $purchGoodsData, $rowCount, false);
                            $rowCount++;
                        }
                    }
                }
                include 'loadAddRow.php';
            ?> 
        </tbody>
    </table>
</div>