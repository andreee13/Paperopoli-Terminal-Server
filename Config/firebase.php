<?php

use Kreait\Firebase\Factory;

class Firebase {
    
    private static $firebase = null;
    private static $auth = null;
    private static $messaging = null;

    private function __construct() {}

    private static function init() {
        if(is_null(self::$firebase)) {
            self::$firebase = (new Factory)->withServiceAccount(ROOT . '/Config/paperopoli-terminal-firebase-adminsdk-26ul1-99fb7b1c83.json');
        }
        if (is_null(self::$auth)) {
            self::$auth = self::$firebase->createAuth();
        }
        if (is_null(self::$messaging)) {
            self::$messaging = self::$firebase->createMessaging();
        }
    }

    public static function getAuth()
    {
        self::init();
        return self::$auth;
    }

    public static function getMessaging()
    {
        self::init();
        return self::$messaging;
    }
}
