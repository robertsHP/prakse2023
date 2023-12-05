
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/TagLoader.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['productsData']) && isset($_POST['rowCount'])) {
            $data = $_POST['productsData'];
            $rowCount = $_POST['rowCount'];

            $rows = Database::getAllRowsFrom($data['table-name']);
            $keys = array_keys($rows[0]);

            include 'rowLoader.php';
            loadEditableRow($data, $keys, $rowCount);
        }
    }
    // header('Content-Type: application/json');
    // echo json_encode($response);
?>