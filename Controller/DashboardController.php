<?php
namespace Flux\Controller;

class DashboardController
{
    public function index()
    {
        if(isLoggedIn()){
            return view('dashboard');
        }   
        return redirect('/');
    }

}