<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Book;

class BookController extends Controller
{
    /**
     *  Load all books from the database
     */
    public function index()
    {
        try {
            $books = Book::findAll();

            $this->render('dashboard', compact('books'));
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
            // Validate form data
            $code = $_POST["code"];
            $title = $_POST["title"];
            $description = $_POST["description"];
            $author = $_POST["author"];
            $isbn = $_POST["isbn"];
            $genre = $_POST["genre"];
            $publisher = $_POST["publisher"];
            $publishedDate = $_POST["published_date"];
            $available = $_POST["available"];

            // Create new book
            $book = new Book($code, $title, $description, $author, $isbn, $genre, $publisher, $publishedDate, $available);
            $book->save();

            $books = Book::findAll();

            $this->render('index', compact('books'));
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
