<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';

    class FileUpload {
        private static function moveFileToFolder ($targetFile, $fileVar, &$success) {
            if ($file["size"] <= 500000) {
                $valid = false;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                foreach ($var['allowed_file_formats'] as $fileType) {
                    if($imageFileType == $fileType) {
                        $valid = true;
                        break;
                    }
                }
                if($valid) {
                    if(move_uploaded_file($file["tmp_name"], $targetFile)) {
                        $success = true;
                    } else {
                        $fileVar['errorType'] = FormErrorType::FILE_UPLOAD_UNSUCCESSFUL;
                    }
                } else {
                    $fileVar['errorType'] = FormErrorType::FILE_FORMAT_INCORRECT;
                }
            } else {
                $fileVar['errorType'] = FormErrorType::FILE_TOO_LARGE;
            }
        }
        public static function uploadFile ($folderName, &$fileVar) {
            $success = false;

            if(isset($fileVar)) {
                if($fileVar['errorType'] == FormErrorType::NONE) {
                    $targetDir = '/veikals/files/'.$folderName.'/';
                    $fileVar['value'] = $targetDir.$fileVar['value'];

                    $targetFile = $_SERVER['CONTEXT_DOCUMENT_ROOT'].$targetDir.basename($fileVar['value']);
                    $canUpload = true;
            
                    if (!file_exists($targetFile)) {
                        FileUpload::moveFileToFolder(
                            $targetFile, 
                            $fileVar, 
                            $success);
                    } else {
                        $success = true;
                    }
                }
            }
            return $success;

        }
    }
?>