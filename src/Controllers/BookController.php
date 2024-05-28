<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Book;
use App\Utils\Helper;
use App\Validations\BookValidation;

class BookController extends Controller
{
    public function __construct()
    {
    }

    /**
     *  Load all books from the database
     */
    public function index()
    {
        try {
            $books = Book::action()->getAll(["field" => "id", "order" => "DESC"]);

            $cardsData = $this->getCardsData();
            $page = "Books";

            $this->render("dashboard", compact("books", "cardsData", "page"));
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
            $page = "Create Book";

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
            $page = "Edit Book";
            $book = Book::action()->getById($id);

            $this->render("dashboard", compact("cardsData", "book", "page"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Create a book in the database
     */
    public function store()
    {
        try {
            session_start();

            // Validate form
            $errors = $this->validate(BookValidation::$rules);

            // If there is any error, save them in sessions with old inputs and redirect
            if (!empty($errors)) {
                $_POST["cover"] = $_FILES["cover"]["name"];
                $_SESSION["oldInputs"] = $_POST;
                $_SESSION["errors"] = $errors;
                header("Location:" . $_SERVER["HTTP_REFERER"]);
                exit;
            }

            // Upload file and set filename in POST data
            Helper::uploadFile("cover", "/images/books/");

            // Create new book
            Book::action()->create($_POST);

            // Success message
            $_SESSION["success"] = "Book created successfuly!";

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
     *  Update a book using ID
     */
    public function update()
    {
        try {
            session_start();

            // Upload file and set filename in POST data
            Helper::uploadFile("cover", "/images/books/");

            // Validate form data
            Book::action()->update($_POST);

            // Success message
            $_SESSION["success"] = "Book updated successfuly!";

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
     *  Delete a book using ID
     */
    public function destroy()
    {
        try {
            session_start();

            $id = $_POST["id"];

            Book::action()->delete($id);

            // Success message
            $_SESSION["success"] = "Book deleted successfuly!";

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
}
