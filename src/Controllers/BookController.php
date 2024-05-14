<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Book;
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
            $books = Book::action()->getAll();
            $cardsData = $this->getCardsData();

            $this->render("dashboard", compact("books", "cardsData"));
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
            $books = Book::action()->getAll();
            $cardsData = $this->getCardsData();

            // Validate fields
            $errors = $this->validate(array_merge($_POST, $_FILES), BookValidation::$rules);

            // if (count($errors) > 0) {
            //     $this->render('dashboard', compact("books", "cardsData", "errors"));
            //     exit;
            // }

            if (!empty($errors)) {
                $_SESSION["oldInputs"] = $_POST;
                $_SESSION["errors"] = $errors;
                header("Location:/books");
                exit;
            }

            // Create new book
            $book = Book::action()->create($_POST);

            $this->render('dashboard', compact("books", "cardsData"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Update a book using ID
     */
    public function update()
    {
        try {
            $id = $_POST["id"];

            // Validate form data

            Book::updateById($id, $_POST);

            $this->render('index', $_POST);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Delete a book using ID
     */
    public function destroy()
    {
        try {
            $id = $_POST["id"];

            Book::destroy($id);
            $books = Book::findAll();

            $this->render('dashboard', compact('books'));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
