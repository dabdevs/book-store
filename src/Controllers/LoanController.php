<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
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
            $books = Book::action()->getAvailableBooks();
            $members = Member::action()->getAll(["field" => "id", "order" => "DESC"]);

            $this->render("dashboard", compact("cardsData", "page", "books", "members"));
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
            $books = Book::action()->getAll(["field" => "id", "order" => "DESC"]);
            $members = Member::action()->getAll(["field" => "id", "order" => "DESC"]);

            $this->render("dashboard", compact("cardsData", "loan", "books", "members", "page"));
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
            // Validate form
            $errors = $this->validate(LoanValidation::$rules);

            session_start();

            // Validate if user is a member
            $member = Member::action()->getById($_POST["user_id"]);

            // Validate if the member already borrowed this book
            if ($member) {
                $book = Book::action()->getById($_POST["book_id"]); 
                $loan = Loan::action()->getByMemberAndBook($member, $book);
              
                if ($loan) $errors["user_id"] = "This member already has a loan for this book.";
            } else {
                $errors["user_id"] = "User is not a member";
            }

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
            // Validate form
            $errors = $this->validate(LoanValidation::$rules);
            var_dump($_POST);
            session_start();

            // If there is any error, save them in sessions with old inputs and redirect
            if (!empty($errors)) {
                $_SESSION["oldInputs"] = $_POST;
                $_SESSION["errors"] = $errors;
                header("Location:" . $_SERVER["HTTP_REFERER"]);
                exit;
            }

            // Validate form data
            Loan::action()->update($_POST);

            // Success message
            $_SESSION["success"] = "Loan updated successfuly!";

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
