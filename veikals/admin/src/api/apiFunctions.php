<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Config.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';

    class APIFunctions {
        public static function getRowDataAsValueArrayWithKeys ($data, $withID = false) {
            $newDataArr = [];

            if($withID) 
                $newDataArr[$data['id-column-name']] = $data['id'];

            foreach ($data['form-data'] as $key => $var) {
                $value = $var['value'];
                $newDataArr[$key] = $value;
            }
            return $newDataArr;
        }
        public static function getRowDataAsKeyArray ($data, $withID = false) {
            $newDataArr = [];

            if($withID) $newDataArr['id'] = $data['id'];

            foreach ($data['form-data'] as $var) {
                $newKey = $var['api-col'];
                $value = $var['value'];

                $newDataArr[$newKey] = $value;
            }
            return $newDataArr;
        }
        public static function getAPIColumnNamesFromData ($data, $withID = false) {
            $newArr = [];

            if($withID) $newDataArr[] = 'id';

            $keys = array_keys($data['form-data']);
            for ($i = 0; $i < count($data['form-data']); $i++) {
                $var = $data['form-data'][$keys[$i]];
                $newKey = $var['api-col'];
                $newArr[$i] = $newKey;
            }
            return $newArr;
        }

        public static function swapLocalColNames ($arr, $columns) {
            $newArr = [];
            foreach ($columns as $apiColumn => $localColumn) {
                $newArr[$apiColumn] = $arr[$localColumn];
            }
            return $newArr;
        }
        public static function ifEmptyFields ($arr) {
            $result = false;

            foreach ($arr as $value) {
                if(strstr($value, 'id')) {
                    if ($value == 0) {
                        $result = true;
                    }
                }
                if (empty($value) || $value == '') {
                    $result = true;
                }
            }
            return $result;
        }
        public static function ifHasAllFields ($row, $columnNames) {
            $result = true;

            foreach ($columnNames as $colName) {
                if(!array_key_exists($colName, $row)) {
                    $result = false;
                }
            }

            return $result;
        }

        public static function saveAndUpdateLocalDB ($data, &$response) {
            $apiDataJSON = ApiFunctions::GET($data['api-table-name'], $response);

            if($apiDataJSON != null) {
                $localTableName = $data['table-name'];

                try {
                    $conn = Database::openConnection();

                    $idColumnName = $data['id-column-name'];

                    foreach ($apiDataJSON as $apiData) {
                        $apiID = $apiData['id'];

                        //Pieprasa rindu no datubāzes
                        $stmt = $conn->prepare("SELECT * FROM $localTableName WHERE $idColumnName=:id");
                        $stmt->bindParam(':id', $apiID, PDO::PARAM_INT);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        //Pārbauda vai eksistē
                        if($row == false) {
                            $apiColumns = ApiFunctions::getAPIColumnNamesFromData($data);
                            array_unshift($apiColumns, 'id');
                            $localColumns = array_keys($data['form-data']);
                            array_unshift($localColumns, $idColumnName);

                            //Sagatavo visus nepieciešamos nosaukums parametru pievienošanai priekš SQL komandas
                            $keysString = implode(', ', $localColumns);
                            $valuesString = ':'.implode(', :', $localColumns);

                            $stmt = $conn->prepare("INSERT INTO $localTableName ($keysString) VALUES ($valuesString)");
                            //Vērtības pievieno atbilstošām kolonām
                            for ($i = 0; $i < count($localColumns); $i++) {
                                $stmt->bindParam(
                                    ':'.$localColumns[$i], 
                                    $apiData[$apiColumns[$i]]
                                );
                            }
                            $success = $stmt->execute();

                            if($success) {
                                $response = "True - saved successfully<br>";
                            } else {
                                $response = "True - save not successful<br>";
                            }
                        } else {
                            $apiColumns = ApiFunctions::getAPIColumnNamesFromData($data);
                            $localColumns = array_keys($data['form-data']);

                            //Sagatavo visus nepieciešamos nosaukums parametru pievienošanai priekš SQL komandas
                            $keysString = $localColumns;
                            foreach ($keysString as &$name)
                                $name = $name.' = :'.$name;
                            $setString = implode(', ', $keysString);

                            $stmt = $conn->prepare("UPDATE $localTableName SET $setString WHERE $idColumnName = :id");
                            //Vērtības pievieno atbilstošām kolonām
                            for ($i = 0; $i < count($localColumns); $i++) {
                                $stmt->bindParam(
                                    ':'.$localColumns[$i], 
                                    $apiData[$apiColumns[$i]]
                                );
                            }
                            $stmt->bindParam(':id', $apiID, PDO::PARAM_INT);
                            $success = $stmt->execute();

                            if($success) {
                                $response = "True - updated successfully<br>";
                            } else {
                                $response = "False - update not successful<br>";
                            }
                        }
                    }
                    
                    Database::closeConnection($conn);
                } catch (PDOException $exception) {
                    echo "PDO Exception: " . $exception->getMessage();
                    echo "Error Code: " . $exception->getCode();
                }
            }
        }
        public static function GET ($resourceName, &$response, $index = null) {
            $token = Config::getValue('config', 'api', 'token');
            $apiAddress = Config::getValue('config', 'api', 'api_address');

            $apiAddress = $apiAddress.'/'.$resourceName;
            if($index != null) {
                if($index >= 0)
                    $apiAddress.'?id='.$index;
            }
            
            $ch = curl_init($apiAddress);
            
            $headers = [];
            $headers[] = 'Content-Type:application/json';
            $headers[] = "Authorization: Bearer ".$token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
            $result = curl_exec($ch);

            $info = curl_getinfo($ch);
            if ($info['http_code'] == 401) {
                $response = "False - not valid token";
            } else {
                $result = json_decode($result, true);
            }
        
            curl_close($ch);

            if($result == null) {
                $response = "False - no items found";
            }

            return $result;
        }
        public static function POST ($resourceName, $row, $columnNames, &$response) {
            $result = null;

            if(ApiFunctions::ifHasAllFields($row, $columnNames)) {
                if (!ApiFunctions::ifEmptyFields($row)) {
                    $token = Config::getValue('config', 'api', 'token');
                    $apiAddress = Config::getValue('config', 'api', 'api_address');
                    
                    $ch = curl_init($apiAddress.'/'.$resourceName);
                    
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type:application/json',
                        "Authorization: Bearer ".$token
                    ]);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($row));
                    
                    $result = curl_exec($ch);

                    $info = curl_getinfo($ch);
                    if ($info['http_code'] == 200) {
                        $response = "True - data inserted";
                    } else if ($info['http_code'] == 401) {
                        $response = "False - not valid token";
                    } else {
                        $response = "False - data not inserted";
                    }

                    curl_close($ch);
                } else {
                    $response = "False - some fields are empty";
                }
            } else {
                $response = "False - please add all fields";
            }

            return $result;
        }
        public static function PUT ($resourceName, $row, $columnNames, &$response) {
            $result = null;

            if(ApiFunctions::ifHasAllFields($row, $columnNames)) {
                if (!ApiFunctions::ifEmptyFields($row)) {
                    if($row['id'] != null) {
                        $apiDataJSON = ApiFunctions::GET($resourceName, $response, $row['id']);

                        if ($apiDataJSON != null) {
                            $token = Config::getValue('config', 'api', 'token');
                            $apiAddress = Config::getValue('config', 'api', 'api_address');
                            
                            $ch = curl_init($apiAddress.'/'.$resourceName);
                            
                            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                'Content-Type:application/json',
                                "Authorization: Bearer ".$token
                            ]);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($row));
                            
                            $result = curl_exec($ch);

                            $info = curl_getinfo($ch);
                            if ($info['http_code'] == 200) {
                                $response = "True - data updated";
                            } else if ($info['http_code'] == 401) {
                                $response = "False - not valid token";
                            } else {
                                $response = "False - data not updated";
                            }

                            curl_close($ch);
                        } else {
                            $response = "False - no items found";
                        }
                    } else {
                        $response = "False - no id sent";
                    }
                } else {
                    $response = "False - some fields are empty";
                }
            } else {
                $response = "False - please add all fields";
            }

            return $result;
        }
        public static function DELETE ($resourceName, $id, &$response) {
            $result = null;

            if($id != null) {
                $apiDataJSON = ApiFunctions::GET($resourceName, $response, $id);

                if ($apiDataJSON != null) {
                    $token = Config::getValue('config', 'api', 'token');
                    $apiAddress = Config::getValue('config', 'api', 'api_address');
                    
                    $ch = curl_init($apiAddress.'/'.$resourceName);
                    
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type:application/json',
                        "Authorization: Bearer ".$token
                    ]);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                        'id' => $id
                    ]));
                    
                    $result = curl_exec($ch);

                    $info = curl_getinfo($ch);
                    if ($info['http_code'] == 200) {
                        $response = "True - data deleted";
                    } else if ($info['http_code'] == 401) {
                        $response = "False - not valid token";
                    } else {
                        $response = "False - data not deleted";
                    }

                    curl_close($ch);
                } else {
                    $response = "False - no items found";
                }
            } else {
                $response = "False - no id sent";
            }

            return $result;
        }
    }
?>