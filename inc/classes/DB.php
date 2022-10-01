<?php

if (!defined('__CONFIG__')) {
    exit('Access Denied');
}

class DB
{
    public $host = 'localhost';
    public $port = '3306';
    public $name = 'tutorial_rest';
    public $user = 'ata';
    public $password = '123456';

    protected static $con;

    private function __construct()
    {
        try {
            self::$con = new PDO('mysql:charset=utf8mb4;host=' . ($this->host) . ';port=' . ($this->port) . ';dbname=' . ($this->name), $this->user, $this->password);
            self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$con->setAttribute(PDO::ATTR_PERSISTENT, false);
        } catch (PDOException $e) {
            print "Could not connect to database.";
            exit();
        }
    }

    public function getConnection()
    {
        if (!self::$con) {
            new DB();
        }
        return self::$con;
    }
}