<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     *  Load all users from the database
     */
    public function index()
    {
        try {
            $users = User::findAll();

            $this->render('dashboard', compact('users'));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Create a user in the database
     */
    public function store()
    {
        try {
            // Validate post data
            $f_name = $_POST["f_name"];
            $l_name = $_POST["l_name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $birth_date = $_POST["birth_date"];
            $role = $_POST["role"];

            // Create new user
            $user = new User($f_name, $l_name, $email, $password, $birth_date, $role);
            $user->save();

            $users = $user->finAll();
            
            $this->render('dashboard', compact('users'));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Update a user using ID
     */
    public function update()
    {
        try {
            $id = $_POST["id"];

            User::updateById($id, $_POST);

            $this->render('dashboard', $_POST);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Delete a user using ID
     */
    public function destroy()
    {
        try {
            $id = $_POST["id"];

            User::destroy($id);

            $users = User::findAll();

            $this->render('index', compact('users'));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") header("Location:/");

        $email = $_POST["email"];
        $password = $_POST["password"];

        $error = null;
        $user = null;

        // Validate data
        if (empty($email)) {
            $error = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email";
        } else {
            // Authenticate 
            $user = User::findBy("email", $email);
            if (!$user) $error = "Invalid email/password";
        }

        // Store values in session to fill form
        session_start();

        if (!($user && password_verify($password, $user["password"]))) {
            $error = "Invalid email/password";
        } else {
            $_SESSION["user"] = $user;
            header("Location:/dashboard");
            exit;
        }

        if (!empty($error)) {
            $_SESSION["old_inputs"] = $_POST;
            $_SESSION["error"] = $error;
            header("Location:/");
            exit;
        }
    }
}
