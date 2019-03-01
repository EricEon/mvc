<?php
/**
 * Created by PhpStorm.
 * User: Flux
 * Date: 2/6/2019
 * Time: 6:04 PM
 */

namespace Flux\Core\Http;


class Request
{
    public static function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function all(){
        if (isset($_POST['submit'])) {
            $post = $_POST;
            unset($post['submit']);
            return $post;
        }
        echo "No Data";
        exit;
    }

    public static function host(){
        return $_SERVER['SERVER_NAME'];
    }

    public static function is(String $url){
        if($_SERVER['REQUEST_URI'] === $url){
            return true;
        }
    }
}

