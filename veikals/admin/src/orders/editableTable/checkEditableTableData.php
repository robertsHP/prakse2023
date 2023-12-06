<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/VariableHandler.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    $response = array(
        'name' => 'editable-table',
        'success' => false,
        'rowNumber' => isset($_POST['^rowNumber']) ? $_POST['^rowNumber'] : null,
        'productsData' => []
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productsData = json_decode($_POST['^productsData'], true);
        unset($_POST['^productsData']);

        $purchGoodsData = json_decode($_POST['^purchGoodsData'], true);
        unset($_POST['^purchGoodsData']);

        $productsData['id'] = $_POST['product_id'];
        unset($_POST['product_id']);

        $rowNumber = isset($_POST['^rowNumber']) ? $_POST['^rowNumber'] : null;
        unset($_POST['^rowNumber']);

        $productFormData = [];
        $purchGoodsFormData = [];

        foreach ($_POST as $key => $value) {
            if(array_key_exists($key, $productsData['form-data'])) {
                $productFormData[$key] = $value;
            } else {
                $purchGoodsFormData[$key] = $value;
            }
        }
        foreach ($_FILES as $key => $value) {
            if(!str_contains($key, '^')) {
                if($productsData['db-process-type'] == 'create') {
                    $productFormData[$key] = $value;
                } else if ($productsData['db-process-type'] == 'update') {
                    $oldPathEmpty = $productsData['form-data'][$key] == '' || empty($productsData['form-data'][$key]);
                    $newFilePathEmpty = $value['name'] == '' || empty($value['name']);

                    if (!$newFilePathEmpty || ($newFilePathEmpty && $oldPathEmpty)) {
                        $productFormData[$key] = $value;
                    }
                }
            }
        }

        $hasErrors = CRUDFunctions::assignAndProcessFormData($productFormData, $productsData);
        $hasErrors = CRUDFunctions::assignAndProcessFormData($purchGoodsFormData, $purchGoodsData);

        $response['success'] = !$hasErrors;
        $response['productsData'] = $productsData;
        $response['purchGoodsData'] = $purchGoodsData;
        $response['rowNumber'] = $rowNumber;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>