<?php

namespace Flux\Controller;
use Flux\Core\Http\Request;
use Flux\Controller\AuthController as Auth;

class ActivationController {
    
    public function activate(){
        Auth::activate(Request::all());
        return view('activate');
    }
}