<?php 
    $redirectPath = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';

    include 'data.php';

    CRUDFunctions::setID($data);
    CRUDFunctions::loadExistingVariables($data);

    $pageTitle = 'Rediģēt pasūtījumu';
    $data['db-process-type'] = 'update';
    $inputFormPath = '/veikals/admin/src/'.$data['table-name'].'/inputForm.php';

    include $_SERVER['DOCUMENT_ROOT'].$inputFormPath;
?>