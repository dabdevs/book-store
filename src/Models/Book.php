<?php

namespace App\Models;

use App\Database;

class Book extends Database
{
    private $id;
    private $code;
    private $title;
    private $description;
    private $author;
    private $isbn;
    private $genre;
    private $publisher;
    private $publishedDate;
    private $available;

    public function __construct($code, $title, $description, $author, $isbn = "", $genre, $publisher, $publishedDate, $available)
    {
        $this->code = $code;
        $this->title = $title;
        $this->description = $description;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->genre = $genre;
        $this->publisher = $publisher;
        $this->publishedDate = $publishedDate;
        $this->available = $available;
    }

    public function __call($name, $args)
    {
        var_dump($name, $args);
    }

    /**
     *  Create a book in the database
     */
    public function save()
    {
        try {
            $params = array($this->code, $this->title, $this->description, $this->author, $this->isbn, $this->genre, $this->publisher, $this->publishedDate, $this->available);

            $sql = "INSERT INTO 
                        books (code, title, description, author, isbn, genre, publisher, published_date, available) 
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $last_id = self::insert($sql, $params);
            return $last_id;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Find a book by a specific column
     */
    public static function findBy($column, $val)
    {
        $sql = "SELECT * FROM books WHERE $column = ?";
        $result = self::select($sql, [$val]);

        return empty($result) ? null : $result[0];
    }

    /**
     *  Find all books
     */
    public static function findAll()
    {
        $sql = "SELECT * FROM books ORDER BY created_at";
        $result = self::select($sql, []);
        return $result;
    }

    /**
     *  Update a book by ID
     */
    public static function updateById($id, $data)
    {
        $params = [];
        $sql = 'UPDATE books SET ';

        if (isset($data["code"])) {
            $sql .= ' code = ?, ';
            $params[] = $data["code"];
        }

        if (isset($data["title"])) {
            $sql .= ' title = ?, ';
            $params[] = $data["title"];
        }

        if (isset($data["description"])) {
            $sql .= ' description = ?, ';
            $params[] = $data["description"];
        }

        if (isset($data["isbn"])) {
            $sql .= ' isbn = ?, ';
            $params[] = $data["isbn"];
        }

        if (isset($data["genre"])) {
            $sql .= ' genre = ?, ';
            $params[] = $data["genre"];
        }

        if (isset($data["publisher"])) {
            $sql .= ' publisher = ?, ';
            $params[] = $data["publisher"];
        }

        if (isset($data["published_date"])) {
            $sql .= ' published_date = ?, ';
            $params[] = $data["published_date"];
        }

        if (isset($data["available"])) {
            $sql .= ' available = ?, ';
            $params[] = $data["available"];
        }

        $sql .= ' updated_at = NOW() WHERE id = ?';

        $params[] = $id;

        $result = self::update($sql, $params);

        return $result;
    }

    /**
     *  Delete a book from the database
     */
    public static function destroy($id)
    {
        $sql = "DELETE FROM books WHERE id = ?";
        $result = book::delete($sql, [$id]);
        return $result;
    }

    /**
     *  Convert book object to array
     */
    public function toArray()
    {
        return [
            "code" => $this->code,
            "title" => $this->title,
            "description" => $this->description,
            "isbn" => $this->isbn,
            "genre" => $this->genre,
            "publisher" => $this->publisher,
            "published_date" => $this->publishedDate,
            "available" => $this->available,
        ];
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
     * Get the value of published_date
     */ 
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }

    /**
     * Set the value of published_date
     *
     * @return  self
     */ 
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;

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
