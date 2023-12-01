<?php 
    $redirectPath = '/veikals/admin/index.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/sessionCheck.php';
    include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/tempCheck.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUD/CRUDFunctions.php';

    include 'data.php';

    CRUDFunctions::setID($data);
    CRUDFunctions::loadExistingVariables($data);

    $pageTitle = 'Rediģēt kategorijas informāciju';
    $data['db-process-type'] = 'update';
    $inputFormPath = '/veikals/admin/src/'.$data['table-name'].'/inputForm.php';

    include $_SERVER['DOCUMENT_ROOT'].$inputFormPath;
?>