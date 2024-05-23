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
                $_SESSION["oldInputs"] = $_POST;
                $_SESSION["errors"] = $errors;
                header("Location:" . $_SERVER["HTTP_REFERER"]);
                exit;
            }

            // Upload file
            if ($_FILES["cover"]["name"] !== "") {
                $fileTmpName = $_FILES["cover"]["tmp_name"];
                $fileName = $_FILES["cover"]["name"];

                // Explode fileName to get extension
                $fileNameCmps = explode(".", $fileName);

                // Convert last element of array (extension) to lowercase
                $fileExtension = strtolower(end($fileNameCmps));

                // Create new hashed filename
                $fileName = md5(time() . $fileName) . "." . $fileExtension;

                // Directory where the file will be moved
                $uploadFileDir = dirname(__DIR__) . "/images/books/";
                ///Applications/MAMP/htdocs/book-store/src/images/books/09f407843a6133516aefe59d24fffe10.jpg
                // Full path of the file
                $filePath = $uploadFileDir . $fileName;

                // Create the directory if it does not exist
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0755, true);
                    chmod($uploadFileDir, 0755);
                }

                // Move file to directory
                if (!move_uploaded_file($fileTmpName, $filePath)) {
                    $_SESSION["error"] = "An error ocurred while uploading the file. Please try again.";

                    // Redirect back
                    header("Location:" . $_SERVER["HTTP_REFERER"]);
                    exit;
                }

                // Save fileName in array to be saved
                $_POST["cover"] = "/images/books/" . $fileName;
            }

            // Create new book
            Book::action()->create($_POST);

            // Success message
            $_SESSION["success"] = "Book created successfuly!";

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
     *  Update a book using ID
     */
    public function update()
    {
        try {
            session_start();

            // Validate form data
            Book::action()->update($_POST);

            // Success message
            $_SESSION["success"] = "Book updated successfuly!";

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
            $_SESSION["error"] = "Operation failed! Please try again later.";

            // Redirect back
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit;
        }
    }
}
