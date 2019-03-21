<?php

/**
 * The view that is shown to the user.
 * @param String $file
 */
function view(String $file, $data = [])
{
    extract($data);
    require "./Views/" .$file. ".view.php";
}

/**Redirects to a specified page
 * @param String $location
 */
function redirect(String $location, $refresh=1){
    header("Location:".$location,"Refresh:".$refresh);
    exit;
}

/**
 * serverName.
 *
 * @author	eonflux
 * @since	v0.0.1
 * @version	v1.0.0	Sunday, February 24th, 2019.
 * @global
 * @return	void
 */
function serverName(){
    $serverName = $_SERVER['SERVER_NAME'];
    echo $serverName;
}

/**
 * isLoggedIn.
 *
 * @author	eonflux
 * @since	v0.0.1
 * @version	v1.0.0	Wednesday, March 13th, 2019.
 * @global
 * @return	boolean
 */
function isLoggedIn(){
    if(isset($_COOKIE['loggedIn']) ){
        return true;
    }
    return false;
}
