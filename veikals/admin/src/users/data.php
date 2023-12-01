<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    
    $data = [
        'id' => null,
        'db-process-type' => null,
        'table-name' => 'users',
        'id-column-name' => 'user_id',
        'form-data' => [
            'name' => [
                'title' => 'Vārds',
                'value' => null,
                'type' => FormDataType::TEXT,
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Vārds ir nepieciešams'
                ],
                'required' => true
            ],
            'surname' => [
                'title' => 'Uzvārds',
                'value' => null,
                'type' => FormDataType::TEXT,
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Uzvārds ir nepieciešams'
                ],
                'required' => true
            ],
            'email' => [
                'title' => 'E-pasts',
                'value' => null,
                'type' => FormDataType::EMAIL,
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => FormTypeErrorConditions::EMAIL_DEFAULT,
                'required' => true
            ]
        ]
    ];
?>