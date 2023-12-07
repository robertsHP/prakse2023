<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/global/Config.php';

    function GET ($resourceName, $index = null) {
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
            echo "False - not valid token<br>";
        } else {
            $result = json_decode($result, true);
        }
    
        curl_close($ch);

        if($result == null) {
            echo "False - no items found<br>";
        }

        return $result;
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
    function POST ($resourceName, $row, $columnNames) {
        $response = null;

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
                
                $response = curl_exec($ch);

                $info = curl_getinfo($ch);
                if ($info['http_code'] == 200) {
                    echo "True - data inserted<br>";
                } else if ($info['http_code'] == 401) {
                    echo "False - not valid token<br>";
                } else {
                    echo "False - data not inserted<br>";
                }

                curl_close($ch);
            } else {
                echo "False - some fields are empty<br>";
            }
        } else {
            echo "False - please add all fields<br>";
        }
        return $response;
    }
?>