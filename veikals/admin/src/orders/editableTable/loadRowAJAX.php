
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/TagLoader.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';

    require_once 'editableTableFunctions.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['productsData']) && isset($_POST['rowCount'])) {
            $productsData = json_decode($_POST['productsData'], true);
            $rowCount = json_decode($_POST['rowCount']);
            $id = json_decode($_POST['id']);
            $orderID = json_decode($_POST['orderID']);

            include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/orders/data.php';

            $editable = true;
            if($id != null) {
                $row = getProductRow($id);
                populateProductDataWithRow($productsData, $row);
                if($orderID != null) {
                    populatePurchGoods($orderID, $id, $purchGoodsData);
                }
                $editable = false;
            }

            loadEditableRow($productsData, $purchGoodsData, $rowCount, $editable);
        }
    }
?>