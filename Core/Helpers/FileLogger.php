<?php

namespace Flux\Helpers;

use Flux\Interfaces\LoggerInterface;


class FileLogger implements LoggerInterface
{

    /**
     * @var		mixed	$file
     */
    public static $file;

    
    public static function check(){
        $file = $_ENV['LOG_FILE_DIR'];
        if (file_exists($file)) {
            FileLogger::$file = $file;
            $Logger = new static;
            return $Logger;
        } else {
            echo "The file $file does not exist";
        }
    }

    public  static function info($message){
        
        //static::check();
        self::check();
        try {
            $severity = "INFO";
            $handle = fopen(FileLogger::$file,'a+');
            //$error = FileLogger::$FileLogger->error($message);
            fwrite($handle,date("Y-m-d H:i:s")." ".$severity." :: ".$message."\r\n");
        } catch (\Exception $th) {
            echo $th->getMessage();
        }
            
    }
    public  static function warn($message){
        
        //static::check();
        self::check();
        try {
            $severity = "WARN";
            $handle = fopen(FileLogger::$file,'a+');
            //$error = FileLogger::$FileLogger->error($message);
            fwrite($handle,date("Y-m-d H:i:s")." ".$severity." :: ".$message."\r\n");
        } catch (\Exception $th) {
            echo $th->getMessage();
        }
            
    }
    public  static function debug($message){
        
        //static::check();
        self::check();
        try {
            $severity = "DEBUG";
            $handle = fopen(FileLogger::$file,'a+');
            //$error = FileLogger::$FileLogger->error($message);
            fwrite($handle,date("Y-m-d H:i:s")." ".$severity." :: ".$message."\r\n");
        } catch (\Exception $th) {
            echo $th->getMessage();
        }
            
    }
    public  static function critical($message){
        
        //static::check();
        self::check();
        try {
            $severity = "CRITICAL";
            $handle = fopen(FileLogger::$file,'a+');
            //$error = FileLogger::$FileLogger->error($message);
            fwrite($handle,date("Y-m-d H:i:s")." ".$severity." :: ".$message."\r\n");
        } catch (\Exception $th) {
            echo $th->getMessage();
        }
            
    }
    public  static function error($message){
        
        //static::check();
        self::check();
        try {
            $severity = "ERROR";
            $handle = fopen(FileLogger::$file,'a+');
            //$error = FileLogger::$FileLogger->error($message);
            fwrite($handle,date("Y-m-d H:i:s")." ".$severity." :: ".$message."\r\n");
        } catch (\Exception $th) {
            echo $th->getMessage();
        }
            
    }

}