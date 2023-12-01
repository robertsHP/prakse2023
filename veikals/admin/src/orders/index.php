<?php 
    include 'data.php';

    $pageTitle = 'Pasūtījumi';
    $redirectPath = '/veikals/admin/index.php';

    $keys = array_keys($data['form-data']);

    $columns = [
        'ID' => [
            'col-name' => $data['id-column-name']
        ],
        $data['form-data'][$keys[0]]['title'] => [
            'col-name' => $keys[0]
        ],
        $data['form-data'][$keys[1]]['title'] => [
            'col-name' => $keys[1],
            'value-swap-info' => [
                'swap-table' => 'clients',
                'swap-col-name' => 'name'
            ]
        ],
        $data['form-data'][$keys[2]]['title'] => [
            'col-name' => $keys[2]
        ],
        $data['form-data'][$keys[3]]['title'] => [
            'col-name' => $keys[3]
        ],
        $data['form-data'][$keys[4]]['title'] => [
            'col-name' => $keys[4],
            'link-info' => [
                'swap-table' => 'order_states',
                'swap-col-name' => 'name'
            ]
        ]
    ];

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/indexPage.php';
?>