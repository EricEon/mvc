<?php

require "bootstrap.php";
require "./vendor/autoload.php";
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();


//use Flux\Core\Database\Connector;
use Flux\Core\Http\Request;
use Flux\Core\Router\Router;
 //var_dump($_SESSION);
 //var_dump($_SERVER);
//Connector::connect();
//var_dump(Session::create("hello, checking to see if setting of the message works"));
$router = new Router();
$router->load('Routes.php')->resolve(Request::uri(), Request::method());
