<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Loan;

class LoanController extends Controller
{
    /**
     *  Load all loans from the database
     */
    public function index()
    {
        try {
            $loans = Loan::action()->getAll();
            $cardsData = $this->getCardsData();
            $page = "Loans";

            $this->render("dashboard", compact("loans", "cardsData", "page"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Create a loan in the database
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


            $loan = Loan::action()->create($data);

            $this->render('dashboard', compact('loan'));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Update a loan using ID
     */
    public function update()
    {
        try {
            // Validate data
            $data = ["email" => "alainjean@gmail.com", "id" => 5];
            Loan::action()->update($data);

            $this->render('dashboard', $_POST);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Delete a loan using ID
     */
    public function destroy()
    {
        try {
            $id = $_POST["id"];

            Loan::destroy($id);

            $loans = Loan::findAll();

            $this->render('index', compact('loans'));
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
        $loan = null;

        // Validate data
        if (empty($email)) {
            $error = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email";
        } else {
            // Authenticate 
            $loan = Loan::action()->getByEmail($email);
            if (!$loan) $error = "Invalid email/password";
        }

        // Store values in session to fill form
        session_start();

        if (!($loan && password_verify($password, $loan->password))) {
            $error = "Invalid email/password";
        } else {
            $_SESSION["loan"] = $loan;
            header("Location:/dashboard");
            exit;
        }

        if (!empty($error)) {
            $_SESSION["oldInputs"] = $_POST;
            $_SESSION["error"] = $error;
            header("Location:/");
            exit;
        }
    }
}
