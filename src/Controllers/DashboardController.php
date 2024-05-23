<?php

namespace App\Controllers;

use App\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $cardsData = $this->getCardsData();
        $page = "Dashboard";

        $this->render("dashboard", compact("cardsData", "page"));
    }
}
