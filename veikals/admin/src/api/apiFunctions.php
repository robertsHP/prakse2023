<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Config.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';

    function getRowDataAsValueArrayWithKeys ($data, $withID = false) {
        $newDataArr = [];

        if($withID) 
            $newDataArr[$data['id-column-name']] = $data['id'];

        foreach ($data['form-data'] as $key => $var) {
            $value = $var['value'];
            $newDataArr[$key] = $value;
        }
        return $newDataArr;
    }
    function getRowDataAsKeyArray ($data, $withID = false) {
        $newDataArr = [];

        if($withID) $newDataArr[] = $data['id'];

        foreach ($data['form-data'] as $var) {
            $newKey = $var['api-col'];
            $value = $var['value'];

            $newDataArr[$newKey] = $value;
        }
        return $newDataArr;
    }
    function getAPIColumnNamesFromData ($data) {
        $newArr = [];

        $keys = array_keys($data['form-data']);
        for ($i = 0; $i < count($data['form-data']); $i++) {
            $var = $data['form-data'][$keys[$i]];
            $newKey = $var['api-col'];
            $newArr[$i] = $newKey;
        }
        return $newArr;
    }

    function swapLocalColNames ($arr, $columns) {
        $newArr = [];
        foreach ($columns as $apiColumn => $localColumn) {
            $newArr[$apiColumn] = $arr[$localColumn];
        }
        return $newArr;
    }
    function ifEmptyFields ($arr) {
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
    function ifHasAllFields ($row, $columnNames) {
        $result = true;

        foreach ($columnNames as $colName) {
            if(!array_key_exists($colName, $row)) {
                $result = false;
            }
        }

        return $result;
    }

    function saveAndUpdateToLocalDB ($data, &$response) {
        $apiDataJSON = GET($data['api-table-name'], $response);

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
                        $apiColumns = getAPIColumnNamesFromData($data);
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
                        $stmt->execute();

                        $response = "True - saved successfully<br>";
                    } else {
                        $apiColumns = getAPIColumnNamesFromData($data);
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
                        $stmt->execute();

                        $response = "True - updated successfully<br>";
                    }
                }
                
                Database::closeConnection($conn);
            } catch (PDOException $exception) {
                echo "PDO Exception: " . $exception->getMessage();
                echo "Error Code: " . $exception->getCode();
            }
        }
    }
    // function sendToAPI ($data) {
    //     $apiDataJSON = GET($data['api-table-name']);

    //     if($apiDataJSON != null) {
    //         $apiColumns = array_keys($data['columns']);
    //         $localColumns = array_values($data['columns']);
    //         $localTableName = $data['table-name'];

    //         try {
    //             $conn = Database::openConnection();

    //             $idColumnName = $localColumns[0];

    //             $stmt = $conn->prepare("SELECT * FROM $localTableName");
    //             $stmt->execute();
    //             $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //             for ($i = 0; $i < count($rows); $i++) {
    //                 if(!array_key_exists($i, $apiDataJSON)) {
    //                     $row = $rows[$i];
    //                     $rowSwapped = swapLocalColNames($rows[$i], $data['columns']);
    //                     POST($data['api-table-name'], $rowSwapped, $apiColumns);
    //                     // if(!empty($response)) {
    //                     //     $responseData = json_decode($response, true);
    //                     //     if(isset($responseData['id'])) {
    //                     //         $stmt = $conn->prepare(
    //                     //             "UPDATE $localTableName SET $idColumnName = :new_id WHERE $idColumnName = :old_id"
    //                     //         );
    //                     //         $stmt->bindParam(':new_id', $responseData['id']);
    //                     //         $stmt->bindParam(':old_id', $row[$idColumnName]);
    //                     //         $stmt->execute();
    //                     //     }
    //                     // }
    //                 }
    //             }
    //             Database::closeConnection($conn);
    //         } catch (PDOException $exception) {
    //             echo "PDO Exception: " . $exception->getMessage();
    //             echo "Error Code: " . $exception->getCode();
    //         }
    //     }
    // }


    function GET ($resourceName, &$response, $index = null) {
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
    function POST ($resourceName, $row, $columnNames, &$response) {
        $result = null;

        if(ifHasAllFields($row, $columnNames)) {
            if (!ifEmptyFields($row)) {
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
?>