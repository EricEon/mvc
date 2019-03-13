<?php

namespace Flux\Core\Database;

class Connector
{

    /**
     * @return \PDO
     */
    public static function connect()
    {
        //$dir = require "Connection.php";
        $db_driver = $_ENV['DB_TYPE'];
        $db_host = $_ENV['DB_HOST'];
        $db_name = $_ENV['DB_NAME'];
        $db_username = $_ENV['DB_USERNAME'];
        $db_password = $_ENV['DB_PASSWORD'];

        try {
            $db = new \PDO("$db_driver:host=$db_host;" . "dbname=$db_name", $db_username, $db_password,[]);
            //var_dump($db);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            if ($db) {
                return $db;
            }

        } catch (\PDOException $e) {
            //Send a generic message to the user
            echo $e->getMessage();

            //Logger::write($e->getMessage());
        }
    }

    /**
     *static function that calls the connect function
     */
    public function connection()
    {
        (new Connector)->connect();
    }
}
