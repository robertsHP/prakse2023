<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/VariableHandler.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    function assignToFormData (&$arr, &$formData) {
        foreach ($arr as $key => $value) {
            $formData[$key] = $value;
        }
    }

    // Create an associative array to hold variables
    $response = array(
        'item_id' => null,
        'success' => false,
        'rowNumber' => isset($_POST['^rowNumber']) ? $_POST['^rowNumber'] : null,
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode($_POST['^data'], true);
        unset($_POST['^data']);

        $formData = [];
        foreach ($_POST as $key => $value) {
            if(!str_contains($key, '^'))
                $formData[$key] = $value;
        }
        foreach ($_FILES as $key => $value) {
            if(!str_contains($key, '^'))
                $formData[$key] = $value;
        }

        $hasErrors = CRUDFunctions::assignAndProcessFormData($formData, $data);
        if(!$hasErrors) {
            if($data['db-process-type'] === 'create') {
                $insertedRowID = Database::insert(
                    $data['table-name'], 
                    $data['form-data']);
                $success = ($insertedRowID == null) ? false : true;
                $response['success'] = $success;
            } else if ($data['db-process-type'] === 'update') {
                $response['success'] = Database::update(
                    $data['table-name'], 
                    $data['id-column-name'], 
                    $data['id'],
                    $data['form-data']);
            }
        }
        $response['data'] = $data;
    }
    // echo '<p>'.print_r($_FILES['photo_file_loc']).'</p>';
    // echo '<p>DATA === '.print_r($data).'</p><bt>';
    // echo '<p>RESPONSE === '.print_r($response).'</p><br>';

    header('Content-Type: application/json');
    echo json_encode($response);
?>