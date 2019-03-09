<?php
namespace Flux\Controller;

use Flux\Core\Helpers\Session;
use Flux\Controller\Controller;

class SiteController extends Controller
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

    public function where()
    {
        $where = $this->db->table('users')->where('id','=',117);
        //dd($where);
        if(empty($where)){
            Session::create('warning','Row does not exist in database');
            return redirect('/');
        }
        return view('find',$where);
    }
}