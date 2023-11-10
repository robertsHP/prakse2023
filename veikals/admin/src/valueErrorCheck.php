<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormDataType.php';

    if($arr['type'] == FormDataType::FILE)
        return;

    if(empty($arr['value'])) {
        $arr['errorType'] = FormErrorType::EMPTY;
        $hasErrors = true;
    }

    if ($arr['type'] == FormDataType::EMAIL) {
        if(!filter_var($arr['value'], FILTER_VALIDATE_EMAIL)) {
            $arr['errorType'] = FormErrorType::INVALID;
            $hasErrors = true;
        }
    }
?>