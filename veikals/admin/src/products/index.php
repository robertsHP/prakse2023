<?php 
    include 'data.php';

    $pageTitle = 'Produkti';
    $redirectPath = '/veikals/admin/index.php';

    $keys = array_keys($data['form-data']);

    $columns = [
        'ID' => [
            'col-name' => $data['id-column-name']
        ],
        $data['form-data'][$keys[0]]['title'] => [
            'col-name' => $keys[0]
        ],
        $data['form-data'][$keys[3]]['title'] => [
            'col-name' => $keys[3]
        ],
        $data['form-data'][$keys[4]]['title'] => [
            'col-name' => $keys[4]
        ],
        $data['form-data'][$keys[5]]['title'] => [
            'col-name' => $keys[5],
            'value-swap-info' => [
                'swap-table' => 'product_categories',
                'swap-col-name' => 'name'
            ]
        ]
    ];

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/indexPage.php';
?>