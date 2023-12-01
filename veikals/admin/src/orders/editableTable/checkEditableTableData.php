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
        'data' => []
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productsData = json_decode($_POST['^data'], true);
        unset($_POST['^data']);

        $formData = [];
        foreach ($_POST as $key => $value) {
            if(!str_contains($key, '^'))
                $formData[$key] = $value;
        }

        foreach ($_FILES as $key => $value) {
            if(!str_contains($key, '^')) {
                // echo '<p>'.$key.' = '.print_r($value).'</p>';

                if($productsData['db-process-type'] == 'create') {
                    $formData[$key] = $value;
                } else if ($data['db-process-type'] == 'update') {
                    $oldPathEmpty = $productsData['form-data'][$key] == '' || empty($productsData['form-data'][$key]);
                    $newFilePathEmpty = $value['name'] == '' || empty($value['name']);

                    if (!$newFilePathEmpty || ($newFilePathEmpty && $oldPathEmpty)) {
                        $formData[$key] = $value;
                    }
                }
            }
        }

        $hasErrors = CRUDFunctions::assignAndProcessFormData($formData, $productsData);

        $response['success'] = !$hasErrors;
        $response['data'] = $productsData;
        $response['rowNumber'] = isset($_POST['^rowNumber']) ? $_POST['^rowNumber'] : null;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>