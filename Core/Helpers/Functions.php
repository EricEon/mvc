<?php

/**
 * Die and dump data passed to the function
 * @param $data
 */
function dd($data){
    die(var_dump($data));
}

/**
 * The view that is shown to the user.
 * @param String $file
 */
function view(String $file, $data = [])
{
    extract($data);
    require "./Views/" .$file. ".view.php";
}

/**
 * Send the mail for activating a registered account
 * @param String $from
 * @param String $to
 * @param String $subject
 * @param String $activation_code
 */
function mailActivation(String $to, String $subject, String $message){

    mail($to,$subject,$message);
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

function isLoggedIn(){
    if(isset($_COOKIE['loggedIn']) ){
        return true;
    }
    return false;
}
