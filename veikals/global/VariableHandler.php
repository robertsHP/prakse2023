<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/FileUpload.php';

    class VariableHandler {
        public static function assignVariable (&$key, &$var, &$hasErrors, &$errorTags) {
            $var['error-type'] = FormErrorType::NONE;

            //Veic darbības atkarība no mainīgā tipa
            switch ($var['type']) {
                case FormDataType::TEXT->value:
                case FormDataType::NUMBER->value:
                case FormDataType::DECIMAL->value:
                    VariableHandler::assignDefaultVariable($key, $var, $hasErrors);
                    break;
                case FormDataType::EMAIL->value:
                    VariableHandler::assignEmailVariable($key, $var, $hasErrors);
                    break;
                case FormDataType::FILE->value:
                    VariableHandler::assignFileVariable($key, $var, $hasErrors);
                    break;
                case FormDataType::PHONE_NUMBER->value:
                    VariableHandler::assignPhoneNumberVariable($key, $var, $hasErrors);
                    break;
                case FormDataType::DATE->value:
                    VariableHandler::assignDateVariable($key, $var, $hasErrors);
                    break;
            }

            // echo "<p>".$var['error-type']->value."</p>";

            $errorTag = &$errorTags[$key];
            $errorCondition = $var['error-type'];

            if($errorCondition->value != FormErrorType::NONE->value) {
                if(isset($errorTag['error-conditions'][$errorCondition->value])) {
                    $errorTag['error-message'] = $errorTag['error-conditions'][$errorCondition->value];
                    return;
                }
            }
            $errorTag['error-message'] = null;
        }

        public static function getSanitizedValue ($value) {
            $value = trim($value);
            return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }

        private static function checkIfEmpty (&$var, &$hasErrors) {
            if(empty($var['value']) || $var['value'] == '') {
                $var['error-type'] = FormErrorType::EMPTY;
                $hasErrors = true;
                return true;
            }
            return false;
        }

        private static function assignDefaultVariable (&$key, &$var, &$hasErrors) {
            if(isset($_POST[$key]))
                $var['value'] = VariableHandler::getSanitizedValue($_POST[$key]);

            VariableHandler::checkIfEmpty($var, $hasErrors);
        }
        private static function assignEmailVariable (&$key, &$var, &$hasErrors) {
            if(isset($_POST[$key]))
                $var['value'] = VariableHandler::getSanitizedValue($_POST[$key]);

            $empty = VariableHandler::checkIfEmpty($var, $hasErrors);

            if(!$empty) {
                if(!filter_var($var['value'], FILTER_VALIDATE_EMAIL)) {
                    $var['error-type'] = FormErrorType::EMAIL_INVALID;
                    $hasErrors = true;
                }
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

            VariableHandler::checkIfEmpty($var, $hasErrors);
        }
        private static function assignPhoneNumberVariable (&$key, &$var, &$hasErrors) {
            if(isset($_POST[$key]))
                $var['value'] = VariableHandler::getSanitizedValue($_POST[$key]);

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
        private static function assignDateVariable (&$key, &$var, &$hasErrors) {
            if(isset($_POST[$key]))
                $var['value'] = VariableHandler::getSanitizedValue($_POST[$key]);

            $empty = VariableHandler::checkIfEmpty($var, $hasErrors);

            // echo '<p>'.$var['value'].'</p>';
            if(!$empty) {
                // echo '<p>'.$var['value'].'</p>';
                if (!VariableHandler::isValidDate($var['value'])) {
                    // echo '<p>'.$var['value'].'</p>';
                    $var['error-type'] = FormErrorType::DATE_INVALID;
                    $hasErrors = true;
                }
            }
        }
    }
?>