<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;

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

        return $data;
    }
}
