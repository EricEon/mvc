<?php

namespace Flux\Controller;

use Flux\Core\Http\Request;
use Flux\Controller\Controller;
use Flux\Controller\AuthController as Auth;


class RegistrationController extends Controller
{
   
    public function register()
    {
        $data = Auth::register('users',Request::all());
        return view('register');
    }

    public function getActivateView($data){
        return view('activate',compact('data'));
    }

    
}