<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/FileUpload.php';

    class VariableHandler {
        private static function sanitizeValue (&$value) {
            $value = htmlspecialchars(
                trim($value), 
                ENT_QUOTES, 
                'UTF-8');
        }
        public static function processVariable (&$key, &$var, &$hasErrors) {
            $var['error-type'] = FormErrorType::NONE;

            // echo '<p>'.print_r($var). '</p>';

            //Veic darbības atkarība no mainīgā tipa
            switch ($var['type']) {
                case FormDataType::TEXT->value:
                case FormDataType::NUMBER->value:
                case FormDataType::DECIMAL->value:
                    VariableHandler::defaultVariableErrorCheck($key, $var, $hasErrors);
                    break;
                case FormDataType::EMAIL->value:
                    VariableHandler::emailVariableErrorCheck($key, $var, $hasErrors);
                    break;
                case FormDataType::FILE->value:
                    VariableHandler::fileVariableErrorCheck($key, $var, $hasErrors);
                    break;
                case FormDataType::PHONE_NUMBER->value:
                    VariableHandler::phoneNumberVariableErrorCheck($key, $var, $hasErrors);
                    break;
                case FormDataType::DATE->value:
                    VariableHandler::dateVariableErrorCheck($key, $var, $hasErrors);
                    break;
            }
        }

        public static function assignErrorMessage (&$key, &$var) {
            $errorCondition = $var['error-type'];

            if($errorCondition->value != FormErrorType::NONE->value) {
                if(isset($var['error-conditions'][$errorCondition->value])) {
                    $var['error-message'] = $var['error-conditions'][$errorCondition->value];
                    return;
                }
            }
            $errorTag['error-message'] = null;
        }

        private static function checkIfEmpty (&$var, &$hasErrors) {
            if(empty($var['value']) || $var['value'] == '') {
                $var['error-type'] = FormErrorType::EMPTY;
                $hasErrors = true;
                return true;
            }
            return false;
        }

        private static function defaultVariableErrorCheck (&$key, &$var, &$hasErrors) {
            VariableHandler::sanitizeValue($var['value']);
            VariableHandler::checkIfEmpty($var, $hasErrors);
        }
        private static function emailVariableErrorCheck (&$key, &$var, &$hasErrors) {
            VariableHandler::sanitizeValue($var['value']);
            $empty = VariableHandler::checkIfEmpty($var, $hasErrors);

            if(!$empty) {
                if(!filter_var($var['value'], FILTER_VALIDATE_EMAIL)) {
                    $var['error-type'] = FormErrorType::EMAIL_INVALID;
                    $hasErrors = true;
                }
            }
        }
        public static function fileVariableErrorCheck (&$key, &$var, &$hasErrors) {
            // echo '<p>'.print_r($var). '</p>';

            if(isset($var['value']['tmp_name']) && isset($var['value']['name'])) {
                $tmpName = $var['value']['tmp_name'];
                $name = $var['value']['name'];
    
                $tempEmpty = empty($tmpName) || $tmpName == '';
                $nameEmpty = empty($name) || $name == '';
    
                if($tempEmpty || $nameEmpty) {
                    $var['error-type'] = FormErrorType::EMPTY;
                    $hasErrors = true;
                }
                $var['value'] = [
                    'tmp_name' => $tmpName,
                    'name' => $name
                ];
            } else {
                $var['value'] = null;
            }
        }
        private static function phoneNumberVariableErrorCheck (&$key, &$var, &$hasErrors) {
            VariableHandler::sanitizeValue($var['value']);
            $empty = VariableHandler::checkIfEmpty($var, $hasErrors);
            
            if(!$empty) {
                if($var['value'][0] !== '+') {
                    $var['error-type'] = FormErrorType::PHONE_NUMBER_INVALID;
                    $hasErrors = true;
                }
            }
        }
        private static function isValidDate($dateString) {
            $dateFormats = [
                'Y-m-d',
                'd/m/Y',
                'm/d/Y',
            ];
            //Iziet cauri visien datumu formātiem
            foreach ($dateFormats as $format) {
                $dateTime = DateTime::createFromFormat($format, $dateString);
                $errors = DateTime::getLastErrors();

                //Pārbauda vai tika veiksmīgi izveidots
                if($errors == null)
                    if ($dateTime !== false)
                        return true;
            }
            return false;
        }
        private static function dateVariableErrorCheck (&$key, &$var, &$hasErrors) {
            VariableHandler::sanitizeValue($var['value']);
            $empty = VariableHandler::checkIfEmpty($var, $hasErrors);

            if(!$empty) {
                if (!VariableHandler::isValidDate($var['value'])) {
                    $var['error-type'] = FormErrorType::DATE_INVALID;
                    $hasErrors = true;
                }
            }
        }
    }
?>