<?php

namespace App\Validations;

class BookValidation
{
    public static $rules = [
        "table" => "books",
        "code" => ["required", "string", "books:unique"],
        "title" => ["required", "string", "books:unique", "min:10", "max:50"],
        "description" => ["string", "min:10", "max:100"],
        "author" => ["required", "string", "min:10", "max:50"],
        "language" => ["required", "string"],
        "isbn" => ["string", "max:20"],
        "genre" => ["required", "string", "max:50"],
        "publisher" => ["required", "string", "max:50"],
        "published_date" => ["required", "string"],
        "cover" => ["required", "image:jpg,jpeg", "size:5"], // maxSize: 5 mb
        "available" => ["required", "number"],
    ];
}
