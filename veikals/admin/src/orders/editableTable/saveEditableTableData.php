<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/VariableHandler.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    function getPurchGoodsRow ($purchGoodsData) {
        $conn = Database::openConnection();
    
        $tableName = $purchGoodsData['table-name'];

        $stmt = $conn->prepare(
            "SELECT * FROM $tableName WHERE order_id=:order_id AND product_id=:product_id"
        );
        $stmt->bindParam(':order_id', $purchGoodsData['form-data']['order_id']['value'], PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $purchGoodsData['form-data']['product_id']['value'], PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        Database::closeConnection($conn);

        return $result;
    }

    $response = array(
        'success' => false,
        'postResponse' => null
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productsData = json_decode($_POST['productsData'], true);
        $purchGoodsData = json_decode($_POST['purchGoodsData'], true);
        $orderID = $_POST['orderID'];

        $purchGoodsData['form-data']['order_id']['value'] = $orderID;

        if($orderID != null) {
            //Situācijās kad vada pilnīgi no jauna tabulā

            if($productsData['id'] == null) {
                //Ievieto datubāzē produktu 
                $response['postResponse'] = CRUDFunctions::insertAndPOST($productsData);

                //Piešķir produkta ID
                $purchGoodsData['form-data']['product_id']['value'] = $productsData['id'];
                $response['success'] = true;
            //Situācijās kad tiek atjaunināts
            } else {
                $productRow = Database::getRowWithID(
                    $productsData['table-name'], 
                    $productsData['id-column-name'], 
                    $productsData['id']);
                if(!empty($productRow)) {
                    $response['postResponse'] = CRUDFunctions::updateAndPUT($productsData);
                    $purchGoodsData['form-data']['product_id']['value'] = $productsData['id'];
                }
                $response['success'] = true;
            }
            
            $purchGoodsRow = getPurchGoodsRow($purchGoodsData);

            //Ievieto datubāzē purchased_goods savienojumu starp produktu un pasūtījumu 
            if($purchGoodsRow == null) {
                $response['postResponse'] = CRUDFunctions::insertAndPOST($purchGoodsData);
            } else {
                $purchGoodsData['id'] = $purchGoodsRow['purch_goods_id'];
                $response['postResponse'] = CRUDFunctions::updateAndPUT($purchGoodsData);
            }
        }
        $response['id'] = $productsData['id'];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>