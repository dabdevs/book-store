<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Loan;
use App\Utils\Helper;
use App\Validations\LoanValidation;

class LoanController extends Controller
{
    public function __construct()
    {
    }

    /**
     *  Load all loans from the database
     */
    public function index()
    {
        try {
            $loans = Loan::action()->getAll(["field" => "loans.id", "order" => "DESC"]);
            $cardsData = $this->getCardsData();
            $page = "Loans";

            $this->render("dashboard", compact("loans", "cardsData", "page"));
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
            $page = "Create Loan";

            $this->render("dashboard", compact("cardsData", "page"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
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
            $page = "Edit Loan";
            $loan = Loan::action()->getById($id);

            $this->render("dashboard", compact("cardsData", "loan", "page"));
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
            session_start();

            // Validate form
            $errors = $this->validate(LoanValidation::$rules);

            // If there is any error, save them in sessions with old inputs and redirect
            if (!empty($errors)) {
                $_SESSION["oldInputs"] = $_POST;
                $_SESSION["errors"] = $errors;
                header("Location:" . $_SERVER["HTTP_REFERER"]);
                exit;
            }

            // Create new loan
            Loan::action()->create($_POST);

            // Success message
            $_SESSION["success"] = "Loan created successfuly!";

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
     *  Update a loan using ID
     */
    public function update()
    {
        try {
            session_start();

            // Upload file
            Helper::updateFile("cover");

            // Validate form data
            Loan::action()->update($_POST);

            // Success message
            $_SESSION["success"] = "Loan updated successfuly!";

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
     *  Delete a loan using ID
     */
    public function destroy()
    {
        try {
            session_start();

            $id = $_POST["id"];

            Loan::action()->delete($id);

            // Success message
            $_SESSION["success"] = "Loan deleted successfuly!";

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
}
