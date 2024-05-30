<?php

namespace App\Validations;

class LoanValidation
{
    public static $rules = [
        "table" => "loans",
        "book_id" => ["required", "number", "books:exists"],
        "user_id" => ["required", "number", "users:exists"],
        "due_date" => ["required", "string"],
        "status" => ["required", "enum:BORROWED,RETURNED"],
    ];
}
