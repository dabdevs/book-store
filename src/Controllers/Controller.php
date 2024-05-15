<?php

namespace App\Controllers;

use App\Database\DB;
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

    protected function validate(array $rules)
    {
        $table = $rules["table"];
        $errors = [];
        $data = array_merge($_POST, $_FILES);
        
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                if ($key === "table") continue;

                // Field being validated
                $field = $key;

                // Rules for current field
                $rule = $rules[$key];

                // Validate if field is required
                if (in_array("required", $rule) && $value === "") {
                    $errors[$field] = str_replace("_", " ", $field) . " is required";
                } else {
                    // Validate if field is a string
                    if (in_array("string", $rule) && !is_string($value)) {
                        $errors[$field] = str_replace("_", " ", $field) . " must be a string";
                    }
    
                    // Validate if field is a number
                    if (in_array("number", $rule) && !is_numeric($value)) {
                        $errors[$field] = str_replace("_", " ", $field) . " must be a number";
                    }
    
                    // Validate if field is unique in table
                    if (in_array("$table:unique", $rule)) {
                        $exists = DB::table($table)->select()->where(str_replace("_", " ", $field) . " = :$field", [":$field" => $value]);
    
                        if ($exists) $errors[$field] = str_replace("_", " ", $field) . " must be unique";
                    }
    
                    if ($value !== "") {
                        foreach ($rule as $r) {
                            // Validate minimum length
                            if (str_starts_with($r, "min")) {
                                $minLength = explode(":", $r)[1];
                                if (strlen($value) < $minLength) $errors[$field] = str_replace("_", " ", $field) . " must be at least $minLength characters";
                            }
    
                            // Validate maximum length
                            if (str_starts_with($r, "max")) {
                                $maxLength = explode(":", $r)[1];
                                if (strlen($value) > $maxLength) $errors[$field] = str_replace("_", " ", $field) . " must be at max $maxLength characters";
                            }
    
                            // Validate image extension
                            if (str_starts_with($r, "image")) {
                                $allowedExtensions = explode(":", $r)[1];
                                $fileExtension = explode("/", $value["type"])[1];
                                if (!str_contains($allowedExtensions, $fileExtension)) {
                                    $errors[$field] = str_replace("_", " ", $field) . "'s extension must be " . str_replace(",", " or ", $allowedExtensions);
                                }
                            }
                        }
                    }
                }
            }
        }

        return $errors;
    }
}
