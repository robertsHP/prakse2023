<?php 
    include 'data.php';

    $pageTitle = 'Pasūtījumu statusi';
    $redirectPath = '/veikals/admin/index.php';

    $keys = array_keys($data['form-data']);

    $columns = [
        'ID' => [
            'col-name' => $data['id-column-name']
        ],
        $data['form-data'][$keys[0]]['title'] => [
            'col-name' => $keys[0]
        ]
    ];

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/indexPage.php';
?>