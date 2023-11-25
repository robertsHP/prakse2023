<?php 
    include 'data.php';

    $pageTitle = 'Produkti';
    $redirectPath = '/veikals/admin/index.php';

    $keys = array_keys($data);

    $columns = [
        'ID' => [
            'col-name' => $idColumnName
        ],
        'Nosaukums' => [
            'col-name' => $keys[0]
        ],
        'Cena' => [
            'col-name' => $keys[3]
        ],
        'Pieejamais daudzums' => [
            'col-name' => $keys[4]
        ],
        'Kategorija' => [
            'col-name' => $keys[5],
            'value-swap-info' => [
                'swap-table' => 'product_categories',
                'swap-col-name' => 'name'
            ]
        ]
    ];

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/indexPage.php';
?>