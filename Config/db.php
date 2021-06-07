<?php

class Database {
    
    private static $db = null;

    private function __construct() {}

    public static function getDb() {
        if(is_null(self::$db)) {
            self::$db = new mysqli('localhost', 'root', 'qwerty123', DB_NAME);
        }
        return self::$db;
    }
}
?>
