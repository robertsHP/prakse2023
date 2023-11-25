<?php 
    include 'data.php';

    $pageTitle = 'Lietotāji';
    $redirectPath = '/veikals/admin/index.php';

    $keys = array_keys($data);

    $columns = [
        'ID' => [
            'col-name' => $idColumnName
        ],
        'Vārds' => [
            'col-name' => $keys[0]
        ],
        'Uzvārds' => [
            'col-name' => $keys[1]
        ],
        'E-pasts' => [
            'col-name' => $keys[2]
        ]
    ];

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/indexPage.php';
?>