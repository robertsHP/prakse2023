<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/elements/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/elements/enums/FormDataType.php';

    $tableName = 'user';
    $idColumnName = 'user_id';

    $formData = [
        'name' => [
            'value' => null,
            'type' => FormDataType::TEXT,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'surname' => [
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
        ]
    ];
?>