<?php

namespace App\Validations;

class LoanValidation
{
    public static $rules = [
        "table" => "loans", 
        "book_id" => ["required", "number", "books:exists"],
        "user_id" => ["required", "number", "users:exists", "users:member"],
        "borrow_date" => ["required", "string"],
        "return_date" => ["required", "string"],
        "available" => ["required", "boolean"],
    ];
}
