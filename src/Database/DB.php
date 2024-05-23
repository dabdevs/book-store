<?php

namespace App\Database;

use Exception;

class DB
{
    protected static $instance;
    protected static $connection;
    protected static $table;
    protected $query;
    protected $queryType;

    /**
     *  Set table to query from and create a DB connection
     */
    public static function table($table)
    {
        // Create an instance if it does not exist
        if (!self::$instance) {
            self::$instance = new self();
        }

        self::$table = $table;

        // Create the database connection
        if (!self::$connection) {
            try {
                $dsn = "mysql:host={$_ENV["DB_HOST"]};port={$_ENV["DB_PORT"]};dbname={$_ENV["DB_NAME"]}";
                self::$connection = new \PDO($dsn, $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);
                self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                throw $e->getMessage();
            }
        }

        return self::$instance;
    }

    /**
     *  Select data from DB
     */
    public function select()
    {
        $this->query = "SELECT * FROM " . self::$table . " ";
        
        return self::$instance;
    }

    /**
     *  Insert data into DB
     */
    public function insert(array $data)
    {
        $this->query = "INSERT INTO " . self::$table . " ";

        $fields = "";
        $values = "";
        $params = [];

        foreach ($data as $key => $value) {
            if ($key === "id") continue;
            $fields .= "$key,";
            $values .= "?,";
            $params[] = $value;
        }

        $fields = rtrim($fields, ',');
        $values = rtrim($values, ',');

        $this->query .= "($fields) VALUES($values)";

        $this->run($params);

        return self::$connection->lastInsertId();
    }

    /**
     *  Update record in DB
     */
    public function update(array $params)
    {
        if (count($params) === 0) {
            throw new Exception("Query parameters missing.");
        }

        if (!isset($params["id"])) {
            throw new Exception("Id missing.");
        }

        $this->query = "UPDATE " . self::$table . " SET ";

        foreach ($params as $key => $value) {
            if ($key === "id") continue;

            $this->query .= " $key = :$key, ";
            $params[":$key"] = $value;
        }

        $this->query .= " updated_at = NOW() WHERE id = :id";

        $params[":id"] = $params["id"];

        $this->run($params);

        return self::$instance;
    }

    /**
     *  Get all data from table
     */
    public function all()
    {
        $this->run();
        return self::$instance;
    }

    /**
     *  Delete data from DB
     */
    public function delete()
    {
        $this->query = "DELETE FROM " . self::$table . " ";

        return self::$instance;
    }

    /**
     *  Where clause for query
     */
    public function where(string $clause, array $params = [])
    {
        $this->query .= "WHERE $clause";
        
        return $this->run($params);
    }

    /**
     *  Oder by for query
     *  $orderBy['field', 'order']
     */
    public function orderBy(array $orderBy)
    {
        if (isset($orderBy["field"])) $this->query .= "ORDER BY " . $orderBy["field"];
        if (isset($orderBy["order"])) $this->query .= " " . $orderBy["order"];
        
        
        return $this->run();
    }

    /**
     *  Prepare and execute query
     */
    private function run($params = [])
    {
        // Prepare SQL query
        $stmt = self::$connection->prepare($this->query);

        // Bind query parameters
        $stmt->execute($params);

        // Fetch data
        if ($stmt) {
            $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
            if (is_array($data) && count($data) > 0) {
                return $data;
            }
        }

        return false;
    }

    /**
     *  Execute raw query
     */
    public function query($sql, $params = [])
    {
        $this->query = $sql;
        return $this->run($params);
    }

    /**
     *  Retreive amount of rows from table
     */
    public function count()
    {
        $this->query = "SELECT COUNT(*) AS quantity FROM " . self::$table;
        $result = $this->run();

        return (int)$result[0]->quantity;
    }
}
