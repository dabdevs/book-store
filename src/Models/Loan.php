<?php

namespace App\Models;
use App\Database\DB;

class Loan
{
    protected static $instance;
    private $table = "loans";
    public static $borrowed = "BORROWED";
    public static $returned = "RETURNED";
    private $id;
    private $book;
    private $user;
    private $borrow_date;
    private $return_date;
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
                if ($key === "book_id") {
                    $this->book = Book::action()->getById($value);
                }
                if ($key === "user_id") {
                    $this->user = DB::table("users")->select()->where("id = :id", [":id" => $value])->get()[0];
                }

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
        return DB::table($this->table)->delete()->where("id = :id", [":id" => $id])->get();
    }

    /**
     *  Retreive all loans from the database
     */
    public function getAll()
    {
        $sql = "SELECT l.*, u.email, u.firstname, u.lastname, b.title FROM loans l
                JOIN users u ON l.user_id = u.id 
                JOIN books b ON l.book_id = b.id
                ORDER BY l.id DESC";
        $loans = DB::table($this->table)->query($sql)->get();

        return $loans;
    }

    /**
     *  Get a loan by Id
     */
    public function getById($id)
    {
        $loan = DB::table($this->table)->select()->where("id = :id", ["id" => $id])->get();

        if ($loan) {
            $this->load((array)$loan[0]);
            return $this;
        }

        return null;
    }

    /**
     *  Get a loan by book
     */
    public function getByBook(Book $book)
    {
        $loan = DB::table($this->table)->select()->where("book_id = :book", ["book" => $book->getId()]);

        if ($loan) {
            $this->load((array)$loan[0]);
            return $this;
        }

        return null;
    }

    /**
     *  Get a loan by member
     */
    public function getByMember(Member $member)
    {
        $loan = DB::table($this->table)->select()->where("user_id = :user_id", [":user_id" => $member->getId()]);

        if ($loan) {
            $this->load((array)$loan[0]);
            return $this;
        }

        return null;
    }

    /**
     *  Get a loan by member and book
     */
    public function getByMemberAndBook(int $user_id, Book $book)
    {
        $loan = DB::table($this->table)
            ->select()
            ->where("user_id = :user_id AND book_id = :book_id", ["user_id" => $user_id, "book_id" => $book->getId()])
            ->get();

        if ($loan) {
            $this->load((array)$loan[0]);
            return $this;
        }

        return null;
    }

    /**
     *  Get the amount of loans 
     */
    public function count()
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
            "user" => $this->user,
            "borrow_date" => $this->borrow_date,
            "return_date" => $this->return_date,
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
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of borrowDate
     */
    public function getBorrowDate()
    {
        return $this->borrow_date;
    }

    /**
     * Set the value of borrowDate
     *
     * @return  self
     */
    public function setBorrowDate($borrowDate)
    {
        $this->borrow_date = $borrowDate;

        return $this;
    }

    /**
     * Get the value of returnDate
     */
    public function getReturnDate()
    {
        return $this->return_date;
    }

    /**
     * Set the value of returnDate
     *
     * @return  self
     */
    public function setReturnDate($returnDate)
    {
        $this->return_date = $returnDate;

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
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
