<?php

namespace Test;


class App
{
    /**
     * @var \PDO
     */
    private static $db;
    
    public static function db()
    {
        if (empty(self::$db)) {
            $config = include __DIR__ .'/config.php';
            $db = $config['db'];
            
            self::$db = new \PDO('mysql:host='.$db['host'].';dbname='.$db['db'], $db['user'], $db['pass']);
            self::$db->query("SET NAMES 'utf8';");
        }

        return self::$db;
    }
}