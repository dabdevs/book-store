<?php

namespace App\Models;

use App\Database\DB;

class Book
{
    protected static $instance;
    private $table = "books";
    private $id;
    private $code;
    private $title;
    private $description;
    private $author;
    private $isbn;
    private $genre;
    private $publisher;
    private $published_date;
    private $cover;
    private $available;

    public function __construct()
    {
    }

    /**
     *  Create a new book instance if it does not exist
     */
    public static function action()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     *  Load input data
     */
    private function load(array $data)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    /**
     *  Create a new book
     */
    public function create(array $data)
    {
        $lastId = DB::table($this->table)->insert($data);
        $this->load($data, ["id" => $lastId]);

        return $this;
    }

    /**
     *  Update existing book
     */
    public function update(array $data)
    {
        return DB::table($this->table)->update($data);
    }

    /**
     *  Delete existing book
     */
    public function delete($id)
    {
        return DB::table($this->table)->delete()->where("id = :id", ["id" => $id]);
    }

    /**
     *  Retreive all books from the database
     */
    public function getAll(array $orderBy = [])
    {
        $books = DB::table($this->table)->select()->all();
        if (!empty($orderBy)) {
            $books = $books->orderBy($orderBy);
        }

        return $books;
    }

    /**
     *  Get a available books
     */
    public function getAvailableBooks()
    {
        return DB::table($this->table)->select()->where("available > :count", [":count" => 0]);
    }

    /**
     *  Get a book by Id
     */
    public function getById($id)
    {
        $book = DB::table($this->table)->select()->where("id = :id", [":id" => $id]);

        if ($book) {
            $this->load((array)$book[0]);
            return $this;
        }

        return null;
    }

    /**
     *  Get a book by code
     */
    public function getByCode($code)
    {
        $book = DB::table($this->table)->select()->where("code = :code", [":code" => $code]);

        if ($book) {
            $this->load((array)$book[0]);
            return $this;
        }

        return null;
    }

    /**
     *  Get a book by title
     */
    public function getByTitle($title)
    {
        $book = DB::table($this->table)->select()->where("title = :title", [":title" => $title]);

        if ($book) {
            $this->load((array)$book[0]);
            return $this;
        }

        return null;
    }

    /**
     *  Get the amount of books 
     */
    public function count()
    {
        return DB::table("books")->count();
    }

    /**
     *  Convert book object to array
     */
    public function toArray()
    {
        return [
            "id" => $this->id,
            "code" => $this->code,
            "title" => $this->title,
            "description" => $this->description,
            "author" => $this->author,
            "isbn" => $this->isbn,
            "genre" => $this->genre,
            "publisher" => $this->publisher,
            "publishedDate" => $this->publishedDate,
            "cover" => $this->cover,
            "available" => $this->available,
        ];
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get the value of isbn
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set the value of isbn
     *
     * @return  self
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get the value of genre
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set the value of genre
     *
     * @return  self
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get the value of publisher
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Set the value of publisher
     *
     * @return  self
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get the value of publishedDate
     */
    public function getPublishedDate()
    {
        return $this->published_date;
    }

    /**
     * Set the value of publishedDate
     *
     * @return  self
     */
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    /**
     * Get the value of cover
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set the value of cover
     *
     * @return  self
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get the value of available
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set the value of available
     *
     * @return  self
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }
}
