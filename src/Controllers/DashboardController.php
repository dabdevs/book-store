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
        $topMembers = Loan::action()->getTopMembers(); 
        $latestLoans = Loan::action()->latestLoans(); 
        $latestReturns = Loan::action()->latestReturns(); 
        $page = "Dashboard";

        $this->render("dashboard", compact("cardsData", "topBooks", "topMembers", "latestLoans", "latestReturns", "page"));
    }
}
