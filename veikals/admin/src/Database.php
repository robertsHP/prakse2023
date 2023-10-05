
<?php
    class Database {
        // Connection settings
        private static $dbName;
        private static $dbHost;
        private static $dbUsername;
        private static $dbPassword;

        public static $clientID;
        public static $clientSecret;
        public static $redirectUri;

        // The connection object to be used and returned until disconnect() is calledgoog
        private static $connection = null;

        // returns the database connection object
        public static function getConnection() {
            // One connection through whole application
            if(self::$connection == null) {
                $ini_array = parse_ini_file(
                    $_SERVER['DOCUMENT_ROOT']."/prakse/veikals/config/config.ini", 
                    true
                );
                
                self::$dbName       = $ini_array["database"]["db_name"];
                self::$dbHost       = $ini_array["database"]["db_host"];
                self::$dbUsername   = $ini_array["database"]["db_username"];
                self::$dbPassword   = $ini_array["database"]["db_password"];
    
                self::$clientID     = $ini_array["google"]["client_id"];
                self::$clientSecret = $ini_array["google"]["client_secret"];
                self::$redirectUri  = $ini_array["google"]["redirect_uri"];
    
                try {
                    self::$connection = new PDO(
                        "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName,
                        self::$dbUsername, 
                        self::$dbPassword
                    );
                } catch(PDOException $e) {
                    die($e->getMessage());
                }
                // Tell PDO to throw exceptions when errors occur
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$connection;
        }
        public static function getUser ($email) {
            $stmt = self::$connection->prepare(
                "SELECT * FROM user WHERE email=:email"
            );
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // if (count($user) > 0) {
            //     echo $user["user_id"]." ";
            //     echo $user["name"]." ";
            //     echo $user["surname"]." ";
            //     echo $user["email"];
            // } else {
            //     echo "No results found.";
            // }
        }
    }
    Database::getConnection();
?>