<?php


use Flux\Core\Router\Router;

Router::get('/','SiteController@index');
Router::get('/dashboard','SiteController@dashboard');
Router::get('/register','SiteController@getRegisterView');
Router::get('/activate/{email}/{activation_code}','RegistrationController@getActivateView');

Router::post('/register','RegistrationController@register');
Router::post('/activate','ActivationController@activate');
Router::post('/login','LoginController@login');
Router::post('/logout','LoginController@logout');
