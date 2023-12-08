<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    $data = [
        'id' => null,
        'db-process-type' => null,
        'table-name' => 'products',
        'api-table-name' => 'products',
        'id-column-name' => 'product_id',
        'form-data' => [
            'name' => [
                'api-col' => 'name',
                'title' => 'Nosaukums',
                'value' => null,
                'type' => FormDataType::TEXT,
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Nosaukums nav ievadīts'
                ],
                'required' => true
            ],
            'description' => [
                'api-col' => 'description',
                'title' => 'Apraksts',
                'value' => null,
                'type' => FormDataType::TEXT,
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Apraksts nav ievadīts'
                ],
                'required' => true
            ],
            'photo_file_loc' => [
                'api-col' => 'image_path',
                'title' => 'Bilde',
                'value' => null,
                'type' => FormDataType::FILE,
                'allowed_file_formats' => ['png', 'jpg'],
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => FormTypeErrorConditions::FILE_DEFAULT,
                'required' => true
            ],
            'price' => [
                'api-col' => 'price',
                'title' => 'Cena',
                'value' => null,
                'type' => FormDataType::DECIMAL,
                'db-var-type' => PDO::PARAM_STR,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Cena nav ievadīta'
                ],
                'required' => true
            ],
            'available_amount' => [
                'api-col' => 'count_left',
                'title' => 'Pieejamais daudzums',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db-var-type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Daudzums nav ievadīts'
                ],
                'required' => true
            ],
            'category_id' => [
                'api-col' => 'category_id',
                'title' => 'Kategorija',
                'value' => null,
                'type' => FormDataType::NUMBER,
                'db-var-type' => PDO::PARAM_INT,
                'error-type' => FormErrorType::NONE,
                'error-conditions' => [
                    FormErrorType::EMPTY->value => 'Kategorija nav izvēlēta'
                ],
                'required' => true
            ]
        ]
    ];
?>