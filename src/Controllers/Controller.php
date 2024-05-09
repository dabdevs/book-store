<?php

namespace App\Controllers;

class Controller
{
    protected function render($view, $data = [])
    {
        extract($data);

        include dirname(__DIR__) . "/Views/$view.php";
    }
}
