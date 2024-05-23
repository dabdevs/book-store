<?php

namespace App\Controllers;
use App\Controllers\Controller;

class HomeController extends Controller
{
    public function login()
    {
        $data = ['name' => 'Alain'];
        $this->render('login', compact('data'));
    }

    public function not_found()
    {
        $this->render("404");
    }
}