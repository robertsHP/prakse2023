<?php 
    include 'data.php';

    $pageTitle = 'Pasūtījumi';
    $redirectPath = '/veikals/admin/index.php';

    $keys = array_keys($data);

    $columns = [
        'ID' => [
            'col-name' => $idColumnName
        ],
        'Numurs' => [
            'col-name' => $keys[0]
        ],
        'Klients' => [
            'col-name' => $keys[1],
            'value-swap-info' => [
                'swap-table' => 'clients',
                'swap-col-name' => 'name'
            ]
        ],
        'Datums' => [
            'col-name' => $keys[2]
        ],
        'Cena' => [
            'col-name' => $keys[3]
        ],
        'Pasūtījuma statuss' => [
            'col-name' => $keys[4],
            'link-info' => [
                'swap-table' => 'order_states',
                'swap-col-name' => 'name'
            ]
        ]
    ];

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/indexPage.php';
?>