<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    
    $data = [
        'id' => null,
        'db-process-type' => null,
        'table-name' => 'clients',
        'id-column-name' => 'client_id',
        'form-data' => [
            'name' => [
                'title' => 'Vārds/Nosaukums',
                'value' => null,
                'type' => FormDataType::TEXT,
                'db_var_type' => PDO::PARAM_STR,
                'errorType' => FormErrorType::NONE,
                'required' => true
            ],
            'email' => [
                'title' => 'E-pasts',
                'value' => null,
                'type' => FormDataType::EMAIL,
                'db_var_type' => PDO::PARAM_STR,
                'errorType' => FormErrorType::NONE,
                'required' => true
            ],
            'phone_number' => [
                'title' => 'Telefona numurs',
                'value' => null,
                'type' => FormDataType::PHONE_NUMBER,
                'db_var_type' => PDO::PARAM_STR,
                'errorType' => FormErrorType::NONE,
                'required' => true
            ],
            'adress' => [
                'title' => 'Adrese',
                'value' => null,
                'type' => FormDataType::TEXT,
                'db_var_type' => PDO::PARAM_STR,
                'errorType' => FormErrorType::NONE,
                'required' => true
            ],
        ]
    ];
?>