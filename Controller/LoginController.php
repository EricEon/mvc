<?php

namespace Flux\Controller;

use Flux\Controller\AuthController as Auth;
use Flux\Core\Helpers\Session;
use Flux\Core\Http\Request;

class LoginController
{
    public function login()
    {
        $auth = Auth::login('users', Request::all());
        if ($auth) {
            Session::create('success', 'Log In Successful');
            return redirect('/dashboard');
        }
        // Session::create('info','Cannot Login With Given Credentials');
        // return redirect('/');
    }

    public function logout()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        return redirect('/');
    }
}
