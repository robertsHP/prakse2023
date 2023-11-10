<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormDataType.php';

    $targetFile = $_SERVER['DOCUMENT_ROOT'].$targetDir . basename($file["name"]);

    $canUpload= true;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    function isFileAnImage ($file, &$canUpload, &$var) {
        $check = getimagesize($file["tmp_name"]);
        if($check !== false) {
            $canUpload = true;
        } else {
            $var['errorType'] = FormErrorType::FILE_IS_NOT_AN_IMAGE;
            $canUpload = false;
        }
    }
    function fileAlreadyExists (&$canUpload, &$var) {
        // Check if file already exists
        if (file_exists($targetFile)) {
            $var['errorType'] = FormErrorType::FILE_ALREADY_EXISTS;
            $canUpload = false;
        }
    }
    function checkFileSize ($file, &$canUpload, &$var) {
        // Check file size
        if ($file["size"] > 500000) {
            $var['errorType'] = FormErrorType::FILE_TOO_LARGE;
            $canUpload = false;
        }
    }
    function checkIfCorrectFileFormat ($imageFileType, $allowedTypes, &$canUpload, &$var) {
        $correct = false;
        foreach ($allowedTypes as $fileType) {
            if($imageFileType == $fileType) {
                $correct = true;
                break;
            }
        }
        if(!$correct) {
            $var['errorType'] = FormErrorType::FILE_FORMAT_INCORRECT;
            $canUpload = false;
        }
    }

    $var = &$formData[$tagName];

    if(!$file) {
        isFileAnImage($file, $canUpload, $var);
        fileAlreadyExists($canUpload, $var);
        checkFileSize($file, $canUpload, $var);
        checkIfCorrectFileFormat(
            $imageFileType, 
            $var['allowed_file_formats'], 
            $canUpload,
            $var
        );
    }
    
    //Pārbauda vai var augšupielādēt failu
    if ($canUpload) {
        if(move_uploaded_file($file["tmp_name"], $targetFile)) {
            $success = true;
        } else {
            $var['errorType'] = FormErrorType::FILE_UPLOAD_UNSUCCESSFUL;
        }
    }
?>