<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/VariableHandler.php';

    class CRUDFunctions {
        private static function loopAndProcessFormData (&$tempFiles, &$data) {
            $hasErrors = false;

            foreach ($data as $key => &$var) {
                VariableHandler::assignVariable($key, $var, $hasErrors);
                
                //Saglabā visus izslaicīgos failus un augšupielādē servera /temp mapē
                if($var['type'] === FormDataType::FILE) {
                    if($var['value'] != '') {
                        $var['value'] = FileUpload::prepareFolderPath(
                            $var['value'], 'temp');
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
        private static function loopAndMoveTempFiles ($tableName, &$tempFiles, &$data) {
            $filesUploaded = true;
            foreach ($tempFiles as &$file) {
                $newPath = FileUpload::prepareFolderPath(
                    $file['var']['value'], 
                    $tableName);
                $success = FileUpload::moveFile(
                    $_SERVER['CONTEXT_DOCUMENT_ROOT'].$file['var']['value'], 
                    $_SERVER['CONTEXT_DOCUMENT_ROOT'].$newPath
                );
                $data[$file['key']]['value'] = $newPath;
            }
            return $filesUploaded;
        }
        private static function getID () {
            //Saņem GET padoto id
            if (!isset($_GET['id'])) {
                header('Location: index.php');
                exit();
            } 
            return $_GET['id'];
        }

        private static function performCreateSaveAction ($tableName, &$data) {
            $tempFiles = [];

            $hasErrors = CRUDFunctions::loopAndProcessFormData($tempFiles, $data);
            if(!$hasErrors) {
                $filesUploaded = CRUDFunctions::loopAndMoveTempFiles($tableName, $tempFiles, $data);
                if($filesUploaded) {
                    $success = Database::insert($tableName, $data);
                    if($success) {
                        // header('Location: index.php');
                        // exit();
                    }
                }
            }
        }
        public static function create ($tableName, &$data) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
                //Pārbauda vai save poga nospiesta
                if (isset($_POST['save'])) {
                    CRUDFunctions::performCreateSaveAction($tableName, $data);
                //Pārbauda vai back poga nospiesta
                } else if (isset($_POST['back'])) {
                    header('Location: index.php');
                    exit();
                }
            }
        }
        private static function performUpdateSaveAction ($tableName, $idColumnName, $id, &$data) {
            $tempFiles = [];

            $hasErrors = CRUDFunctions::loopAndProcessFormData($tempFiles, $data);
            if(!$hasErrors) {
                $filesUploaded = CRUDFunctions::loopAndMoveTempFiles($tableName, $tempFiles, $data);
                if($filesUploaded) {
                    $success = Database::update($tableName, $idColumnName, $id, $data);
                    if($success) {
                        // header('Location: index.php');
                        // exit();
                    }
                }
            }
        }
        private static function getFormData (&$row, &$data) {
            //Ja neatgreiž neko tad veic redirect uz index
            if(empty($row)) {
                header('Location: index.php');
                exit();
            }

            //Dabū mainīgos no datubāzes
            foreach ($data as $key => &$var) {
                if($var['type'] == FormDataType::PHONE_NUMBER) {
                    $value = explode(' ', $row[$key]);
                    $var['value'] = [
                        'country-code' => $value[0],
                        'number' => $value[1]
                    ];
                } else {
                    $var['value'] = $row[$key];
                }
            }
        }
        public static function update ($tableName, $idColumnName, &$data) {
            $id = CRUDFunctions::getID();
            $row = Database::getRowWithID($tableName, $idColumnName, $id);

            CRUDFunctions::getFormData($row, $data);
        
            //Pārbauda vai POST izsaukts
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                //Pārbauda vai save poga nospiesta
                if (isset($_POST['save'])) {
                    CRUDFunctions::performUpdateSaveAction(
                        $tableName, 
                        $idColumnName, 
                        $id, 
                        $data);
                //Pārbauda vai delete poga nospiesta
                } else if (isset($_POST['delete'])) {
                    header('Location: delete.php?id='.$id);
                    exit();
                //Pārbauda vai back poga nospiesta
                } else if (isset($_POST['back'])) {
                    header('Location: index.php');
                    exit();
                }
            }
        }
        public static function delete ($tableName, $idColumnName) {
            $id = CRUDFunctions::getID();
            //Ja nav nekas tad veic redirect uz index
            if(empty(Database::getRowWithID($tableName, $idColumnName, $id))) {
                header('Location: index.php');
                exit();
            }

            //Formas pogu funkcijas
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                //Pārbauda vai delete poga nospiesta
                if (isset($_POST['delete'])) {
                    Database::deleteWithID($tableName, $idColumnName, $id);
                    header('Location: index.php');
                //Pārbauda vai back poga nospiesta
                } else if (isset($_POST['back'])) {
                    header('Location: index.php');
                }
                exit();
            }
        }
        public static function read ($tableName, $idColumnName, $id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                //Pārbauda vai back poga nospiesta
                if (isset($_POST['back'])) {
                    header('Location: index.php');
                    exit();
                }
            }

            $row = Database::getRowWithID($tableName, $idColumnName, $id);
            
            if(empty($row)) {
                header('Location: index.php');
                exit();
            }
            return $row;
        }
    }
?>