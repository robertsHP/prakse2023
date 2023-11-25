<?php 
    $redirectPath = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    include 'data.php';

    $pageTitle = 'Izveidot jaunu lietotāju';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/createPage.php';
?>