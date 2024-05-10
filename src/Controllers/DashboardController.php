<?php

namespace App\Controllers;

use App\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $this->render('dashboard');
    }
}
