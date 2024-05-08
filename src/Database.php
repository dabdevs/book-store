<?php 

class Database {
    private $host;
    private $port;
    private $username;
    private $password;
    private $database;
    private $connection;

    /**
     *  Constructor
     */
    public function __construct($host, $port, $username, $password, $database)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->connect();
    }

    /**
     * Create database connection
     */
    private function connect() 
    {
        try {
            $db ="mysql:host={$this->host};port={$this->port};dbname={$this->database}";
            $this->connection = new PDO($db, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     *  Prepare and excecute a mysql query with parameters
     */
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    /**
     *  Close database connection
     */
    public function close()
    {
        $this->connection = null;
    }

    /**
     *  Insert a record to the database and return inserted ID
     */
    public function insert($sql="", $params=[])
    {
        try {
            $this->query($sql, $params);
            return $this->connection->lastInsertId();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     *  Select rows from the database
     */
    public function select($sql, $params)
    {
        try {
            $stmt = $this->query($sql, $params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     *  Update a record in the database
     */
    public function update($sql, $params)
    {
        try {
            $this->query($sql, $params);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     *  Delete a record from the database
     */
    public function delete($sql, $params)
    {
        try {
            $this->query($sql, $params);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}



