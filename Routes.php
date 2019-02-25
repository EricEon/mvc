<?php
/**
 * Created by PhpStorm.
 * User: Flux
 * Date: 2/6/2019
 * Time: 6:03 PM
 */

use Flux\Core\Router\Router;

Router::get('/','SiteController@index');
Router::get('/about','SiteController@about');
Router::get('/register','SiteController@getRegisterView');
//Router::get('/activate/{email}','RegistrationController@activate');
Router::get('/activate/{email}/{activation_code}','RegistrationController@getActivateView');
Router::post('/register','RegistrationController@register');

Router::post('/activate','ActivationController@activate');