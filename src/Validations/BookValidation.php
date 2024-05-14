<?php 

namespace App\Validations; 

class BookValidation {
    public static $rules = [
        "table" => "books",
        "code" => ["required", "string", "books:unique"],
        "title" => ["required", "string", "books:unique"],
        "description" => ["string", "min:10", "max:100"],
        "author" => ["required", "string", "min:10", "max:50"],
        "isbn" => ["string", "max:20"],
        "genre" => ["required", "string", "max:50"],
        "publisher" => ["required", "string", "max:50"],
        "publishedDate" => ["required", "string"],
        "cover" => ["required", "image:jpg,jpeg"],
        "available" => ["required", "number"],
    ];
}