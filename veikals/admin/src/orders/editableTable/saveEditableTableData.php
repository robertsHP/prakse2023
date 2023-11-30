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
        'success' => false,
        'errorTags' => []
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productsData = json_decode($_POST['^data'], true);
        unset($_POST['^data']);

        $purchGoodsData = json_decode($_POST['^purchGoodsData'], true);
        unset($_POST['^purchGoodsData']);

        $formData = [];
        foreach ($_POST as $key => $value) {
            // echo '<p>'.$value. '</p>';
            if(!str_contains($key, '^'))
                $formData[$key] = $value;
        }
        foreach ($_FILES as $key => $value) {
            // echo '<p>'.$value. '</p>';
            if(!str_contains($key, '^'))
                $formData[$key] = $value;
        }

        // echo '<p>'.print_r($formData). '</p>';
        // echo '<p>'.print_r($productsData). '</p>';

        $hasErrors = CRUDFunctions::assignAndProcessFormData($formData, $productsData);

        // echo '<p>'.print_r($productsData). '</p>';

        if(!$hasErrors) {
            if($productsData['id'] == null) {
                $orderID = $productsData['order_id'];
                $productsTableName = $productsData['table-name'];
                $productsIdColumnName = $productsData['id-column-name'];

                

                // echo '<p>'.$productsTableName. '</p>';
                // echo '<p>'.$productsTableName. '</p>';
                // echo '<p>'.$productsIdColumnName. '</p>';
            } else {

            }
        }
        
        // echo '<p>'.print_r($productsData). '</p>';
        // echo '<p>'.print_r($purchGoodsData). '</p>';
    }

    // header('Content-Type: application/json');
    // echo json_encode($response);
?>