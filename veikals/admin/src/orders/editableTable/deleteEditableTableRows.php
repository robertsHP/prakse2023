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
                "SELECT product_id FROM purchased_goods WHERE order_id=:order_id"
            );
            $stmt->bindParam(':order_id', $orderID, PDO::PARAM_INT);
            $stmt->execute();
            $productsFromDB = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo '<p>BEFORE</p>';
            echo '<p>'.print_r($productsFromDB).'</p>';
            echo '<p>'.print_r($rowIDArr).'</p>';

            foreach ($productsFromDB as $key => $product) {
                foreach ($rowIDArr as $rowID) {
                    if($product['product_id'] == $rowID) {
                        unset($productsFromDB[$key]);
                    }
                }
            }

            echo '<p>AFTER</p>';
            echo '<p>'.print_r($productsFromDB).'</p>';
            echo '<p>'.print_r($rowIDArr).'</p>';

            if(count($productsFromDB) != 0) {
                foreach ($productsFromDB as $product) {
                    $id = $product['product_id'];

                    $stmt = $conn->prepare(
                        "DELETE FROM purchased_goods WHERE order_id=:order_id AND product_id=:product_id"
                    );
                    $stmt->bindParam(':order_id', $orderID, PDO::PARAM_INT);
                    $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }

            Database::closeConnection($conn);

            $response['success'] = true;
        } catch (PDOException $exception) {
            echo "PDO Exception: " . $exception->getMessage();
            echo "Error Code: " . $exception->getCode();
        }
    }

    // header('Content-Type: application/json');
    // echo json_encode($response);
?>