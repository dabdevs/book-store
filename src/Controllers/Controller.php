<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\Librerian;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;

class Controller
{
    protected function render($view, $data = [])
    {
        extract($data);

        include dirname(__DIR__) . "/Views/$view.php";
    }

    protected function getCardsData()
    {
        $data["booksCount"] = Book::count();
        $data["loansCount"] = Loan::count();
        $data["membersCount"] = Member::count();

        session_start();
        if (isset($_SESSION["user"]) && $_SESSION["user"]->role === User::$admin) {
            $data["libreriansCount"] = Librerian::count();
        }

        return $data;
    }
}
