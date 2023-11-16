<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormDataType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/FileManager.php';

    class CRUDDataProcessor {
        public static function assignVariable (&$key, &$var, $ignoreEmpty = false) {
            // echo $var['value'];
            switch ($var['type']) {
                case FormDataType::TEXT:
                case FormDataType::NUMBER:
                case FormDataType::DECIMAL:
                case FormDataType::EMAIL:
                    if(isset($_POST[$key]))
                        $var['value'] = $_POST[$key];
                    break;
                case FormDataType::FILE:
                    if ($ignoreEmpty) {
                        if (isset($_FILES[$key])) {
                            if ($_FILES[$key]['name'] != '') {
                                $var['value'] = $_FILES[$key]['name'];
                            }
                        }
                    } else {
                        if (isset($_FILES[$key]))
                            $var['value'] = $_FILES[$key]['name'];
                    }
                    break;
            }
        }

        //Parbaudes visiem mainīgo veidiem
        private static function checkErrorDefault (&$key, &$var, &$hasErrors) {
            if(empty($var['value'])) {
                $var['errorType'] = FormErrorType::EMPTY;
                $hasErrors = true;
            }
        }
        private static function checkErrorForEmail (&$key, &$var, &$hasErrors) {
            CRUDDataProcessor::checkErrorDefault($key, $var, $hasErrors);
            if(!filter_var($var['value'], FILTER_VALIDATE_EMAIL)) {
                $var['errorType'] = FormErrorType::EMAIL_INVALID;
                $hasErrors = true;
            }
        }
        private static function checkErrorForFile (&$key, &$var, &$hasErrors) {
            CRUDDataProcessor::checkErrorDefault($key, $var, $hasErrors);
            if($var['value'] == '') {
                echo $var['value'];
                $var['errorType'] = FormErrorType::EMPTY;
                $hasErrors = true;
            }
        }
        public static function checkErrors (&$key, &$var, &$hasErrors) {
            switch ($var['type']) {
                case FormDataType::TEXT:
                case FormDataType::NUMBER:
                case FormDataType::DECIMAL:
                    CRUDDataProcessor::checkErrorDefault($key, $var, $hasErrors);
                    break;
                case FormDataType::EMAIL:
                    CRUDDataProcessor::checkErrorForEmail($key, $var, $hasErrors);
                    break;
                case FormDataType::FILE:
                    CRUDDataProcessor::checkErrorForFile($key, $var, $hasErrors);
                    break;
            }
        }
    }
?>