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
        if (!isset($_SESSION["user"])) session_start();
        
        $data["booksCount"] = Book::action()->count();
        $data["loansCount"] = Loan::action()->count();
        $data["membersCount"] = Member::action()->count();

        $user = (object)$_SESSION["user"];
        
        if (isset($user) && $user->role === User::$admin) {
            $data["libreriansCount"] = Librerian::action()->count();
        }

        return $data;
    }

    protected function validate(array $rules)
    {
        $table = $rules["table"];
        $errors = [];
        $data = array_merge($_POST, $_FILES);

        if (empty($_POST["id"]) && $table === "users") {
            $rules["email"] = ["string", "email", "required", "users:unique"];
            $rules["password"] = ["string", "required"];
        } else {
            $rules["email"] = ["string", "email", "required"];
        }
        
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                if ($key === "table" || $key === "id") continue;

                // Field being validated
                $field = $key;

                // Rules for current field
                $rule = $rules[$key];

                // Validate if field is required
                if ($value !== "") {
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
                        $exists = DB::table($table)->select()->where(str_replace("_", " ", $field) . " = :$field", [":$field" => $value])->get();

                        if ($exists) $errors[$field] = str_replace("_", " ", $field) . " must be unique";
                    }

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
                        if (str_starts_with($r, "image") && !empty($value["name"])) {
                            $allowedExtensions = explode(":", $r)[1];
                            $fileExtension = explode("/", $value["type"])[1];
                            if (!str_contains($allowedExtensions, $fileExtension)) {
                                $errors[$field] = str_replace("_", " ", $field) . "'s extension must be " . str_replace(",", " or ", $allowedExtensions);
                            } 
                        }

                        // Validate file size
                        if (str_starts_with($r, "size")) {
                            // Maximum size allowed in mb
                            $sizeInMg = explode(":", $r)[1];

                            // Convert size to bytes
                            $maxSize = (int)$sizeInMg * 1024 * 1024;

                            // If size exceeds maximum size return with error
                            if ($value["size"] > $maxSize) $errors[$field] = str_replace("_", " ", $field) . " image size cant be over $sizeInMg mb";
                        }

                        // Validate if id exists
                        if (str_ends_with($r, "exists")) {
                            $checkTable = explode(":", $r)[0];
                            $exists = DB::table($checkTable)->select()->where("id = :id", [":id" => $value])->get();

                            if (!$exists) $errors[$field] = rtrim($checkTable, 's') . " does not exist";
                        }

                        // Validate enum
                        if (str_starts_with($r, "enum")) {
                            $enums = explode(":", $r)[1];
                            $enums = explode(",", $enums);

                            if (!in_array($value, $enums)) $errors[$field] = "$value is not a valid value";
                        }
                    }
                } else {
                    if (in_array("required", $rule)) $errors[$field] = str_replace("_", " ", $field) . " is required";
                }
            }
        }

        // If there is any error, save them in sessions with old inputs and redirect
        if (!empty($errors)) {
            $_SESSION["oldInputs"] = $_POST;
            $_SESSION["errors"] = $errors;
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit;
        }

        if (!empty($data["password"])) {
            $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        } else {
            unset($data["password"]);
        }

        return $data;
    }
}
