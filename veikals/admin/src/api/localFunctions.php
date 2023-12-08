<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Database.php';
    require_once 'apiFunctions.php';

    function saveAndUpdateToLocalDB ($data) {
        $apiDataJSON = GET($data['api-table-name']);

        if($apiDataJSON != null) {
            $apiColumns = array_keys($data['columns']);
            $localColumns = array_values($data['columns']);
            $localTableName = $data['table-name'];

            try {
                $conn = Database::openConnection();

                $idColumnName = $localColumns[0];

                foreach ($apiDataJSON as $apiData) {
                    $id = $apiData[$apiColumns[0]];

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
                        for ($i = 0; $i < count($localColumns); $i++) {
                            $stmt->bindParam(
                                ':'.$localColumns[$i], 
                                $apiData[$apiColumns[$i]]
                            );
                        }
                        $stmt->execute();

                        echo "True - saved successfully<br>";
                    } else {
                        $idLessColumnNames = $localColumns;
                        array_shift($idLessColumnNames); // pābīda masīvu lai nebūtu id

                        //Sagatavo visus nepieciešamos nosaukums parametru pievienošanai priekš SQL komandas
                        $keysString = $idLessColumnNames;
                        foreach ($keysString as &$name)
                            $name = $name.' = :'.$name;
                        $setString = implode(', ', $keysString);

                        print_r($keysString);
                        echo '<br>';

                        $stmt = $conn->prepare("UPDATE $localTableName SET $setString WHERE $idColumnName = :id");
                        //Vērtības pievieno atbilstošām kolonām
                        for ($i = 1; $i < count($localColumns); $i++) {
                            $stmt->bindParam(
                                ':'.$localColumns[$i], 
                                $apiData[$apiColumns[$i]]
                            );
                        }
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();

                        echo "True - updated successfully<br>";
                    }
                }
                
                Database::closeConnection($conn);
            } catch (PDOException $exception) {
                echo "PDO Exception: " . $exception->getMessage();
                echo "Error Code: " . $exception->getCode();
            }
        }
    }
    function sendToAPI ($data) {
        $apiDataJSON = GET($data['api-table-name']);

        if($apiDataJSON != null) {
            $apiColumns = array_keys($data['columns']);
            $localColumns = array_values($data['columns']);
            $localTableName = $data['table-name'];

            try {
                $conn = Database::openConnection();

                $idColumnName = $localColumns[0];

                $stmt = $conn->prepare("SELECT * FROM $localTableName");
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                for ($i = 0; $i < count($rows); $i++) {
                    if(!array_key_exists($i, $apiDataJSON)) {
                        $row = $rows[$i];
                        $rowSwapped = swapLocalColNames($rows[$i], $data['columns']);
                        POST($data['api-table-name'], $rowSwapped, $apiColumns);
                        // if(!empty($response)) {
                        //     $responseData = json_decode($response, true);
                        //     if(isset($responseData['id'])) {
                        //         $stmt = $conn->prepare(
                        //             "UPDATE $localTableName SET $idColumnName = :new_id WHERE $idColumnName = :old_id"
                        //         );
                        //         $stmt->bindParam(':new_id', $responseData['id']);
                        //         $stmt->bindParam(':old_id', $row[$idColumnName]);
                        //         $stmt->execute();
                        //     }
                        // }
                    }
                }
                Database::closeConnection($conn);
            } catch (PDOException $exception) {
                echo "PDO Exception: " . $exception->getMessage();
                echo "Error Code: " . $exception->getCode();
            }
        }
    }
?>