<?php 
    $redirectPath = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    include 'data.php';

    $pageTitle = 'Rediģēt statusa informāciju';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/updatePage.php';
?>