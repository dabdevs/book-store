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

class UserController extends Controller
{
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
            $_SESSION["user"] = $user;
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

    public function profile()
    {
        try {
            session_start();
            $page = "Profile";

            $this->render("dashboard", compact("page"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateProfile()
    {
        try {
            session_start();

            // Validate form
            $errors = $this->validate(UserValidation::$rules);

            // If there is any error, save them in sessions with old inputs and redirect
            if (!empty($errors)) {
                $_POST["cover"] = $_FILES["cover"]["name"];
                $_SESSION["oldInputs"] = $_POST;
                $_SESSION["errors"] = $errors;
                header("Location:" . $_SERVER["HTTP_REFERER"]);
                exit;
            }

            // Upload file and set filename in POST data
            Helper::uploadFile("avatar", "/images/users/");

            // Update user
            DB::table("users")->update($_POST);

            $_SESSION["user"] = $_POST;

            // Success message
            $_SESSION["success"] = "Profile updated successfuly!";

            // Redirect back
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit;
        } catch (\Exception $e) {
            // Error message
            $_SESSION["error"] = $e->getMessage();

            // Redirect back
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit;
        }
    }

    function setAuthUserType(array $data)
    {
        $role = $data["role"];
        $authUser = null;

        switch ($role) {
            case User::$admin:
                $authUser = Admin::action($role);
                $authUser->load($data);
                break;
            case User::$member:
                $authUser = Member::action($role);
                $authUser->load($data);
                break;
            case User::$librerian:
                $authUser = Librerian::action($role);
                $authUser->load($data);
                break;
        }

        return $authUser;
    }
}
