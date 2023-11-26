<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    include 'data.php';

    $pageTitle = 'Klienti';
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
        ],
        $data['form-data'][$keys[2]]['title'] => [
            'col-name' => $keys[2]
        ],
        $data['form-data'][$keys[3]]['title'] => [
            'col-name' => $keys[3]
        ],
    ];

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/indexPage.php';
?>