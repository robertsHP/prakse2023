<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/veikals/admin/src/Database.php';

    class CRUDFunctions {
        private static function isDataValid (&$data) {
            foreach ($data as $key => &$arr) {
                if(empty($arr['value']))
                    return false;
                
                if ($arr['type'] == 'email') {
                    if(!filter_var($arr['value'], FILTER_VALIDATE_EMAIL))
                        return false;
                }
            }
            return true;
        }
        private static function create ($tableName, $data) {
            foreach ($data as $key => &$arr)
                $arr['value'] = $_POST[$key];

            if(CRUDFunctions::isDataValid($data)) {
                $keys = array_keys($data);
                $keysString = implode(', ', $keys);
                $valuesString = ':'.implode(', :', $keys);

                $conn = Database::openConnection();

                    $stmt = $conn->prepare("INSERT INTO $tableName ($keysString) VALUES ($valuesString)");
                    foreach ($data as $key => &$arr) {
                        $stmt->bindParam(':'.$key, $arr['value'], $arr['type']);
                    }
                    $stmt->execute();

                Database::closeConnection($conn);
                return true;
            }
            return false;
        }
        public static function processCreate ($tableName, $data) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['save'])) {
                    $success = CRUDFunctions::create($tableName, $data);
                    if($success) {
                        header('Location: index.php');
                        exit();
                    }
                } else if (isset($_POST['back'])) {
                    header('Location: index.php');
                    exit();
                }
            }
        }
        private static function getIDFromGET ($tableName, $idColumnName) {
            //Pārbauda vai tika padots ID
            if (!isset($_GET['id'])) {
                return null;
            }
            
            $id = $_GET['id'];

            //Ja nav nekas tad veic redirect uz index
            if(empty(Database::getRowFrom($tableName, $idColumnName, $id, PDO::PARAM_INT))) {
                return null;
            }
            
            return $id;
        }
        public static function processDelete ($tableName, $idColumnName) {
            //Pārbauda vai tika padots ID
            if (!isset($_GET['id'])) {
                header('Location: index.php');
                exit();
            }
            $id = $_GET['id'];
            //Ja nav nekas tad veic redirect uz index
            if(empty(Database::getRowFrom($tableName, $idColumnName, $id, PDO::PARAM_INT))) {
                header('Location: index.php');
                exit();
            }

            //Formas pogu funkcijas
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['delete'])) {
                    $conn = Database::openConnection();

                    $stmt = $conn->prepare("DELETE FROM $tableName WHERE $idColumnName = :id");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();

                    Database::closeConnection($conn);
                    header('Location: index.php');
                } else if (isset($_POST['back'])) {
                    header('Location: index.php');
                }
                exit();
            }
        }
        private static function update ($tableName, $idColumnName, $id, &$data) {
            //piešķir visus POST mainīgos
            foreach ($data as $key => &$arr)
                $arr['value'] = $_POST[$key];

            if(CRUDFunctions::isDataValid($data)) {
                $keys = array_keys($data);
                foreach ($keys as &$key)
                    $key = $key.' = :'.$key;
                $setString = implode(', ', $keys);

                $conn = Database::openConnection();

                    $stmt = $conn->prepare("UPDATE $tableName SET $setString WHERE $idColumnName = :id");
                    foreach ($data as $key => &$arr) {
                        $stmt->bindParam(':'.$key, $arr['value'], $arr['type']);
                    }
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();

                Database::closeConnection($conn);
                return true;
            }
            return false;
        }
        public static function processUpdate ($tableName, $idColumnName, &$data) {
            //Pārbauda vai tika padots ID
            if (!isset($_GET['id'])) {
                header('Location: index.php');
                exit();
            }
            $id = $_GET['id'];
            $row = Database::getRowFrom($tableName, $idColumnName, $id, PDO::PARAM_INT);

            //Ja nav nekas tad veic redirect uz index
            if(empty($row)) {
                header('Location: index.php');
                exit();
            }

            foreach ($data as $key => &$arr)
                $arr['value'] = $row[$key];

            //Formas pogu funkcijas
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['save'])) {
                    $success = CRUDFunctions::update(
                        $tableName,
                        $idColumnName,
                        $id,
                        $data
                    ); 
                    if($success) {
                        header('Location: index.php');
                        exit();
                    }
                } else if (isset($_POST['delete'])) {
                    header('Location: delete.php?id='.$id);
                    exit();
                } else if (isset($_POST['back'])) {
                    header('Location: index.php');
                    exit();
                }
            }
        }
    }
?>