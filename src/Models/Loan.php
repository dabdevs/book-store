<?php

namespace App\Models;

use App\DB;
use Exception;

class Loan
{
    protected static $instance;
    private $table = "loans";
    public $borrowed = "BORROWED";
    public $returned = "RETURNED";
    private $id;
    private $user;
    private $book;
    private $borrowDate;
    private $returnDate;
    private $status;

    public function __construct()
    {
    }

    /**
     *  Create a new loan instance if it does not exist
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
     *  Create a new loan
     */
    public function create(array $data)
    {
        $lastId = DB::table($this->table)->insert($data);
        $this->load($data, ["id" => $lastId]);

        return $this;
    }

    /**
     *  Update existing loan
     */
    public function update(array $data)
    {
        return DB::table($this->table)->update($data);
    }

    /**
     *  Retreive all loans from the database
     */
    public function getAll()
    {
        return DB::table($this->table)->select()->all();
    }

    /**
     *  Get a loan by Id
     */
    public function getById($id)
    {
        return DB::table($this->table)->select()->where("id = :id", ["id" => $id]);
    }

    /**
     *  Get a loan by book
     */
    public function getByBook(Book $book)
    {
        return DB::table($this->table)->select()->where("book_id = :book_id", ["book_id" => $book->getId()]);
    }

    /**
     *  Get a loan by user
     */
    public function getByUser(User $user)
    {
        return DB::table($this->table)->select()->where("user_id = :user_id", ["user_id" => $user->getId()]);
    }

    /**
     *  Get the amount of loans 
     */
    public static function count()
    {
        return DB::table("loans")->count();
    }

    /**
     *  Convert loan object to array
     */
    public function toArray()
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user->getId(),
            "book_id" => $this->book->getId(),
            "borrowDate" => $this->borrowDate,
            "returnDate" => $this->returnDate,
            "status" => $this->status
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
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser(User $user)
    {
        if ($user->getRole() !== User::$member) {
            throw new Exception("User must be a member");
        }

        $this->user = $user;

        return $this;
    }

    /**
     * Get the book associated with the loan
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set the book associated with the loan
     *
     * @return  self
     */
    public function setBook(Book $book)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of borrowDate
     */
    public function getBorrowDate()
    {
        return $this->borrowDate;
    }

    /**
     * Set the value of borrowDate
     *
     * @return  self
     */
    public function setBorrowDate($borrowDate)
    {
        $this->borrowDate = $borrowDate;

        return $this;
    }

    /**
     * Get the value of returnDate
     */
    public function getReturnDate()
    {
        return $this->returnDate;
    }

    /**
     * Set the value of returnDate
     *
     * @return  self
     */
    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;

        return $this;
    }
}
