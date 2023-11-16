<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';

    class FileUpload {
        public const FILE_UPLOAD_PATH = '/veikals/files/';

        public static function moveFile ($oldPath, $newPath) {
            $moved = false;
            if($oldPath != '' && $newPath != '') {
                if($oldPath != $newPath) {
                    $moved = rename($oldPath, $newPath);
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
        public static function uploadFile (&$key, &$fileVar) {
            $uploaded = false;
            if($fileVar['errorType'] == FormErrorType::NONE) {
                if($_FILES[$key]['tmp_name'] == '') {
                    $tempVar = $fileVar;
                    VariableHandler::assignFileVariable($key, $tempVar);
                    $tempVar['value'] = FileUpload::prepareFolderPath($tempVar['value'], 'temp');
                    $tempVar['value'] = $_SERVER['CONTEXT_DOCUMENT_ROOT'].$tempVar['value'];
                } else {
                    $tempVar = $fileVar;
                    $tempVar['value'] = $_FILES[$key]['tmp_name'];
                }

                if (!file_exists($_SERVER['CONTEXT_DOCUMENT_ROOT'].$fileVar['value'])) {
                    if (filesize($tempVar['value']) > 500000) {
                        $fileVar['errorType'] = FormErrorType::FILE_TOO_LARGE;
                        return $uploaded;
                    }
                    if(!FileUpload::isFileTypeCorrect($fileVar)) {
                        $fileVar['errorType'] = FormErrorType::FILE_FORMAT_INCORRECT;
                        return $uploaded;
                    }
                    echo '|Upload = '.$tempVar['value'].'||||'.$fileVar['value'];
                    if(!FileUpload::moveFile($tempVar['value'], $_SERVER['CONTEXT_DOCUMENT_ROOT'].$fileVar['value'])) {
                        $fileVar['errorType'] = FormErrorType::FILE_UPLOAD_UNSUCCESSFUL;
                        return $uploaded;
                    }
                    $uploaded = true;
                } else {
                    $uploaded = true;
                }
            }
            return $uploaded;
        }
    }
?>