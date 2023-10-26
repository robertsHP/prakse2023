
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
    }
?>