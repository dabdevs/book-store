<?php

namespace App\Models;

use App\Database\DB;

class Loan
{
    protected static $instance;
    private $table = "loans";
    private $id;
    private $book;
    private $member;
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
     *  Delete existing loan
     */
    public function delete($id)
    {
        return DB::table($this->table)->delete()->where("id = :id", ["id" => $id]);
    }

    /**
     *  Retreive all loans from the database
     */
    public function getAll(array $orderBy = [])
    {
        $sql = "SELECT l.*, u.firstname, u.lastname, b.title FROM loans l
                JOIN users u ON l.user_id = u.id 
                JOIN books b ON l.book_id = b.id
                ORDER BY l.id DESC";
        $loans = DB::table($this->table)->query($sql);

        return $loans;
    }

    /**
     *  Get a loan by Id
     */
    public function getById($id)
    {
        return DB::table($this->table)->select()->where("id = :id", ["id" => $id])[0];
    }

    /**
     *  Get a loan by book
     */
    public function getByBook(Book $book)
    {
        return DB::table($this->table)->select()->where("book_id = :book", ["book" => $book->getId()]);
    }

    /**
     *  Get a loan by user
     */
    public function getByUser(User $user)
    {
        return DB::table($this->table)->select()->where("user_id = :user", ["user" => $user->getId()]);
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
            "book" => $this->book,
            "member" => $this->member,
            "borrowDate" => $this->borrowDate,
            "returnDate" => $this->returnDate,
            "status" => $this->status,
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
     * Get the value of book
     */ 
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set the value of book
     *
     * @return  self
     */ 
    public function setBook($book)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get the value of member
     */ 
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set the value of member
     *
     * @return  self
     */ 
    public function setMember($member)
    {
        $this->member = $member;

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
