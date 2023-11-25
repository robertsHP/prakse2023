<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    $tableName = 'clients';
    $idColumnName = 'client_id';

    $data = [
        'name' => [
            'value' => null,
            'type' => FormDataType::TEXT,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'email' => [
            'value' => null,
            'type' => FormDataType::EMAIL,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'phone_number' => [
            'value' => null,
            'type' => FormDataType::PHONE_NUMBER,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'adress' => [
            'value' => null,
            'type' => FormDataType::TEXT,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
    ];
?>