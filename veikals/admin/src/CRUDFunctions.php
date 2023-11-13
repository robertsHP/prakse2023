<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormDataType.php';

    class CRUDFunctions {
        public static function assignData (&$data) {
            $hasErrors = false;
            foreach ($data as $key => &$arr) {
                if(isset($_POST[$key])) 
                    $arr['value'] = $_POST[$key];
                require 'valueErrorCheck.php';
            }
            return $hasErrors;
        }
        public static function create ($tableName, &$formData, $saveFunc) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $hasErrors = CRUDFunctions::assignData($formData);
        
                if (isset($_POST['save'])) {
                    if(!$hasErrors) {
                        $saveFunc($tableName, $formData);
                    }
                } else if (isset($_POST['back'])) {
                    header('Location: index.php');
                    exit();
                }
            }
        }
        public static function update ($tableName, $idColumnName, &$formData, $saveFunc) {
            if (!isset($_GET['id'])) {
                header('Location: index.php');
                exit();
            } 
            $id = $_GET['id'];
            $row = Database::getRowWithID($tableName, $idColumnName, $id);
        
            //Ja nav nekas tad veic redirect uz index
            if(empty($row)) {
                header('Location: index.php');
                exit();
            }
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {      
                if (isset($_POST['save'])) {
                    $hasErrors = CRUDFunctions::assignData($formData);
                    if(!$hasErrors) {
                        $saveFunc($tableName, $idColumnName, $id, $formData);
                    }
                } else if (isset($_POST['delete'])) {
                    header('Location: delete.php?id='.$id);
                    exit();
                } else if (isset($_POST['back'])) {
                    header('Location: index.php');
                    exit();
                }
            } else {
                foreach ($formData as $key => &$arr)
                    $arr['value'] = $row[$key];
            }
        }
        public static function delete ($tableName, $idColumnName, $deleteFunc) {
            if (!isset($_GET['id'])) {
                header('Location: index.php');
                exit();
            } 
            $id = $_GET['id'];
            //Ja nav nekas tad veic redirect uz index
            if(empty(Database::getRowWithID($tableName, $idColumnName, $id))) {
                header('Location: index.php');
                exit();
            }

            //Formas pogu funkcijas
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['delete'])) {
                    $deleteFunc($tableName, $idColumnName, $id);
                    header('Location: index.php');
                } else if (isset($_POST['back'])) {
                    header('Location: index.php');
                }
                exit();
            }
        }
        public static function read ($tableName, $idColumnName, $id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        public static function uploadFile ($folderName, $tagName, &$formData) {
            $success = false;
            //Piešķir pareizo ceļu uz izvēlēto failu
            $targetDir = '/veikals/files/'.$folderName.'/';
            $file = $_FILES[$tagName];
            $formData[$tagName]['value'] = $targetDir.$file['name'];
            
            include $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/fileUpload.php';
            return $success;
        }
    }
?>