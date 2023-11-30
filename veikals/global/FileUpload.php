<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';

    class FileUpload {
        public const FILE_UPLOAD_PATH = '/veikals/files/';

        public static function moveFile ($oldPath, $newPath) {
            $moved = false;
            if($oldPath != '' && $newPath != '') {
                if($oldPath != $newPath) {
                    if(file_exists($oldPath) && !file_exists($newPath)) {
                        $moved = rename($oldPath, $newPath);
                    }
                }
            }
            return $moved;
        }
        private static function isFileTypeCorrect (&$fileVar) {
            $valid = false;
            $fileType = strtolower(pathinfo($fileVar['value'], PATHINFO_EXTENSION));
            foreach ($fileVar['allowed_file_formats'] as $fileTypeAllowed) {
                if($fileType == $fileTypeAllowed) {
                    $valid = true;
                    break;
                }
            }
            return $valid;
        }
        private static function containsUploadPathOrRoot ($fileName) {
            $containsFileUploadPath = strpos($fileName, FileUpload::FILE_UPLOAD_PATH) === false;
            $containsRootPath = strpos($fileName, $_SERVER['CONTEXT_DOCUMENT_ROOT']) === false;

            return $containsFileUploadPath || $containsRootPath;
        }
        public static function prepareFolderPath ($fileName, $folderName) {
            if($fileName != '') {
                $targetDir = FileUpload::FILE_UPLOAD_PATH.$folderName.'/';
                if (FileUpload::containsUploadPathOrRoot($fileName))
                    $fileName = basename($fileName);
                $fileName = $targetDir.$fileName;
            }
            return $fileName;
        }
        public static function uploadFile (&$key, &$fileVar, &$hasErrors) {
            if(!$hasErrors) {
                if($fileVar['error-type'] == FormErrorType::NONE) {
                    $tempPath = $fileVar['value']['tmp_name'];

                    $fileVarFullPath = $_SERVER['CONTEXT_DOCUMENT_ROOT'].$fileVar['value']['name'];

                    $existenceCheck = file_exists($tempPath) && !file_exists($fileVarFullPath);
                    $pathsAreNotTheSame = $tempPath != $fileVarFullPath;

                    if ($existenceCheck && $pathsAreNotTheSame) {
                        if (filesize($tempPath) > 500000) {
                            $fileVar['error-type'] = FormErrorType::FILE_TOO_LARGE;
                            $hasErrors = true;
                        }
                        if(!FileUpload::isFileTypeCorrect($fileVar)) {
                            $fileVar['error-type'] = FormErrorType::FILE_FORMAT_INCORRECT;
                            $hasErrors = true;
                        }
                        if(!FileUpload::moveFile($tempPath, $fileVarFullPath)) {
                            $fileVar['error-type'] = FormErrorType::FILE_UPLOAD_UNSUCCESSFUL;
                            $hasErrors = true;
                        }
                    }
                }
            }
        }
    }
?>