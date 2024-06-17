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
        session_start();

        if (!in_array($_SESSION["user"]->role, ["ADMIN", "LIBRERIAN"])) {
            header("Location:/forbidden");
            exit;
        }
    }

    /**
     *  Load all books from the database
     */
    public function index()
    {
        try {
            $page = "Books";
            $genre = isset($_GET["genre"]) ? $_GET["genre"] : null;
            $cardsData = $this->getCardsData();

            if (!empty($genre)) {
                $books = Book::action()->getByGenre($genre);
            } else {
                $books = Book::action()->getAll(["field" => "id", "order" => "DESC"]);
            }

            $this->render("dashboard", compact("cardsData", "books", "page"));
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
     *  Render show page
     */
    public function show()
    {
        try {
            $queryParams = Helper::getQueryParameters();
            $id = $queryParams["id"];
            $cardsData = $this->getCardsData();
            $page = "View Book";
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
            $data = $this->validate(BookValidation::$rules);

            // if (isset($_POST["coverFromApi"])) {
            //     $data["cover"] = $_POST["coverFromApi"];
            //     unset($data["coverFromApi"]);
            // }

            // Upload file and set filename in POST data
            // Helper::uploadFile("cover", "/images/books/");

            $data["code"] = Helper::generateBookCode(6);
            // echo "<pre>";
            // var_dump($data, $_POST); die;
            // Create new book
            Book::action()->create($data);

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

            // Validate form
            $data = $this->validate(BookValidation::$rules);

            // Upload file and set filename in POST data
            // Helper::uploadFile("cover", "/images/books/");

            // Validate form data
            Book::action()->update($data);

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
