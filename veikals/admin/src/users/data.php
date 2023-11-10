<?php
    $tableName = 'user';
    $idColumnName = 'user_id';

    $formData = [
        'name' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => null,
            'required' => true
        ],
        'surname' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => null,
            'required' => true
        ],
        'email' => [
            'value' => null,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => null,
            'required' => true
        ]
    ];
?>