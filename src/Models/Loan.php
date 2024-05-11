<?php

namespace App\Models;
use App\Database;

class Loan extends Database
{
    public $borrowed = "BORROWED";
    public $returned = "RETURNED";
    private $user_id;
    private $book_id;
    private $status;

    public function __construct($user_id, $book_id, $status)
    {
        $this->user_id = $user_id;
        $this->book_id = $book_id;
        $this->status = $status;
    }

    /**
     *  Get number of loans
     */
    public static function count()
    {
        $sql = "SELECT COUNT(*) AS QUANTITY FROM loans";
        $result = self::select($sql, []);
        return (int)$result[0]["QUANTITY"];
    }
}