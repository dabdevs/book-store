<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;

class DashboardController extends Controller
{
    public function index()
    {
        $cardsData = $this->getCardsData();
        $topBooks = Book::action()->getTopBooks(); 
        // $topMembers = Loan::action()->getTopMembers(); 
        $page = "Dashboard";

        $this->render("dashboard", compact("cardsData", "topBooks", "page"));
    }
}
