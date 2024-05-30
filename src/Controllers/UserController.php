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
    public function __construct()
    {
        session_start(); 
    }

    public function profile()
    {
        try {
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
            $data = $this->validate(UserValidation::$rules);

            // Upload file and set filename in POST data
            Helper::uploadFile("avatar", "/images/users/");

            // Update user
            DB::table("users")->update($data);

            $_SESSION["user"] = (object)$data;

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
