<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/VariableHandler.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    // Create an associative array to hold variables
    $response = array(
        'name' => 'page',
        'success' => false,
        'rowNumber' => isset($_POST['^rowNumber']) ? $_POST['^rowNumber'] : null,
        'data' => []
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode($_POST['^data'], true);
        unset($_POST['^data']);

        $formData = [];
        foreach ($_POST as $key => $value) {
            // echo '<p>'.$key.' = '.print_r(($value)).'</p>';
            if(!str_contains($key, '^')) {
                if($data['db-process-type'] == 'create') {
                    $formData[$key] = $value;
                } else if ($data['db-process-type'] == 'update') {
                    $oldPathEmpty = $data['form-data'][$key] == '' || empty($data['form-data'][$key]);
                    $newFilePathEmpty = $value == '' || empty($value) || $value == null;

                    if (!$newFilePathEmpty || ($newFilePathEmpty && $oldPathEmpty)) {
                        $formData[$key] = $value;
                    }
                }
            }
        }
        foreach ($_FILES as $key => $value) {
            if(!str_contains($key, '^')) {
                if($data['db-process-type'] == 'create') {
                    $formData[$key] = $value;
                } else if ($data['db-process-type'] == 'update') {
                    $oldPathEmpty = $data['form-data'][$key] == '' || empty($data['form-data'][$key]);
                    $newFilePathEmpty = $value['name'] == '' || empty($value['name']);

                    if (!$newFilePathEmpty || ($newFilePathEmpty && $oldPathEmpty)) {
                        $formData[$key] = $value;
                    }
                }
            }
        }

        $hasErrors = CRUDFunctions::assignAndProcessFormData($formData, $data);

        $response['success'] = !$hasErrors;
        $response['data'] = $data;
    }
    // echo '<p>'.print_r($_FILES['photo_file_loc']).'</p>';
    // echo '<p>DATA === '.print_r($data).'</p><bt>';
    // echo '<p>RESPONSE === '.print_r($response).'</p><br>';

    header('Content-Type: application/json');
    echo json_encode($response);
?>