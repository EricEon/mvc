<?php

require "./vendor/autoload.php";

require "bootstrap.php";
//use Flux\Core\Database\Connector;
use Flux\Core\Http\Request;
use Flux\Core\Router\Router;
// var_dump($match); */

//var_dump(Session::create("hello, checking to see if setting of the message works"));
$router = new Router();
$router->load('Routes.php')->resolve(Request::uri(), Request::method());
