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
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Statusa nosaukums ir nepieciešams'
                ],
                'required' => true
            ]
        ]
    ];
?>