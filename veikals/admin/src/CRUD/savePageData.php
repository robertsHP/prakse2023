<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/VariableHandler.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    $response = array(
        'orderID' => null,
        'success' => false,
        'postResponse' => null
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode($_POST['data'], true);

        $response['orderID'] = $data['id'];
        if($data['db-process-type'] == 'create') {
            $response['postResponse'] = CRUDFunctions::insertAndPOST($data);
            $response['orderID'] = $data['id'];
            $response['success'] = true;
        } else if ($data['db-process-type'] == 'update') {
            Database::update(
                $data['table-name'], 
                $data['id-column-name'], 
                $data['id'],
                $data['form-data']);
            $response['success'] = true;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>