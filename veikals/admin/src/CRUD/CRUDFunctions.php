<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/VariableHandler.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormErrorType.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/enums/FormDataType.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/api/apiFunctions.php';

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
                    if($var['error-type']->value == FormErrorType::NONE->value) {
                        if(is_array($var['value'])) {
                            $var['value']['name'] = FileUpload::prepareFolderPath(
                                $var['value']['name'], 
                                $data['table-name']);

                            FileUpload::uploadFile($key, $var, $hasErrors);
                            $var['value'] = $var['value']['name'];
                        }
                    }
                }
                VariableHandler::assignErrorMessage($key, $var);
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
                $row = Database::getRowWithID(
                    $data['table-name'], 
                    $data['id-column-name'], 
                    $data['id']);

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
        public static function insert ($data, $withID) {
            $id = null;
            try {
                $arr = getRowDataAsValueArrayWithKeys($data, $withID);
    
                $tableName = $data['table-name'];
    
                $keys = array_keys($arr);
                $keysString = implode(', ', $keys);
                $valuesString = ':'.implode(', :', $keys);
    
                $conn = Database::openConnection();
    
                    $stmt = $conn->prepare("INSERT INTO $tableName ($keysString) VALUES ($valuesString)");
                    foreach ($arr as $key => &$value) {
                        $stmt->bindParam(
                            ':'.$key, 
                            $value, 
                        );
                    }
                    $stmt->execute();
    
                $id = $conn->lastInsertId();
    
                Database::closeConnection($conn);
            } catch (PDOException $exception) {
                echo "PDO Exception: " . $exception->getMessage();
                echo "Error Code: " . $exception->getCode();
            }
            return $id;
        }
        public static function insertAndPOST (&$data) {
            $response = null;
            if($data['table-name'] != 'users') {
                saveAndUpdateToLocalDB($data, $response);

                $tableName = $data['api-table-name'];
                $formDataAsKeyArr = getRowDataAsKeyArray($data);
                $apiColumns = getAPIColumnNamesFromData($data);

                $result = POST(
                    $tableName, 
                    $formDataAsKeyArr, 
                    $apiColumns, 
                    $response
                );
                $result = json_decode($result, true);

                if(!empty($result)) {
                    $data['id'] = $result['id'];
                }
            }

            $id = CRUDFunctions::insert(
                $data, 
                $data['id'] != null
            );

            if ($data['id'] == null) {
                $data['id'] = $id;
            }
            return $response;
        }
    }
?>