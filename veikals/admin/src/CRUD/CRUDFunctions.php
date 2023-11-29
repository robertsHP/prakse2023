<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/VariableHandler.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    class CRUDFunctions {
        public static function assignAndProcessFormData (&$formData, &$data) {
            $hasErrors = false;
            //Pievieno visas formas vērtības $data masīvam
            foreach ($formData as $key => &$tempVar) {
                $var = &$data['form-data'][$key];
                $var['value'] = $tempVar;

                VariableHandler::processVariable($key, $var, $hasErrors);

                //Augšupielādē failu
                if($var['type'] == FormDataType::FILE->value) {
                    // echo '<p>'.$var['error-type']->value.'</p>';
                    if($var['error-type']->value == FormErrorType::NONE->value) {
                        $var['value'] = FileUpload::prepareFolderPath(
                            $var['value'], 
                            $data['table-name']);

                        // echo '<p>'.$var['value'].'</p>';
                        FileUpload::uploadFile($key, $var, $hasErrors);
                    }
                }
                VariableHandler::assignErrorMessage($key, $var, $data['error-tags']);
            }
            return $hasErrors;
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
            if(isset($data['id'])) {
                $row = Database::getRowWithID($data['table-name'], $data['id-column-name'], $data['id']);

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