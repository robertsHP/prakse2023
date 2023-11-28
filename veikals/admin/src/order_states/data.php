<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    
    $data = [
        'id' => null,
        'db-process-type' => null,
        'table-name' => 'order_states',
        'id-column-name' => 'state_id',
        'form-data' => [
            'name' => [
                'title' => 'Nosaukums',
                'value' => null,
                'type' => FormDataType::TEXT,
                'db_var_type' => PDO::PARAM_STR,
                'errorType' => FormErrorType::NONE,
                'required' => true
            ]
        ]
    ];
?>