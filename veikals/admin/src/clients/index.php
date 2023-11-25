<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    include 'data.php';

    $pageTitle = 'Klienti';
    $redirectPath = '/veikals/admin/index.php';

    $keys = array_keys($data);

    $columns = [
        'ID' => [
            'col-name' => $idColumnName
        ],
        'Vārds/Nosaukums' => [
            'col-name' => $keys[0]
        ],
        'E-pasts' => [
            'col-name' => $keys[1],
        ],
        'Telefona numurs' => [
            'col-name' => $keys[2]
        ],
        'Adrese' => [
            'col-name' => $keys[3]
        ],
    ];

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/indexPage.php';
?>