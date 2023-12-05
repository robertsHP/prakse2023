
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/TagLoader.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';

    require_once 'editableTableFunctions.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['productsData']) && isset($_POST['rowCount'])) {
            $data = json_decode($_POST['productsData'], true);
            $rowCount = json_decode($_POST['rowCount']);
            $id = json_decode($_POST['id']);

            $rows = Database::getAllRowsFrom($data['table-name']);
            $keys = array_keys($rows[0]);

            if($id != null) {
                $row = getProductRow($id);
                populateDataWithRow($data, $row);
            }

            loadEditableRow($data, $keys, $rowCount);
        }
    }
?>