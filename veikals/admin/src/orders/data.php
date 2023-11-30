<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    $data = [
        'id' => null,
        'db-process-type' => null,
        'table-name' => 'orders',
        'id-column-name' => 'order_id',
        'form-data' => [
            'number' => [
                'title' => 'Numurs',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db_var_type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Numurs nav ievadīts'
                ],
                'required' => true
            ],
            'client_id' => [
                'title' => 'Klients',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db_var_type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Klients nav izvēlēts'
                ],
                'required' => true
            ],
            'date' => [
                'title' => 'Datums',
                'value' => null,
                'type' => FormDataType::DATE,
                'db_var_type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => FormTypeErrorConditions::DATE_DEFAULT,
                'required' => true
            ],
            'total_price' => [
                'title' => 'Cena',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db_var_type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Cena nav ievadīta'
                ],
                'required' => true
            ],
            'state_id' => [
                'title' => 'Pasūtījuma statuss',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db_var_type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Statuss nav norādīts'
                ],
                'required' => true
            ]
        ]
    ];
    $purchGoodsData = [
        'id' => null,
        'db-process-type' => null,
        'table-name' => 'purchased_goods',
        'id-column-name' => 'purch_goods_id',
        'form-data' => [
            'order_id' => [
                'title' => 'Pasūtījums',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db_var_type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'required' => true
            ], 
            'product_id' => [
                'title' => 'Produkts',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db_var_type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'required' => true
            ], 
            'amount' => [
                'title' => 'Daudzums',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db_var_type' => PDO::PARAM_INT,
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
            ]
        ]
    ];
?>