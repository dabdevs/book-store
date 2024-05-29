<?php

namespace App\Controllers;

use App\Controllers\Controller;

class WebController extends Controller
{
    public function __construct()
    {
        session_start();
    }

    public function login()
    {
        if (isset($_SESSION["user"])) {
            header("Location:/dashboard");
            exit;
        }

        $this->render('login');
    }

    public function notFound()
    {
        $this->render("notFound");
    }

    public function forbidden()
    {
        $this->render("forbidden");
    }
}
