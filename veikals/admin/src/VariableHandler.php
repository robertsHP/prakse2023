<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FileUpload.php';

    class VariableHandler {
        public static function assignFileVariable (&$key, &$var) {
            //Pārbauda vai session mainīgajā faila nosaukums ir saglabāts
            if(isset($_SESSION['temp']['paths'][$key])) {
                $var['value'] = $_SESSION['temp']['paths'][$key];
                return;
            }
            //Ja nav tad iegūst no $_FILES
            if($var['value'] == '') {
                $var['value'] = $_FILES[$key]['name'];
                //Un piešķir $_SESSION filePaths masīvam
                $_SESSION['temp']['paths'][$key] = $var['value'];
            }
        }
        public static function assignVariable (&$key, &$var) {
            //Veic darbības atkarība no mainīgā tipa
            switch ($var['type']) {
                case FormDataType::TEXT:
                case FormDataType::NUMBER:
                case FormDataType::DECIMAL:
                case FormDataType::EMAIL:
                    if(isset($_POST[$key]))
                        $var['value'] = $_POST[$key];
                    break;
                case FormDataType::FILE:
                    VariableHandler::assignFileVariable($key, $var);
                    break;
            }
        }
        public static function checkErrors (&$key, &$var) {
            $hasErrors = false;

            //Veic darbības atkarība no mainīgā tipa
            switch ($var['type']) {
                case FormDataType::TEXT:
                case FormDataType::NUMBER:
                case FormDataType::DECIMAL:
                    VariableHandler::checkErrorDefault($key, $var, $hasErrors);
                    break;
                case FormDataType::EMAIL:
                    VariableHandler::checkErrorForEmail($key, $var, $hasErrors);
                    break;
                case FormDataType::FILE:
                    VariableHandler::checkErrorForFile($key, $var, $hasErrors);
                    break;
            }
            return $hasErrors;
        }
    
        //Parbaudes visa veida mainīgajiem
        private static function checkErrorDefault (&$key, &$var, &$hasErrors) {
            if(empty($var['value'])) {
                $var['errorType'] = FormErrorType::EMPTY;
                $hasErrors = true;
            }
        }
        private static function checkErrorForEmail (&$key, &$var, &$hasErrors) {
            VariableHandler::checkErrorDefault($key, $var, $hasErrors);
            if(!filter_var($var['value'], FILTER_VALIDATE_EMAIL)) {
                $var['errorType'] = FormErrorType::EMAIL_INVALID;
                $hasErrors = true;
            }
        }
        private static function checkErrorForFile (&$key, &$var, &$hasErrors) {
            VariableHandler::checkErrorDefault($key, $var, $hasErrors);
            if($var['value'] == '') {
                $var['errorType'] = FormErrorType::EMPTY;
                $hasErrors = true;
            }
        }
    }
?>