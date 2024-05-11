<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;

class DashboardController extends Controller
{
    public function index()
    {
        $data["booksCount"] = Book::count();
        $data["usersCount"] = User::count();
        $data["loansCount"] = Loan::count();
        
        $this->render('dashboard', compact("data"));
    }
}
