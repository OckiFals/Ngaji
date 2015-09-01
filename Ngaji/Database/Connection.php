<?php namespace Ngaji\Database;
/**
 * Class Connection
 * @package Ngaji\Database
 * @author Ocki Bagus Pratama
 * @since 1.0
 */

use PDO;
use PDOException;

class Connection {
    public static $dbDriver;
    public static $dbName;
    private static $dbHost;
    private static $dbUsername;
    private static $dbUserPassword;

    private static $cont = null;

    public function __construct() {
        die('Init function is not allowed');
    }

    public static function setConfig($dbConfig) {
        self::$dbDriver = $dbConfig['driver'];
        self::$dbName = $dbConfig['name'];
        self::$dbHost = $dbConfig['host'];
        self::$dbUsername = $dbConfig['user'];
        self::$dbUserPassword = $dbConfig['pass'];
    }

    public static function connect() {
        # One connection through whole application
        if (null == self::$cont) {
            try {
                if ('mysql' === self::$dbDriver) {
                    self::$cont = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" .
                        self::$dbName, self::$dbUsername, self::$dbUserPassword);
                } else if ('sqlite' === self::$dbDriver) {
                    self::$cont = new PDO("sqlite:" . self::$dbName);
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }

    public static function disconnect() {
        self::$cont = null;
    }
}