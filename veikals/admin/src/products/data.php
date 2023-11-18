<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormDataType.php';

    $tableName = 'products';
    $idColumnName = 'product_id';

    $formData = [
        'name' => [
            'value' => null,
            'type' => FormDataType::TEXT,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'description' => [
            'value' => null,
            'type' => FormDataType::TEXT,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'photo_file_loc' => [
            'value' => null,
            'type' => FormDataType::FILE,
            'allowed_file_formats' => ['png', 'jpg'],
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'price' => [
            'value' => null,
            'type' => FormDataType::DECIMAL,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'available_amount' => [
            'value' => null,
            'type' => FormDataType::NUMBER,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ],
        'category_id' => [
            'value' => null,
            'type' => FormDataType::NUMBER,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ]
    ];
?>