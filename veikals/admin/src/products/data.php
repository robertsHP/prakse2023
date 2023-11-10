<?php
    $tableName = 'product';
    $idColumnName = 'product_id';

    $formData = [
        'name' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => null,
            'required' => true

        ],
        'description' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => null,
            'required' => true
        ],
        'photo_file_loc' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => null,
            'required' => true
        ],
        'price' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => null,
            'required' => true
            // 'error' => [
            //     'empty' => 'Cena ir nepieciešams'
            // ]
        ],
        'available_amount' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => null,
            'required' => true
            // 'error' => [
            //     'empty' => 'Nav norādīts pieejamais daudzums'
            // ]
        ],
        'category_id' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_INT,
            'errorType' => null,
            'required' => true
            // 'error' => [
            //     'empty' => 'Norādiet daudzumu'
            // ]
        ]
    ];
?>