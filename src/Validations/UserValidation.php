<?php

namespace App\Validations;

class UserValidation
{
    public static $rules = [
        "table" => "users",
        "document_id" => ["required", "number", "users:unique"],
        "firstname" => ["required", "string", "min:3", "max:100"],
        "lastname" => ["required", "string", "min:3", "max:100"],
        "email" => ["required", "string", "email"],
        "password" => ["string"],
        "birth_date" => ["required", "string"],
        "role" => ["required", "string", "enum:ADMIN,LIBRERIAN,MEMBER"],
        "avatar" => ["image:jpg,jpeg", "size:5"],
        "bio" => ["string", "min:20", "max:100"],
        "cellphone" => ["number", "min:8", "max:15"],
        "city" => ["string", "min:3", "max:50"],
    ];
}
