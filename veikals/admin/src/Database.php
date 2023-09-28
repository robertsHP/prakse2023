
<?php
    class Database {
        // Connection settings
        private static $dbName;
        private static $dbHost;
        private static $dbUsername;
        private static $dbPassword;

        // The connection object to be used and returned until disconnect() is called
        private static $connection = null;

        // Default constructor. Must not be called, so the script dies when done so
        public function __construct() {
            die('Init function is not allowed');
        }

        // returns the database connection object
        public static function connect() {
            $ini_array = parse_ini_file("config/config.ini");
            
            self::$dbName       = $ini_array["db_name"];
            self::$dbHost       = $ini_array["db_host"];
            self::$dbUsername   = $ini_array["db_username"];
            self::$dbPassword   = $ini_array["db_password"];

            // One connection through whole application
            if(null == self::$connection) {
                try {
                    self::$connection = new PDO(
                        "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, 
                        self::$dbUsername, 
                        self::$dbPassword
                    );
                }
                catch(PDOException $e) {
                    die($e->getMessage());
                }
            }
            // Tell PDO to throw exceptions when errors occur
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Finally, return the connection
            return self::$connection;
        }

        // Disconnect
        public static function disconnect() {
            self::$connection = null;
        }
    }
?>