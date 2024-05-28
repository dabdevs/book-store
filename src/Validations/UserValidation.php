<?php

namespace App\Validations;

class UserValidation
{
    public static $rules = [
        "table" => "users",
        "firstname" => ["required", "string", "min:3", "max:100"],
        "lastname" => ["required", "string", "min:3", "max:100"],
        "email" => ["required", "string", "email"],
        "password" => ["required", "string"],
        "birth_date" => ["required", "string"],
        "role" => ["required", "string", "enum:ADMIN,LIBRERIAN,MEMBER"],
        "avatar" => ["image:jpg,jpeg", "size:5"],
        "bio" => ["string","min:20", "max:100"],
        "cellphone" => ["number", "min:8", "max:15"],
        "city" => ["string", "min:3", "max:50"],
    ];
}
