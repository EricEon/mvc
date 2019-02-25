<?php
/**
 * Created by PhpStorm.
 * User: Flux
 * Date: 2/6/2019
 * Time: 6:32 PM
 */

namespace Flux\Controller;

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
}