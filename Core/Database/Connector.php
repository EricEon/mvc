<?php

namespace Flux\Core\Database;


class Connector
{


    /**
     * @return \PDO
     */
    public static function connect()
    {
        $dir = require "Connection.php";
//        $dir = 'Core/Database/Connection.php';
//         if(!file_exists($dir)){
//             echo "check file availability";
//         }else{
//             print_r($dir);
//         }
        try {
            $db = new \PDO($mysql['db_driver'].':host='.$mysql['db_host'].';'.'dbname='.$mysql['db_name'],$mysql['db_username'],$mysql['db_password']);
            //var_dump($db);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            if($db){
                 return $db;
            }
           
        } catch (\PDOException $e) {
            //Send a generic message to the user
            echo $e->getMessage();
            //echo "There is a problem, check the log files.";
            
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