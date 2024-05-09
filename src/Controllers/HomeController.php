<?php

namespace App\Controllers;
use App\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data = ['name' => 'Alain'];
        $this->render('index', compact('data'));
    }
}