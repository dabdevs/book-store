<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Member;
use App\Utils\Helper;
use App\Validations\UserValidation;

class MemberController extends Controller
{
    private $role = "MEMBER";

    /**
     *  Members index page
     */
    public function index()
    {
        try {
            $members = Member::action()->getAll();
            $cardsData = $this->getCardsData();
            $page = "Members";

            $this->render("dashboard", compact("members", "cardsData", "page"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Render create page
     */
    public function create()
    {
        try {
            $cardsData = $this->getCardsData();
            $page = "Create Member";
            $this->render("dashboard", compact("cardsData", "page"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Create a member in the database
     */
    public function store()
    {
        try {
            session_start();

            // Validate form
            $errors = $this->validate(UserValidation::$rules);

            // If there is any error, save them in sessions with old inputs and redirect
            if (!empty($errors)) {
                $_POST["avatar"] = $_FILES["avatar"]["name"];
                $_SESSION["oldInputs"] = $_POST;
                $_SESSION["errors"] = $errors;
                header("Location:" . $_SERVER["HTTP_REFERER"]);
                exit;
            }

            // Hash password
            $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);

            // Upload file and set filename in POST data
            Helper::updateFile("avatar");

            // Create new book
            Member::action()->create($_POST);

            // Success message
            $_SESSION["success"] = "Member created successfuly!";

            // Redirect back
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit;
        } catch (\Exception $e) {
            // Error message
            $_SESSION["error"] = "Operation failed! Please try again later.";

            // Redirect back
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit;
        }
    }

    /**
     *  Render edit page
     */
    public function edit()
    {
        try {
            $queryParams = Helper::getQueryParameters();
            $id = $queryParams["id"];
            $cardsData = $this->getCardsData();
            $page = "Edit Member";
            $member = Member::action()->getById($id);

            $this->render("dashboard", compact("cardsData", "member", "page"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Update a member using ID
     */
    public function update()
    {
        try {
            // Validate form
            $errors = $this->validate(UserValidation::$rules);

            session_start();

            // If there is any error, save them in sessions with old inputs and redirect
            if (!empty($errors)) {
                $_SESSION["oldInputs"] = $_POST;
                $_SESSION["errors"] = $errors;
                header("Location:" . $_SERVER["HTTP_REFERER"]);
                exit;
            }

            // Validate form data
            Member::action()->update($_POST);

            // Success message
            $_SESSION["success"] = "Member updated successfuly!";

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

    /**
     *  Delete a member using ID
     */
    public function destroy()
    {
        try {
            $id = $_POST["id"];

            Member::action()->delete($id);

            session_start();

            // Success message
            $_SESSION["success"] = "Member deleted successfuly!";

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

    // public function login()
    // {
    //     if ($_SERVER["REQUEST_METHOD"] !== "POST") header("Location:/");

    //     $email = $_POST["email"];
    //     $password = $_POST["password"];

    //     $error = null;
    //     $member = null;

    //     // Validate data
    //     if (empty($email)) {
    //         $error = "Email is required";
    //     } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         $error = "Invalid email";
    //     } else {
    //         // Authenticate 
    //         $member = Member::action()->getByEmail($email);
    //         if (!$member) $error = "Invalid email/password";
    //     }

    //     // Store values in session to fill form
    //     session_start();

    //     if (!($member && password_verify($password, $member->password))) {
    //         $error = "Invalid email/password";
    //     } else {
    //         $_SESSION["member"] = $member;
    //         header("Location:/dashboard");
    //         exit;
    //     }

    //     if (!empty($error)) {
    //         $_SESSION["oldInputs"] = $_POST;
    //         $_SESSION["error"] = $error;
    //         header("Location:/");
    //         exit;
    //     }
    // }
}
