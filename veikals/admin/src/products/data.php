<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';

    $tableName = 'product';
    $idColumnName = 'product_id';

    $formData = [
        'name' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true

        ],
        'description' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'photo_file_loc' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'price' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'available_amount' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'category_id' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ]
    ];
?>