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
    private $member;
    private $borrow_date;
    private $return_date;
    private $due_date;
    private $status;
    private $creator;
    private $created_at;
    private $updated_at;

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
     *  Set Due Date
     */
    public function setEndDate($endDate)
    {
        $this->due_date = $endDate;

        return $this;
    }

    /**
     *  Get Due Date
     */
    public function getDueDate()
    {
        return $this->due_date;
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

                if ($key === "book_id") {
                    $book = Book::action()->getById($value);
                    $this->setBook($book);
                }

                if ($key === "member_id") {
                    $member = Member::action()->getById($value);
                    $this->setMember($member);
                }

                if ($key === "creator") {
                    $creator = Librerian::action()->getById($value) ?? Admin::action()->getById($value);
                    $this->setCreator($creator);
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
                JOIN users u ON l.member_id = u.id 
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
        $loan = DB::table($this->table)->select()->where("member_id = :member_id", [":member_id" => $member->getId()]);
        
        if ($loan) {
            $this->load((array)$loan[0]);
            return $this;
        }

        return null;
    }

    /**
     *  Get a loan by member and book
     */
    public function getByMemberAndBook(int $member_id, Book $book)
    {
        $loan = DB::table($this->table)
            ->select()
            ->where("member_id = :member_id AND book_id = :book_id", ["member_id" => $member_id, "book_id" => $book->getId()])
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
        return DB::table($this->table)->count();
    }

    /**
     *  Get top members
     */
    public function getTopMembers()
    {
        $sql = "SELECT COUNT(l.member_id) as loans, u.email, u.firstname, u.lastname, u.city FROM loans l
                JOIN users u ON l.member_id = u.id 
                GROUP BY l.member_id
                ORDER BY loans DESC";

        $members = DB::table($this->table)
            ->query($sql)
            ->limit(3)
            ->get();

        return $members;
    }

    /**
     *  Get top latest loans
     */
    public function latestLoans()
    {
        $sql = "SELECT
                    b.title,
                    l.borrow_date,
                    l.return_date,
                    u.email,
                    u.firstname,
                    u.lastname
                FROM
                    loans l
                    JOIN users u ON l.member_id = u.id
                    JOIN books b ON l.book_id = b.id
                WHERE
                    l.status = 'BORROWED'
                ORDER BY l.borrow_date DESC";

        $loans = DB::table($this->table)
            ->query($sql)
            ->limit(3)
            ->get();

        return $loans;
    }

    /**
     *  Get top latest returns
     */
    public function latestReturns()
    {
        $sql = "SELECT
                    b.title,
                    l.borrow_date,
                    l.return_date,
                    u.email,
                    u.firstname,
                    u.lastname
                FROM
                    loans l
                    JOIN users u ON l.member_id = u.id
                    JOIN books b ON l.book_id = b.id
                WHERE
                    l.status = 'RETURNED'
                ORDER BY l.return_date DESC";

        $returns = DB::table($this->table)
            ->query($sql)
            ->limit(3)
            ->get();

        return $returns;
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
            "borrow_date" => $this->borrow_date,
            "due_date" => $this->due_date,
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

    /**
     * Get the creator of the loan
     */ 
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set the creator
     *
     * @return  self
     */ 
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getDateCreated()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setDateCreated($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */ 
    public function getLastUpdated()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setLastUpdated($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
