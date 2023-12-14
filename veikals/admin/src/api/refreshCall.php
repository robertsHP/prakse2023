
<?php
    require_once 'ApiFunctions.php';

    function refreshDBInfo ($data) {
        echo "------".$data['table-name']."/".$data['api-table-name']."------<br>";
        $response = null;
        // print_r(GET($data['api-table-name']));
        ApiFunctions::saveAndUpdateLocalDB($data, $response);
        echo $response;
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/clients/data.php';
    refreshDBInfo($data);
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/product_categories/data.php';
    refreshDBInfo($data);
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/order_states/data.php';
    refreshDBInfo($data);
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/orders/data.php';
    refreshDBInfo($data);
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/products/data.php';
    refreshDBInfo($data);
    refreshDBInfo($purchGoodsData);
?>