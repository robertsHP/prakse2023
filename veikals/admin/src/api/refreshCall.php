
<?php
    require_once 'localFunctions.php';

    function refreshDBInfo ($data) {
        echo "------".$data['table-name']."/".$data['api-table-name']."------<br>";

        // print_r(GET($data['api-table-name']));
        saveAndUpdateToLocalDB($data);
    }

    // refreshDBInfo(
    //     [
    //         'api-table-name' => 'clients',
    //         'table-name' => 'clients',
    //         'columns' => [
    //             'id' => 'client_id',
    //             'name' => 'name',
    //             'email' => 'email',
    //             'phone_number' => 'phone_number',
    //             'address' => 'adress'
    //         ]
    //     ]
    // );
    refreshDBInfo(
        [
            'api-table-name' => 'categories',
            'table-name' => 'product_categories',
            'columns' => [
                'id' => 'category_id',
                'name' => 'name'
            ]
        ]
    );
    // refreshDBInfo(
    //     [
    //         'api-table-name' => 'order_states',
    //         'table-name' => 'order_states',
    //         'columns' => [
    //             'id' => 'state_id',
    //             'name' => 'name'
    //         ]
    //     ]
    // );
    // refreshDBInfo(
    //     [
    //         'api-table-name' => 'orders',
    //         'table-name' => 'orders',
    //         'columns' => [
    //             'id' => 'order_id',
    //             'number' => 'number',
    //             'client_id' => 'client_id',
    //             'date' => 'date',
    //             'total_sum' => 'total_price',
    //             'state_id' => 'state_id'
    //         ]
    //     ]
    // );
    // refreshDBInfo(
    //     [
    //         'api-table-name' => 'products',
    //         'table-name' => 'products',
    //         'columns' => [
    //             'id' => 'product_id',
    //             'name' => 'name',
    //             'description' => 'description',
    //             'image_path' => 'photo_file_loc',
    //             'price' => 'price',
    //             'count_left' => 'available_amount',
    //             'category_id' => 'category_id',
    //         ]
    //     ]
    // );
    // refreshDBInfo(
    //     [
    //         'api-table-name' => 'order_products',
    //         'table-name' => 'purchased_goods',
    //         'columns' => [
    //             'id' => 'purch_goods_id',
    //             'order_id' => 'order_id',
    //             'product_id' => 'product_id',
    //             'count' => 'amount',
    //             'total_sum' => 'total_price'
    //         ]
    //     ]
    // );
?>