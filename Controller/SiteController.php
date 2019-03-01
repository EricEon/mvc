<?php
namespace Flux\Controller;

use Flux\Core\Helpers\Session;

class SiteController
{
    public function index()
    {
        return view('index');
    }

    public function getRegisterView()
    {
        return view('register');
    }

    public function about()
    {
        return view('about');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}