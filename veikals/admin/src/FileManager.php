<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';

    class FileManager {
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
        public static function uploadFile ($tableName, &$fileVar) {
            $success = false;

            if(isset($fileVar)) {
                if($fileVar['errorType'] == FormErrorType::NONE) {
                    $targetDir = '/veikals/files/'.$tableName.'/';
                    $fileVar['value'] = $targetDir.$fileVar['value'];

                    $targetFile = $_SERVER['CONTEXT_DOCUMENT_ROOT'].$targetDir.basename($fileVar['value']);
                    $canUpload = true;
            
                    if (!file_exists($targetFile)) {
                        FileManager::moveFileToFolder(
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
        public static function getFileErrorTypes () {
            return [
                FormErrorType::EMPTY->value                     => 'Fails nav pievienots',
                FormErrorType::FILE_ALREADY_EXISTS->value       => 'Fails jau eksistē',
                FormErrorType::FILE_TOO_LARGE->value            => 'Fails ir pārāk liels',
                FormErrorType::FILE_FORMAT_INCORRECT->value     => 'Faila formāts nav pareizs',
                FormErrorType::FILE_IS_NOT_AN_IMAGE->value      => 'Fails nav bilde',
                FormErrorType::FILE_UPLOAD_UNSUCCESSFUL->value  => 'Faila augšupielāde nebīja veiksmīga'
            ];
        }
    }
?>