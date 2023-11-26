<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    
    $data = [
        'table-name' => 'users',
        'id-column-name' => 'user_id',
        'form-data' => [
            'name' => [
                'title' => 'Vārds',
                'value' => null,
                'type' => FormDataType::TEXT,
                'db_var_type' => PDO::PARAM_STR,
                'errorType' => FormErrorType::NONE,
                'required' => true
            ],
            'surname' => [
                'title' => 'Uzvārds',
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
            ]
        ]
    ];
?>