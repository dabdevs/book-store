<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Member;
use App\Models\User;

class MemberController extends Controller
{
    /**
     *  Load all users from the database
     */
    public function index()
    {
        try {
            $users = Member::action()->getAll();
            $cardsData = $this->getCardsData();

            $this->render("dashboard", compact("users", "cardsData"));
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
            // Validate data
            $data = [
                "email" => "mjean@gmail.com",
                "firstname" => "Martha",
                "lastname" => "Jean",
                "password" => password_hash("1234", PASSWORD_DEFAULT),
                "role" => "MEMBER"
            ];

            $date_format = \DateTime::createFromFormat("Y/m/d", "1994/06/03");
            $data["birth_date"] = $date_format->format('Y-m-d');


            $user = User::action()->create($data);

            $this->render('dashboard', compact('user'));
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
            // Validate data
            $data = ["email" => "alainjean@gmail.com", "id" => 5];
            User::action()->update($data);

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
            $user = User::action()->getByEmail($email);
            if (!$user) $error = "Invalid email/password";
        }

        // Store values in session to fill form
        session_start();

        if (!($user && password_verify($password, $user->password))) {
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
