<?php
require "bootstrap.php";
require "./vendor/autoload.php";

use Flux\Core\Http\Request;
use Flux\Core\Router\Router;
//use Flux\Helpers\FileLogger;


$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

//$logger = new Logger();
// $logger->info("TESTING LOG CLASS",['status'=> 503]);
//$logger->log("TESTING THE LOGGER CLASS");
//FileLogger::error("TESTING LOG CLASS");



$router = new Router();
$router->load('Routes.php')->resolve(Request::uri(), Request::method());
