<?php

namespace App\Models;

use App\Database;

class User extends Database
{
    public $admin = "ADMIN";
    public $librerian = "LIBRERIAN";
    public $member = "MEMBER";
    private $f_name;
    private $l_name;
    private $email;
    private $birth_date;
    private $role;

    public function __construct($f_name, $l_name, $email, $birth_date = "", $role)
    {
        $this->f_name = $f_name;
        $this->l_name = $l_name;
        $this->email = $email;
        $this->birth_date = $birth_date;
        $this->role = $role;
    }

    public function __call($name, $args)
    {
        var_dump($name, $args);
    }

    /**
     *  Create a user in the database
     */
    public function save()
    {
        try {
            $date_format = \DateTime::createFromFormat("Y/m/d", $this->birth_date);
            $birth_date = $date_format->format('Y-m-d');
            $params = array($this->f_name, $this->l_name, $this->email, $birth_date, $this->role);

            $sql = "INSERT INTO users (f_name, l_name, email, birth_date, role) VALUES(?, ?, ?, ?, ?)";
            $last_id = self::insert($sql, $params);
            return $last_id;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Find a user by a specific column
     */
    public static function find_by($column, $val)
    {
        $sql = "SELECT * FROM users WHERE $column = ?";
        $result = self::select($sql, [$val]);
        return $result;
    }

    /**
     *  Find all users
     */
    public static function find_all()
    {
        $sql = "SELECT * FROM users";
        $result = self::select($sql, []);
        return $result;
    }

    /**
     *  Update a user by ID
     */
    public static function update_by_id($id, $data)
    {
        $params = [];
        $sql = 'UPDATE users SET ';

        if (isset($data["f_name"])) {
            $sql .= ' f_name = ?, ';
            $params[] = $data["f_name"];
        }

        if (isset($data["l_name"])) {
            $sql .= ' l_name = ?, ';
            $params[] = $data["l_name"];
        }

        if (isset($data["email"])) {
            $sql .= ' email = ?, ';
            $params[] = $data["email"];
        }

        if (isset($data["birth_date"])) {
            $sql .= ' birth_date = ?, ';
            $params[] = $data["birth_date"];
        }

        if (isset($data["role"])) {
            $sql .= ' role = ?, ';
            $params[] = $data["role"];
        }

        // $sql = rtrim($sql, ', ');

        $sql .= ' updated_at = NOW() WHERE id = ?';

        $params[] = $id;

        $result = self::update($sql, $params);

        return $result;
    }

    /**
     *  Delete a user from the database
     */
    public static function destroy($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $result = User::delete($sql, [$id]);
        return $result;
    }

    /**
     *  Convert user object to array
     */
    public function to_array()
    {
        return [
            "f_name" => $this->f_name,
            "l_name" => $this->l_name,
            "email" => $this->email,
            "birth_date" => $this->birth_date,
            "role" => $this->role,
        ];
    }
}
