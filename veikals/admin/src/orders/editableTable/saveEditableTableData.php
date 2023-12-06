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
        'success' => false
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productsData = json_decode($_POST['productsData'], true);
        $purchGoodsData = json_decode($_POST['purchGoodsData'], true);
        $orderID = $_POST['orderID'];

        $purchGoodsData['form-data']['order_id']['value'] = $orderID;

        // echo '<p>'.print_r($productsData).'</p>';
        // echo '<p>'.print_r($purchGoodsData).'</p>';

        if($orderID != null) {
            //Situācijās kad vada pilnīgi no jauna tabulā

            if($productsData['id'] == null) {
                //Ievieto datubāzē produktu 
                $productsData['id'] = Database::insert(
                    $productsData['table-name'], 
                    $productsData['form-data']
                );
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
                    $purchGoodsData['form-data']['product_id']['value'] = $productsData['id'];
                    //Adjauno informāciju datubāzē
                    Database::update(
                        $productsData['table-name'], 
                        $productsData['id-column-name'],
                        $productsData['id'],
                        $productsData['form-data']
                    );
                }
                $response['success'] = true;
            }
            
            $purchGoodsRow = getPurchGoodsRow($purchGoodsData);

            //Ievieto datubāzē purchased_goods savienojumu starp produktu un pasūtījumu 
            if($purchGoodsRow == null) {
                //aprēķina total price
                Database::insert(
                    $purchGoodsData['table-name'], 
                    $purchGoodsData['form-data']);
            } else {
                $purchGoodsData['id'] = $purchGoodsRow['purch_goods_id'];
                Database::update(
                    $purchGoodsData['table-name'], 
                    $purchGoodsData['id-column-name'],
                    $purchGoodsData['id'], 
                    $purchGoodsData['form-data']
                );
            }
        }
        $response['id'] = $productsData['id'];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>