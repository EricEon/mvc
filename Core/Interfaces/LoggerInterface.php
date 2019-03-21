<?php

namespace Flux\Interfaces;

interface LoggerInterface
{

    public static function warn(String $message);

    public static function error(String $message);

    public static function critical(String $message);

    public static function debug(String $message);

    public static function info(String $message);
    
}