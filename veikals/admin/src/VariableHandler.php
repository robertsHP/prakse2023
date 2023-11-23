<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/elements/enums/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/elements/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FileUpload.php';

    class VariableHandler {
        public static function assignVariable (&$key, &$var, &$hasErrors) {
            //Veic darbības atkarība no mainīgā tipa
            switch ($var['type']) {
                case FormDataType::TEXT:
                case FormDataType::NUMBER:
                case FormDataType::DECIMAL:
                    VariableHandler::assignDefaultVariable($key, $var, $hasErrors);
                    break;
                case FormDataType::EMAIL:
                    VariableHandler::assignEmailVariable($key, $var, $hasErrors);
                    break;
                case FormDataType::FILE:
                    VariableHandler::assignFileVariable($key, $var, $hasErrors);
                    break;
                case FormDataType::PHONE_NUMBER:
                    VariableHandler::assignPhoneNumberVariable($key, $var, $hasErrors);
                    break;
            }
        }

        public static function getSanitizedValue ($value) {
            $value = trim($value);
            return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }

        private static function assignDefaultVariable (&$key, &$var, &$hasErrors) {
            if(isset($_POST[$key]))
                $var['value'] = VariableHandler::getSanitizedValue($_POST[$key]);

            if(empty($var['value'])) {
                $var['errorType'] = FormErrorType::EMPTY;
                $hasErrors = true;
            }
        }
        private static function assignEmailVariable (&$key, &$var, &$hasErrors) {
            if(isset($_POST[$key]))
                $var['value'] = VariableHandler::getSanitizedValue($_POST[$key]);

            if(empty($var['value'])) {
                $var['errorType'] = FormErrorType::EMPTY;
                $hasErrors = true;
            }

            if(!filter_var($var['value'], FILTER_VALIDATE_EMAIL)) {
                $var['errorType'] = FormErrorType::EMAIL_INVALID;
                $hasErrors = true;
            }
        }
        public static function assignFileVariable (&$key, &$var, &$hasErrors) {
            //Pārbauda vai session mainīgajā faila nosaukums ir saglabāts
            if(isset($_SESSION['temp']['paths'][$key])) {
                $var['value'] = VariableHandler::getSanitizedValue($_SESSION['temp']['paths'][$key]);
            //Ja nav tad iegūst no $_FILES
            } else if($var['value'] == '') {
                $var['value'] = VariableHandler::getSanitizedValue($_FILES[$key]['name']);
                //Un piešķir $_SESSION filePaths masīvam
                $_SESSION['temp']['paths'][$key] = $var['value'];
            }

            if(empty($var['value']) || $var['value'] == '') {
                $var['errorType'] = FormErrorType::EMPTY;
                $hasErrors = true;
            }
        }
        private static function assignPhoneNumberVariable (&$key, &$var, &$hasErrors) {
            if(isset($_POST[$key]))
                $var['value'] = VariableHandler::getSanitizedValue($_POST[$key]);

            if(empty($var['value']) || $var['value'] == '') {
                $var['errorType'] = FormErrorType::EMPTY;
                $hasErrors = true; 
            } else if($var['value'][0] !== '+') {
                $var['errorType'] = FormErrorType::PHONE_NUMBER_INVALID;
                $hasErrors = true;
            }
        }
    }
?>