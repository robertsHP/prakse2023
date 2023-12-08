<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    $data = [
        'id' => null,
        'db-process-type' => null,
        'table-name' => 'orders',
        'api-table-name' => 'orders',
        'id-column-name' => 'order_id',
        'form-data' => [
            'number' => [
                'api-col' => 'number',
                'title' => 'Numurs',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db-var-type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Numurs nav ievadīts'
                ],
                'required' => true
            ],
            'client_id' => [
                'api-col' => 'client_id',
                'title' => 'Klients',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db-var-type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Klients nav izvēlēts'
                ],
                'required' => true
            ],
            'date' => [
                'api-col' => 'date',
                'title' => 'Datums',
                'value' => null,
                'type' => FormDataType::DATE,
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => FormTypeErrorConditions::DATE_DEFAULT,
                'required' => true
            ],
            'total_price' => [
                'api-col' => 'total_sum',
                'title' => 'Cena',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db-var-type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Cena nav ievadīta'
                ],
                'required' => true
            ],
            'state_id' => [
                'api-col' => 'state_id',
                'title' => 'Pasūtījuma statuss',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db-var-type' => PDO::PARAM_INT,
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
        'api-table-name' => 'order_products',
        'id-column-name' => 'purch_goods_id',
        'form-data' => [
            'order_id' => [
                'api-col' => 'order_id',
                'title' => 'Pasūtījums',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db-var-type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Pasūtījuma ID nav norādīts'
                ],
                'required' => true
            ], 
            'product_id' => [
                'api-col' => 'product_id',
                'title' => 'Produkts',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db-var-type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Preces ID nav norādīts'
                ],
                'required' => true
            ], 
            'amount' => [
                'api-col' => 'count',
                'title' => 'Pasūtītais daudzums',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db-var-type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Daudzums nav ievadīts'
                ],
                'required' => true
            ], 
            'total_price' => [
                'api-col' => 'total_sum',
                'title' => 'Cena',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db-var-type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Cena nav ievadīta'
                ],
                'required' => true
            ]
        ]
    ];
?>