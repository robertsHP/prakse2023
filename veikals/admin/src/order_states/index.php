<?php 
    include 'data.php';

    $pageTitle = 'Pasūtījumu statusi';
    $redirectPath = '/veikals/admin/index.php';

    $keys = array_keys($data);

    $columns = [
        'ID' => [
            'col-name' => $idColumnName
        ],
        'Nosaukums' => [
            'col-name' => $keys[0]
        ]
    ];

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/indexPage.php';
?>