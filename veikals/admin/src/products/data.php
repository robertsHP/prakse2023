<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    $data = [
        'table-name' => 'products',
        'id-column-name' => 'product_id',
        'form-data' => [
            'name' => [
                'title' => 'Nosaukums',
                'value' => null,
                'type' => FormDataType::TEXT,
                'db_var_type' => PDO::PARAM_STR,
                'errorType' => FormErrorType::NONE,
                'required' => true
            ],
            'description' => [
                'title' => 'Apraksts',
                'value' => null,
                'type' => FormDataType::TEXT,
                'db_var_type' => PDO::PARAM_STR,
                'errorType' => FormErrorType::NONE,
                'required' => true
            ],
            'photo_file_loc' => [
                'title' => 'Bilde',
                'value' => null,
                'type' => FormDataType::FILE,
                'allowed_file_formats' => ['png', 'jpg'],
                'db_var_type' => PDO::PARAM_STR,
                'errorType' => FormErrorType::NONE,
                'required' => true
            ],
            'price' => [
                'title' => 'Cena',
                'value' => null,
                'type' => FormDataType::DECIMAL,
                'db_var_type' => PDO::PARAM_STR,
                'errorType' => FormErrorType::NONE,
                'required' => true
            ],
            'available_amount' => [
                'title' => 'Pieejamais daudzums',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db_var_type' => PDO::PARAM_INT,
                'errorType' => FormErrorType::NONE,
                'required' => true
            ],
            'category_id' => [
                'title' => 'Kategorija',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db_var_type' => PDO::PARAM_INT,
                'errorType' => FormErrorType::NONE,
                'required' => true
            ]
        ]
    ];
?>