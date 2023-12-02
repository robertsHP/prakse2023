<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/VariableHandler.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    require_once 'data.php';

    CRUDFunctions::setID($data);

    try {
        $conn = Database::openConnection();

        $stmt = $conn->prepare(
            "DELETE FROM purchased_goods WHERE order_id=:order_id"
        );
        $stmt->bindParam(':order_id', $data['id'], PDO::PARAM_INT);
        $stmt->execute();

        Database::closeConnection($conn);
    } catch (PDOException $exception) {
        echo "PDO Exception: " . $exception->getMessage();
        echo "Error Code: " . $exception->getCode();
    }
?>