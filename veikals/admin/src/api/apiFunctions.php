<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Config.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
?>

<?php
    function getAPIDataAsJSON ($resourceName) {
        $token = Config::getValue('config', 'api', 'token');
        $apiAddress = Config::getValue('config', 'api', 'api_address');
        
        /* Init cURL resource */
        $ch = curl_init($apiAddress.'/'.$resourceName);
        
        /* set the content type json */
        $headers = [];
        $headers[] = 'Content-Type:application/json';
        $headers[] = "Authorization: Bearer ".$token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
        /* set return type json */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
        /* execute request */
        $result = curl_exec($ch);
    
        if($error = curl_error($ch)) {
            echo $e;
            $result = null;
        } else {
            $result = json_decode($result, true);
        }
    
        /* close cURL resource */
        curl_close($ch);

        return $result;
    }
    function refreshDBInfoFor ($apiTableName, $localTableName, $columns) {
        $apiDataJSON = getAPIDataAsJSON($apiTableName);

        // print_r($apiDataJSON);

        $apiColumns = array_keys($columns);
        $localColumns = array_values($columns);

        try {
            $conn = Database::openConnection();

            $idColumnName = $localColumns[0];

            foreach ($apiDataJSON as $apiData) {
                $id = $apiData['id'];

                //Pieprasa rindu no datubāzes
                $stmt = $conn->prepare("SELECT * FROM $localTableName WHERE $idColumnName=:id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                //Pārbauda vai eksistē
                if($row == false) {
                    //Sagatavo visus nepieciešamos nosaukums parametru pievienošanai priekš SQL komandas
                    $keysString = implode(', ', $localColumns);
                    $valuesString = ':'.implode(', :', $localColumns);

                    $stmt = $conn->prepare("INSERT INTO $localTableName ($keysString) VALUES ($valuesString)");
                    //Vērtības pievieno atbilstošām kolonām
                    for ($i = 0; $i < count($columns); $i++) {
                        $stmt->bindParam(
                            ':'.$localColumns[$i], 
                            $apiData[$apiColumns[$i]]
                        );
                    }
                    $stmt->execute();
                } else {
                    $idLessColumnNames = $localColumns;
                    array_shift($idLessColumnNames); // pābīda masīvu lai nebūtu id

                    //Sagatavo visus nepieciešamos nosaukums parametru pievienošanai priekš SQL komandas
                    $keysString = $idLessColumnNames;
                    foreach ($keysString as &$name)
                        $name = $name.' = :'.$name;
                    $setString = implode(', ', $keysString);

                    $stmt = $conn->prepare("UPDATE $localTableName SET $setString WHERE $idColumnName = :id");
                    //Vērtības pievieno atbilstošām kolonām
                    for ($i = 1; $i < count($columns); $i++) {
                        $stmt->bindParam(
                            ':'.$localColumns[$i], 
                            $apiData[$apiColumns[$i]]
                        );
                    }
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
            
            Database::closeConnection($conn);
        } catch (PDOException $exception) {
            echo "PDO Exception: " . $exception->getMessage();
            echo "Error Code: " . $exception->getCode();
        }
    }
?>