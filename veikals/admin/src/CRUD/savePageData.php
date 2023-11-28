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
        // echo '<p>baalssss</p>';
        if (isset($_POST['tempFormData']) && isset($_POST['data'])) {
            $tempFormData = $_POST['tempFormData'];
            $data = $_POST['data'];

            //Pievieno visas formu vērtības $data masīvam
            for ($i = 0; $i < count($tempFormData); $i++) {
                $name = $tempFormData[$i]['name'];
                $value = $tempFormData[$i]['value'];
                $data['form-data'][$name]['value'] = $value;
            }

            // echo '<p>'.print_r($data).'</p>';

            $tempFiles = [];

            $hasErrors = CRUDFunctions::loopAndProcessFormData($tempFiles, $data);

            if(!$hasErrors) {
                // echo '<p>'.print_r($data).'</p>';
                $filesUploaded = CRUDFunctions::loopAndMoveTempFiles(
                    $data['table-name'], 
                    $tempFiles, 
                    $data['form-data']);
                if($filesUploaded) {
                    if($data['db-process-type'] === 'create') {
                        $response['success'] = Database::insert(
                            $data['table-name'], 
                            $data['form-data']);
                    } else if ($data['db-process-type'] === 'update') {
                        $response['success'] = Database::update(
                            $data['table-name'], 
                            $data['id-column-name'], 
                            $id,
                            $data['form-data']);
                    }
                }
            }
            $response['errorTags'] = $data['error-tags'];
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);

?>