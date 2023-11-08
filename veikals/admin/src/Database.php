
<?php
    class Database {
        public static function openConnection() {
            try {
                require_once 'Config.php';

                $dbHost = Config::getValue('config', 'database', 'db_host');
                $dbName = Config::getValue('config', 'database', 'db_name');
                $dbUsername = Config::getValue('config', 'database', 'db_username');
                $dbPassword = Config::getValue('config', 'database', 'db_password');

                $con = new PDO(
                    "mysql:host=".$dbHost.";"."dbname=".$dbName,
                    $dbUsername, 
                    $dbPassword
                );
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $con;
            } catch(PDOException $e) {
                die($e->getMessage());
            }
            return null;
        }
        public static function closeConnection ($con) {
            $con = null;
        }
        public static function getRowFrom ($tableName, $colName, $var, $varType) {
            $conn = Database::openConnection();

            $stmt = $conn->prepare("SELECT * FROM $tableName WHERE $colName=:id");
            $stmt->bindParam(':id', $var, $varType);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            Database::closeConnection($conn);

            return $result;
        }
        public static function getAllRowsFrom ($tableName) {
            $conn = Database::openConnection();

            $stmt = $conn->prepare('SELECT * FROM '.$tableName);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            Database::closeConnection($conn);

            return $result;
        }
    }
?>