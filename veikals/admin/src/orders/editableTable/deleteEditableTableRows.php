<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/VariableHandler.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    $response = array(
        'success' => false
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rowIDArr = json_decode($_POST['rowIDArr'], true);
        unset($_POST['rowIDArr']);

        $orderID = json_decode($_POST['orderID'], true);
        unset($_POST['orderID']);

        try {
            $conn = Database::openConnection();

            $stmt = $conn->prepare(
                "SELECT * FROM purchased_goods WHERE order_id=:order_id"
            );
            $stmt->bindParam(':order_id', $orderID, PDO::PARAM_INT);
            $stmt->execute();
            $purchGoodsLinks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($purchGoodsLinks as $key => $link) {
                foreach ($rowIDArr as $rowID) {
                    if($link['product_id'] == $rowID) {
                        unset($purchGoodsLinks[$key]);
                    }
                }
            }

            if(count($purchGoodsLinks) != 0) {
                foreach ($purchGoodsLinks as $link) {
                    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/orders/data.php';
                    
                    $purchGoodsData['id'] = $link['purch_goods_id'];
                    CRUDFunctions::deleteAndDELETE($purchGoodsData);
                }
            }

            Database::closeConnection($conn);

            $response['success'] = true;
        } catch (PDOException $exception) {
            echo "PDO Exception: " . $exception->getMessage();
            echo "Error Code: " . $exception->getCode();
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
?>