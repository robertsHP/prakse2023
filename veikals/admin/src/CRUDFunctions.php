<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/CRUDDataProcessor.php';

    class CRUDFunctions {
        public static function create ($tableName, &$data) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
                if (isset($_POST['save'])) {
                    $hasErrors = false;

                    foreach ($data as $key => &$var) {
                        CRUDDataProcessor::assignVariable($key, $var);
                        CRUDDataProcessor::checkErrors($key, $var, $hasErrors);
                        if($var['type'] === FormDataType::FILE) {
                            FileManager::uploadFile($tableName, $var);
                        }
                    }
                    if(!$hasErrors) {
                        $success = Database::insert($tableName, $data);
                        if($success) {
                            header('Location: index.php');
                            exit();
                        }
                    }
                } else if (isset($_POST['back'])) {
                    header('Location: index.php');
                    exit();
                }
            }
        }
        private static function getID () {
            if (!isset($_GET['id'])) {
                header('Location: index.php');
                exit();
            } 
            return $_GET['id'];
        }
        public static function update ($tableName, $idColumnName, &$data) {
            $id = CRUDFunctions::getID();
            $row = Database::getRowWithID($tableName, $idColumnName, $id);
        
            //Ja neatgreiž neko tad veic redirect uz index
            if(empty($row)) {
                header('Location: index.php');
                exit();
            }

            //Piešķir vērtības no datubāzes
            foreach ($data as $key => &$arr)
                $arr['value'] = $row[$key];
        
            //Pārbauda vai POST izsaukts
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {      
                //Pārbauda vai save poga nospiesta
                if (isset($_POST['save'])) {
                    $hasErrors = false;

                    foreach ($data as $key => &$var) {
                        CRUDDataProcessor::assignVariable($key, $var, true);
                        CRUDDataProcessor::checkErrors($key, $var, $hasErrors);
                        if($var['type'] == FormDataType::FILE) {
                            if ($_FILES[$key]['name'] != '') {
                                FileManager::uploadFile($tableName, $var);
                            }
                        }
                    }
                    if(!$hasErrors) {
                        $success = Database::update($tableName, $idColumnName, $id, $data);
                        if($success) {
                            header('Location: index.php');
                            exit();
                        }
                    }
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