<?php

namespace Flux\Core\Router;

class Router
{

    /**
     * @var array
     */
    public static $routes = [
        'GET' => [],
        'POST' => [],
    ];

    /**
     * Patterns that should be replaced
     *
     * @var array
     */
    private $patterns = array(
        '~/~', // slash
        '~{an:[^\/{}]+}~', // placeholder accepts alphabetic and numeric chars
        '~{n:[^\/{}]+}~', // placeholder accepts only numeric
        '~{a:[^\/{}]+}~', // placeholder accepts only alphabetic chars
        '~{w:[^\/{}]+}~', // placeholder accepts alphanumeric and underscore
        '~{\*:[^\/{}]+}~', // placeholder match rest of url
        '~(\\\/)?{\?:[^\/{}]+}~', // optional placeholder
        '~{[^\/{}]+}~', // normal placeholder
    );

    /**
     * Replacements for the patterns index should be in sink
     *
     * @var array
     */
    private $replacements = array(
        '\/', // slash
        '([0-9a-zA-Z]++)', // placeholder accepts alphabetic and numeric chars
        '([0-9]++)', // placeholder accepts only numeric
        '([a-zA-Z]++)', // placeholder accepts only alphabetic chars
        '([0-9a-zA-Z-_]++)', // placeholder accepts alphanumeric and underscore
        '(.++)', // placeholder match rest of url
        '\/?([^\/]*)', // optional placeholder
        '([^\/]++)', // normal placeholder
    );

    /**
     * load.
     *
     * @author    Unknown
     * @since    v0.0.1
     * @version    v1.0.0    Saturday, February 9th, 2019.
     * @access    public static
     * @param    mixed    $file
     * @return    mixed
     */
    public static function load($file)
    {
        require $file;

        $router = new static;

        return $router;
    }

    /**
     * get.
     *
     * @author    eonflux
     * @since    v0.0.1
     * @version    v1.0.0    Saturday, February 23rd, 2019.
     * @access    public static
     * @param    mixed    $uri
     * @param    mixed    $controller
     * @return    mixed
     */
    public static function get($uri, $controller)
    {
        return self::$routes['GET'][$uri] = [$controller];
    }

    /**
     * post.
     *
     * @author    eonflux
     * @since    v0.0.1
     * @version    v1.0.0    Saturday, February 23rd, 2019.
     * @access    public static
     * @param    mixed    $uri
     * @param    mixed    $controller
     * @return    mixed
     */
    public static function post($uri, $controller)
    {
        return self::$routes['POST'][$uri] = [$controller];
    }

    /**
     * parseRoute.
     *
     * @author	eonflux
     * @since	v0.0.1
     * @version	v1.0.0	Sunday, February 24th, 2019.
     * @access	private
     * @param	string	$uri   	
     * @param	mixed 	$method	
     * @return	void
     */
    private function parseRoute(String $uri, $method)
    {
        try {
            $matches = array();
        if (array_key_exists($uri, self::$routes[$method])) {
            list($callMethod) = self::$routes[$method][$uri];
            return $this->callControllerAction(
                ...explode('@', $callMethod)

            );
            echo "True";
        } else {
            foreach (self::$routes[$method] as $key => $val) {
                $pattern = preg_replace('#\(/\)#', '/?', $key);
                //var_dump("Pattern first pass is ". $pattern);
                $pattern = "@^" . preg_replace('/{([a-zA-Z0-9\_\-]+)}/', '(?<$1>[a-zA-Z0-9\_\-\.\@]+)', $pattern) . "$@D";
                ///var_dump("Pattern second pass is ". $pattern);
                preg_match($pattern, $uri, $matches);
                //var_dump("Matched patterns are ". $matched);
                array_shift($matches);
                //var_dump($matches);
                
                //print_r($matches);
                if ($matches && isset($matches)) {
                    //print_r($val);
                    list($controllerAction) = $val;
                    //var_dump($controllerAction);
                    $getAction = explode('@', $controllerAction);
                    //var_dump($getAction);
                    //list($controller) = $getAction[0];
                    //var_dump($controller);
                    //list($action) = $getAction[1];
                    //var_dump($action);
                    $this->callControllerAction($getAction[0], $getAction[1], $matches);
                }
            }
        } //code...
        } catch (\Throwable $th) {
             $th->getMessage();
        //throw new \Exception('No route defined for this URI.');
        }
        

       

    }

    /**
     * convertRoutes.
     *
     * @author    eonflux
     * @since    v0.0.1
     * @version    v1.0.0    Thursday, February 14th, 2019.
     * @version    v1.0.1    Thursday, February 14th, 2019.
     * @access    public
     * @param    mixed    $uri
     * @param    mixed    $method
     * @return    array
     */
    private function extractArguments($uri)
    {
        $matches = array();
        //var_dump($uri);
        // $convertedRoute = preg_match_all('~{(n:|a:|an:|w:|\*:|\?:)?([a-zA-Z0-9_]+)}~', $uri, $match);
        // print_r($match);
        preg_match_all('~{(n:|a:|an:|w:|\*:|\?:)?([a-zA-Z0-9_]+)}~', $uri, $matches);
        if (isset($matches[2]) && !empty($matches[2])) {
            return $matches[2];
        }
        //var_dump($matches);
        return [];
    }

    /**
     * resolve.
     *
     * @author    eonflux
     * @since    v0.0.1
     * @version    v1.0.0    Saturday, February 9th, 2019.
     * @access    public
     * @param    mixed    $uri
     * @param    mixed    $requestMethod
     * @return    void
     */
    public function resolve($uri, $method)
    {
        $this->parseRoute($uri, $method);
        
        //check if the key isset in the correct array, then separate the url from the controller and action
        //if (array_key_exists($uri, self::$routes[$method])) { //$routes['GET']
            
            // list($callMethod) = self::$routes[$requestMethod][$uri];
            // $this->callControllerAction(...explode('@', $callMethod));
        //}
        //if url route matches the request::uri then obtain the controller/action value from the array
    }

    /**
     * Calls the method on the controller if it exits. Controller is specified in the route.
     * @param $controller
     * @param $action
     * @return mixed
     */
    public function callControllerAction($controller, $action, $var = [])
    {
        $controller = "Flux\\Controller\\{$controller}";
        $controller = new $controller;
        //var_dump($controller);

        if (!method_exists($controller, $action) && !empty($action)) {
            echo "Method {$action} does not exist in {$controller}";
        }
        return $controller->$action($var);
    }

}
