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
        $data["usersCount"] = User::count();
        $data["booksCount"] = Book::count();
        $data["loansCount"] = Loan::count();

        $this->render('dashboard', compact("data"));
    }
}
