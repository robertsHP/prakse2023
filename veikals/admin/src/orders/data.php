<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    $tableName = 'orders';
    $idColumnName = 'order_id';

    $data = [
        'number' => [
            'title' => 'Numurs',
            'value' => null,
            'type' => FormDataType::NUMBER,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'client_id' => [
            'title' => 'Klients',
            'value' => null,
            'type' => FormDataType::NUMBER,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'date' => [
            'title' => 'Datums',
            'value' => null,
            'type' => FormDataType::DATE,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'total_price' => [
            'title' => 'Cena',
            'value' => null,
            'type' => FormDataType::NUMBER,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'state_id' => [
            'title' => 'Pasūtījuma statuss',
            'value' => null,
            'type' => FormDataType::NUMBER,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ]
    ];
?>