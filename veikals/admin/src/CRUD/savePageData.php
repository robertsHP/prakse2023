<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/VariableHandler.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    // Create an associative array to hold variables
    $response = array(
        'success' => false,
        'errorTags' => []
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode($_POST['-data'], true);
        unset($_POST['-data']);
        $formData = [];

        foreach ($_POST as $key => $value) {
            $formData[$key] = $value;
        }
        foreach ($_FILES as $key => $value) {
            $formData[$key] = $value;
        }

        $hasErrors = CRUDFunctions::assignAndProcessFormData($formData, $data);
        if(!$hasErrors) {
            if($data['db-process-type'] === 'create') {
                $response['success'] = Database::insert(
                    $data['table-name'], 
                    $data['form-data']);
            } else if ($data['db-process-type'] === 'update') {
                $response['success'] = Database::update(
                    $data['table-name'], 
                    $data['id-column-name'], 
                    $data['id'],
                    $data['form-data']);
            }
        }
        $response['errorTags'] = $data['error-tags'];
    }
    // echo '<p>'.print_r($_FILES['photo_file_loc']).'</p>';
    // echo '<p>'.print_r($data['form-data']).'</p>';

    // header('Content-Type: application/json');
    // echo json_encode($response);
?>