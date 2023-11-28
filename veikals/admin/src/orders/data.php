<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    $data = [
        'id' => null,
        'table-name' => 'orders',
        'id-column-name' => 'order_id',
        'db-process-type' => null,
        'form-data' => [
            'number' => [
                'title' => 'Numurs',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db_var_type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'required' => true
            ],
            'client_id' => [
                'title' => 'Klients',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db_var_type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'required' => true
            ],
            'date' => [
                'title' => 'Datums',
                'value' => null,
                'type' => FormDataType::DATE,
                'db_var_type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'required' => true
            ],
            'total_price' => [
                'title' => 'Cena',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db_var_type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'required' => true
            ],
            'state_id' => [
                'title' => 'Pasūtījuma statuss',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db_var_type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'required' => true
            ],
            // 'products' => [
            //     'title' => 'Produkti',
            //     'table-info' => [
            //         'name' => 'purchased_goods',
            //         'columns' => [
            //             'purch_goods_id' => [
            //                 'title' => 'ID',
            //                 'value' => null,
            //                 'type' => FormDataType::NUMBER,
            //                 'db_var_type' => PDO::PARAM_INT,
            //                 'errorType' => FormErrorType::NONE,
            //                 'required' => true
            //             ], 
            //             'order_id' => [
            //                 'title' => 'Pasūtījums',
            //                 'value' => null,
            //                 'type' => FormDataType::NUMBER,
            //                 'db_var_type' => PDO::PARAM_INT,
            //                 'errorType' => FormErrorType::NONE,
            //                 'required' => true
            //             ], 
            //             'product_id' => [
            //                 'title' => 'Produkts',
            //                 'value' => null,
            //                 'type' => FormDataType::NUMBER,
            //                 'db_var_type' => PDO::PARAM_INT,
            //                 'errorType' => FormErrorType::NONE,
            //                 'required' => true
            //             ], 
            //             'amount' => [
            //                 'title' => 'Daudzums',
            //                 'value' => null,
            //                 'type' => FormDataType::NUMBER,
            //                 'db_var_type' => PDO::PARAM_INT,
            //                 'errorType' => FormErrorType::NONE,
            //                 'required' => true
            //             ], 
            //             'total_price' => [
            //                 'title' => 'Cena',
            //                 'value' => null,
            //                 'type' => FormDataType::NUMBER,
            //                 'db_var_type' => PDO::PARAM_INT,
            //                 'errorType' => FormErrorType::NONE,
            //                 'required' => true
            //             ]
            //         ]
            //     ]
            // ],
        ]
    ];
?>