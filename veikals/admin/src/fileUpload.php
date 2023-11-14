<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormDataType.php';

    //Piešķir pareizo ceļu uz izvēlēto failu
    $targetDir = '/veikals/files/'.$folderName.'/';
    $file = $_FILES[$tagName];

    if($file['name'] != '') {
        $formData[$tagName]['value'] = $targetDir.$file['name'];
        $targetFile = $_SERVER['CONTEXT_DOCUMENT_ROOT'].$targetDir.basename($file["name"]);

        $canUpload= true;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
        $var = &$formData[$tagName];
    
        if (!file_exists($targetFile)) {
            if ($file["size"] <= 500000) {
                $correct = false;
                foreach ($var['allowed_file_formats'] as $fileType) {
                    if($imageFileType == $fileType) {
                        $correct = true;
                        break;
                    }
                }
                if($correct) {
                    if(move_uploaded_file($file["tmp_name"], $targetFile)) {
                        $success = true;
                    } else {
                        $var['errorType'] = FormErrorType::FILE_UPLOAD_UNSUCCESSFUL;
                    }
                } else {
                    $var['errorType'] = FormErrorType::FILE_FORMAT_INCORRECT;
                }
            } else {
                $var['errorType'] = FormErrorType::FILE_TOO_LARGE;
            }
        } else {
            $success = true;
        }
    } else {
        $var['errorType'] = FormErrorType::EMPTY;
    }
?>