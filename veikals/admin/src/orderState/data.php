<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/elements/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/elements/enums/FormDataType.php';

    $tableName = 'order_states';
    $idColumnName = 'state_id';

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