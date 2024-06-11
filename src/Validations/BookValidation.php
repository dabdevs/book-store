<?php

namespace App\Validations;

class BookValidation
{
    public static $rules = [
        "table" => "books",
        "title" => ["required", "string", "books:unique", "min:3", "max:150"],
        "description" => ["string", "min:3"],
        "author" => ["string", "min:3", "max:50"],
        "language" => ["required", "string"],
        "isbn" => ["string", "max:20"],
        "genre" => ["string", "max:50"],
        "publisher" => ["string", "max:50"],
        "published_date" => ["string"],
        "page_count" => ["number"],
        "rating" => ["number"],
        // "cover" => ["required", "image:jpg,jpeg", "size:5"], // maxSize: 5 mb
        "available" => ["required", "number"],
    ];
}
