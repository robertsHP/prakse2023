<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/elements/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/elements/enums/FormDataType.php';

    $tableName = 'orders';
    $idColumnName = 'order_id';

    $data = [
        'number' => [
            'value' => null,
            'type' => FormDataType::NUMBER,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'client_id' => [
            'value' => null,
            'type' => FormDataType::NUMBER,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'date' => [
            'value' => null,
            'type' => FormDataType::DATE,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'total_price' => [
            'value' => null,
            'type' => FormDataType::NUMBER,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'state_id' => [
            'value' => null,
            'type' => FormDataType::NUMBER,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ]
    ];
?>