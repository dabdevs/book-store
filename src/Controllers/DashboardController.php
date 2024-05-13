<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        $cardsData = $this->getCardsData();

        $this->render("dashboard", compact("cardsData"));
    }
}
