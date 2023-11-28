<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/VariableHandler.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    class CRUDFunctions {
        public static function loopAndProcessFormData (&$tempFiles, &$data) {
            $hasErrors = false;
            $errorTags = &$data['error-tags'];

            foreach ($data['form-data'] as $key => &$var) {
                VariableHandler::assignVariable($key, $var, $hasErrors, $errorTags);
                
                //Saglabā visus izslaicīgos failus un augšupielādē servera /temp mapē
                if($var['type'] === FormDataType::FILE) {
                    if($var['value'] != '') {
                        $var['value'] = FileUpload::prepareFolderPath($var['value'], 'temp');
                        $tempFiles[] = [
                            'key' => $key, 
                            'var' => &$var
                        ];
                        FileUpload::uploadFile($key, $var, $hasErrors);
                    }
                }
            }
            return $hasErrors;
        }
        public static function loopAndMoveTempFiles ($tableName, &$tempFiles, &$formData) {
            $filesUploaded = true;
            foreach ($tempFiles as &$file) {
                $newPath = FileUpload::prepareFolderPath(
                    $file['var']['value'], 
                    $tableName);
                $success = FileUpload::moveFile(
                    $_SERVER['CONTEXT_DOCUMENT_ROOT'].$file['var']['value'], 
                    $_SERVER['CONTEXT_DOCUMENT_ROOT'].$newPath
                );
                $formData[$file['key']]['value'] = $newPath;
            }
            return $filesUploaded;
        }

        public static function setID (&$data) {
            //Saņem GET padoto id
            if (!isset($_GET['id'])) {
                header('Location: index.php');
                exit();
            } 
            $data['id'] = $_GET['id'];
        }
        public static function loadExistingVariables (&$data) {
            if(isset($data['user-id'])) {
                $row = Database::getRowWithID($data['table-name'], $data['id-column-name'], $data['user-id']);

                //Ja neatgreiž neko tad veic redirect uz index
                if(empty($row)) {
                    header('Location: index.php');
                    exit();
                }
                //Dabū mainīgos no datubāzes
                foreach ($data['form-data'] as $key => &$var) {
                    $var['value'] = $row[$key];
                }
            }
        }
    }
?>