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
    /**
     * uri. Returns the current request uri.
     *
     * @author    eonflux
     * @since    v0.0.1
     * @version    v1.0.0    Wednesday, March 6th, 2019.
     * @access    public static
     * @return    mixed
     */
    public static function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * method. Returns the request method.
     *
     * @author    eonflux
     * @since    v0.0.1
     * @version    v1.0.0    Wednesday, March 6th, 2019.
     * @access    public static
     * @return    mixed
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * all. Returns array of data from a form.
     *
     * @author    eonflux
     * @since    v0.0.1
     * @version    v1.0.0    Wednesday, March 6th, 2019.
     * @access    public static
     * @return    void
     */
    public static function all()
    {
        if (isset($_POST['submit'])) {
            $post = $_POST;
            unset($post['submit']);
            return $post;
        }
        echo "No Data";
        exit;
    }

    /**
     * host. Returns the server name
     *
     * @author    eonflux
     * @since    v0.0.1
     * @version    v1.0.0    Wednesday, March 6th, 2019.
     * @access    public static
     * @return    mixed
     */
    public static function host()
    {
        return $_SERVER['SERVER_NAME'];
    }

    /**
     * is. Check the request url and returns true or false if url given is the same as the actual url.
     *
     * @author    eonflux
     * @since    v0.0.1
     * @version    v1.0.0    Wednesday, March 6th, 2019.
     * @access    public static
     * @param    string    $url
     * @return    boolean
     */
    public static function is(String $url)
    {
        if ($_SERVER['REQUEST_URI'] === $url) {
            return true;
        }
    }
}
