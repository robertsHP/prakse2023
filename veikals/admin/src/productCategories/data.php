<?php
    $tableName = 'product_category';
    $idColumnName = 'category_id';

    $formData = [
        'name' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => null,
            'required' => true
        ]
    ];
?>