<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use App\Utils\Helper;
use App\Validations\LoanValidation;

class LoanController extends Controller
{
    public function __construct()
    {
        session_start();

        if (!in_array($_SESSION["user"]->role, ["ADMIN", "LIBRERIAN"])) {
            header("Location:/forbidden");
            exit;
        }
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
            $members = Member::action()->getAll();

            $this->render("dashboard", compact("cardsData", "page", "books", "members"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Render show page
     */
    public function show()
    {
        try {
            $id = $_GET["id"];
            $cardsData = $this->getCardsData(); 
            $page = "Show Loan"; 
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
            $data = $this->validate(LoanValidation::$rules);
        
            $book = Book::action()->getById((int)$data["book_id"]); 
            $loan = Loan::action()->getByMemberAndBook((int)$data["member_id"], $book);
           
            if ($loan && $loan->getStatus() === Loan::$borrowed) {
                $errors["member_id"] = "Cannot create the same loan twice";
            }

            if (!empty($errors)) {
                $_SESSION["errors"] = $errors;
                $_SESSION["oldInputs"] = $_POST;

                // Redirect back
                header("Location:" . $_SERVER["HTTP_REFERER"]);
                exit;
            }
            
            $data["creator"] = $_SESSION["user"]->id;
            $data["borrow_date"] = date('Y-m-d H:i:s');
            
            // Create new loan
            Loan::action()->create($data);

            // Success message
            $_SESSION["success"] = "Loan created successfuly!";

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
     *  Update a loan using ID
     */
    public function update()
    {
        try {
            // Validate form
            $data = $this->validate(LoanValidation::$rules);

            if ($data["status"] === Loan::$returned) {
                $data["return_date"] = date('Y-m-d H:i:s');
            } 
            
            // Validate form data
            Loan::action()->update($data);

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
