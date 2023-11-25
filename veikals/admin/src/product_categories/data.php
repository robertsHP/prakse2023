<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    $tableName = 'product_categories';
    $idColumnName = 'category_id';

    $data = [
        'name' => [
            'value' => null,
            'type' => FormDataType::TEXT,
            'db_var_type' => PDO::PARAM_STR,
            'errorType' => FormErrorType::NONE,
            'required' => true
        ]
    ];
?>