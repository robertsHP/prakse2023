<?php 
    $redirectPath = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';
    include 'data.php';

    $pageTitle = 'Pievienot jaunu pasūtījumu';
    $data['db-process-type'] = 'create';
    $inputFormPath = '/veikals/admin/src/'.$data['table-name'].'/inputForm.php';

    include $_SERVER['DOCUMENT_ROOT'].$inputFormPath;
?>