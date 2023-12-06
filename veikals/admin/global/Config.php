
<?php
    class Config {
        private static $data = array();

        public static function readAllFiles () {
            if (empty(self::$data)) {
                self::$data["config"] = parse_ini_file(
                    $_SERVER['DOCUMENT_ROOT']."/veikals/config/config.ini", 
                    true
                );
                self::$data["settings"] = parse_ini_file(
                    $_SERVER['DOCUMENT_ROOT']."/veikals/config/settings.ini", 
                    true
                );
            }
        }
        public static function getValue ($fileName, $sectionName, $valueName) {
            return self::$data[$fileName][$sectionName][$valueName];
        }
    }

    Config::readAllFiles();
?>