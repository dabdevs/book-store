<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Database\DB;
use App\Models\Admin;
use App\Models\Librerian;
use App\Models\Member;
use App\Models\User;
use App\Utils\Helper;
use App\Validations\UserValidation;

class AuthController extends Controller
{
    public function __construct()
    {
        session_start();
    }

    /**
     *  Log user in
     */
    public function login()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $errors = null;
        $user = null;

        // Validate data
        if (empty($email)) {
            $errors = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors = "Invalid email";
        } else {
            // Authenticate 
            $user = DB::table("users")->select()->where("email = :email", [":email" => $email])[0];
            if (!$user) $errors = "Invalid email/password";
        }

        // Store values in session to fill form
        session_start();

        if (!($user && password_verify($password, $user->password))) {
            $errors = "Invalid email/password";
        } else {
            $_SESSION["user"] = (object)$user;
            header("Location:/dashboard");
            exit;
        }

        if (!empty($errors)) {
            $_SESSION["oldInputs"] = $_POST;
            $_SESSION["errors"] = $errors;
            header("Location:/");
            exit;
        }
    }

    /**
     *  Log user out
     */
    public function logout()
    {
        session_start();
        session_destroy();
        header("Location:/");
        exit;
    }
}