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
    function ifPurchGoodsHasOrderWithThisProduct ($purchGoodsData) {
        $conn = Database::openConnection();
    
        $tableName = $purchGoodsData['table-name'];

        $stmt = $conn->prepare(
            "SELECT * FROM $tableName WHERE order_id=:order_id AND product_id=:product_id"
        );
        $stmt->bindParam(':order_id', $purchGoodsData['form-data']['order_id'], PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $purchGoodsData['form-data']['product_id'], PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        Database::closeConnection($conn);

        return !empty($result);
    }

    $response = array(
        'item_id' => null,
        'dbProcessType' => null,
        'success' => false,
        'rowNumber' => isset($_POST['^rowNumber']) ? $_POST['^rowNumber'] : null,
    );


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productsData = json_decode($_POST['^data'], true);
        unset($_POST['^data']);

        $purchGoodsData = json_decode($_POST['^purchGoodsData'], true);
        unset($_POST['^purchGoodsData']);

        $formData = [];
        foreach ($_POST as $key => $value) {
            if(!str_contains($key, '^'))
                $formData[$key] = $value;
        }
        foreach ($_FILES as $key => $value) {
            if(!str_contains($key, '^'))
                $formData[$key] = $value;
        }

        $hasErrors = CRUDFunctions::assignAndProcessFormData($formData, $productsData);

        //iziet cauri visiem produktiem kuriem ir orders_id
        //un atbilstoši veic darbības balstoties uz rezultātiem
        //1. ja nav tad CREATE
        //2. ja ir tad UPDATE

        if(!$hasErrors) {
            // $purchGoodsData['form-data']['order_id'] = $productsData['order_id'];
            // $productsIdColumnName = $productsData['id-column-name'];

            // //Situācijās kad vada pilnīgi no jauna tabulā
            // if($productsData['id'] == null) {
            //     //Ievieto datubāzē produktu 
            //     $insertedRowID = Database::insert(
            //         $productsData['table-name'], 
            //         $productsData);
            //     //Piešķir produkta ID
            //     $purchGoodsData['form-data']['product_id'] = $insertedRowID;
            //     //Ievieto datubāzē purchased_goods savienojumu starp produktu un pasūtījumu 

            //     if(!ifPurchGoodsHasOrderWithThisProduct($purchGoodsData)) {
            //         Database::insert(
            //             $purchGoodsData['table-name'], 
            //             $purchGoodsData);
            //     }

            //     Database::insert(
            //         $purchGoodsData['table-name'], 
            //         $purchGoodsData);
            // //Situācijās kad tiek atjaunināts
            // } else {
            //     //$tableName, $idColumnName, $id, $data
            //     $productRow = Database::getRowWithID(
            //         $productsData['table-name'], 
            //         $productsData['id-column-name'], 
            //         $productsData['id']);
            //     if(!empty($productRow)) {
            //         //Adjauno informāciju datubāzē
            //         Database::update(
            //             $productsData['table-name'], 
            //             $productsData['id-column-name'],
            //             $productsData['id'],
            //             $productsData);
            //     }
            // }
        }
        
        // echo '<p>'.print_r($productsData). '</p>';
        // echo '<p>'.print_r($purchGoodsData). '</p>';

        $response['productsData'] = $productsData;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>