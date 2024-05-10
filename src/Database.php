<?php

namespace App;

class Database
{
    private $host;
    private $port;
    private $username;
    private $password;
    private $db_name;
    private static $instance = null;
    private static $connection;

    /**
     *  Constructor
     */
    public function __construct($host, $port, $username, $password, $db_name)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->db_name = $db_name;

        $this->connect();
    }

    /**
     * Create database connection
     */
    private function connect()
    {
        try {
            $db = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name}";
            self::$connection = new \PDO($db, $this->username, $this->password);
            self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     *  Prepare and excecute a mysql query with parameters
     */
    protected static function query($sql, $params = [])
    {
        try {
            $stmt = self::$connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (\PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    /**
     *  Create instance if not exists
     */
    public static function getInstance($host, $port, $username, $password, $db_name)
    {
        if (self::$instance === null) {
            self::$instance = new self($host, $port, $username, $password, $db_name);
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return self::$connection;
    }

    /**
     *  Close database connection
     */
    public function close()
    {
        self::$connection = null;
    }

    /**
     *  Insert a record to the database and return inserted ID
     */
    protected static function insert($sql = "", $params = [])
    {
        try {
            self::query($sql, $params);
            return self::$connection->lastInsertId();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Select rows from the database
     */
    protected static function select($sql, $params)
    {
        try {
            $stmt = self::query($sql, $params);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Update a record in the database
     */
    protected static function update($sql, $params)
    {
        try {
            return self::query($sql, $params);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Delete a record from the database
     */
    protected static function delete($sql, $params)
    {
        try {
            return self::query($sql, $params);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
