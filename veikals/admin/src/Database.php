
<?php
    class Database {
        private static $connection = null;

        public static function getConnection() {
            if(self::$connection == null) {
                try {
                    require_once 'Config.php';

                    $dbHost = Config::getValue('config', 'database', 'db_host');
                    $dbName = Config::getValue('config', 'database', 'db_name');
                    $dbUsername = Config::getValue('config', 'database', 'db_username');
                    $dbPassword = Config::getValue('config', 'database', 'db_password');

                    self::$connection = new PDO(
                        "mysql:host=".$dbHost.";"."dbname=".$dbName,
                        $dbUsername, 
                        $dbPassword
                    );
                } catch(PDOException $e) {
                    die($e->getMessage());
                }
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$connection;
        }
        public static function closeConnection () {
            self::$connection = null;
        }
    }
?>