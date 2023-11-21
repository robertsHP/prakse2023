<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';
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

        private static function assignDefaultVariable (&$key, &$var, &$hasErrors) {
            if(isset($_POST[$key]))
                $var['value'] = $_POST[$key];

            if(empty($var['value'])) {
                $var['errorType'] = FormErrorType::EMPTY;
                $hasErrors = true;
            }
        }
        private static function assignEmailVariable (&$key, &$var, &$hasErrors) {
            if(isset($_POST[$key]))
                $var['value'] = $_POST[$key];

            if(empty($var['value'])) {
                $var['errorType'] = FormErrorType::EMPTY;
                $hasErrors = true;
            }

            if(!filter_var($var['value'], FILTER_VALIDATE_EMAIL)) {
                $var['errorType'] = FormErrorType::EMAIL_INVALID;
                $hasErrors = true;
            }
        }
        private static function assignFileVariable (&$key, &$var, &$hasErrors) {
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

            if(empty($var['value']) || $var['value'] == '') {
                $var['errorType'] = FormErrorType::EMPTY;
                $hasErrors = true;
            }
        }
        private static function assignPhoneNumberVariable (&$key, &$var, &$hasErrors) {
            $ccTag = $key.'-cc';
            $numTag = $key.'-phone-number';

            $countryCodeSet = isset($_POST[$ccTag]);
            $numberSet = isset($_POST[$numTag]);

            if($countryCodeSet && $numberSet) {
                $countryCodeEmpty = empty($_POST[$ccTag]);
                $numberEmpty = empty($_POST[$numTag]);

                if($countryCodeEmpty && $numberEmpty) {
                    $var['errorType'] = FormErrorType::EMPTY;
                    $hasErrors = true; 
                }

                $countryCode = $_POST[$ccTag];
                $phoneNum = $_POST[$numTag];

                if(strlen($countryCode) < 4 || strlen($phoneNum) < 8) {
                    $var['errorType'] = FormErrorType::PHONE_NUMBER_INVALID;
                    $hasErrors = true; 
                }

                $var['value'] = [
                    'country-code' => $_POST[$ccTag],
                    'number' => $_POST[$numTag]
                ];
            }
        }
    }
?>