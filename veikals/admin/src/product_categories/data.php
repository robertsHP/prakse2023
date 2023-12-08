<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    $data = [
        'id' => null,
        'db-process-type' => null,
        'table-name' => 'product_categories',
        'api-table-name' => 'categories',
        'id-column-name' => 'category_id',
        'form-data' => [
            'name' => [
                'api-col' => 'name',
                'title' => 'Nosaukums',
                'value' => null,
                'type' => FormDataType::TEXT,
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Kategorijas nosaukums ir nepieciešams'
                ],
                'required' => true
            ]
        ]
    ];
?>