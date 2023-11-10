<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';

    class CRUDFunctions {
        private static function assignError (&$arr, &$hasErrors) {
            if(!empty($arr['value'])) {
                if ($arr['db_var_type'] == 'email') {
                    if(!filter_var($arr['value'], FILTER_VALIDATE_EMAIL)) {
                        $arr['errorType'] = FormErrorType::INVALID;
                        $hasErrors = true;
                    }
                }
            } else {
                $arr['errorType'] = FormErrorType::EMPTY;
                $hasErrors = true;
            }
        }
        public static function assignData (&$data) {
            $hasErrors = false;
            foreach ($data as $key => &$arr) {
                $arr['value'] = $_POST[$key];
                CRUDFunctions::assignError($arr, $hasErrors);
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
                    $deleteFunc($tableName, $idColumnName);
                    header('Location: index.php');
                } else if (isset($_POST['back'])) {
                    header('Location: index.php');
                }
                exit();
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
        
            foreach ($formData as $key => &$arr)
                $arr['value'] = $row[$key];
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $hasErrors = CRUDFunctions::assignData($formData);
        
                if (isset($_POST['save'])) {
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
    }
?>