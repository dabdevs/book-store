<?php

namespace App\Models;

use App\Database;

class User extends Database
{
    private $id;
    public $admin = "ADMIN";
    public $librerian = "LIBRERIAN";
    public $member = "MEMBER";
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $birthDate;
    private $role;

    public function __construct($firstname, $lastname, $email, $password, $birthDate = "", $role)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->birthDate = $birthDate;
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
            $date_format = \DateTime::createFromFormat("Y/m/d", $this->birthDate);
            $birthDate = $date_format->format('Y-m-d');
            $params = array($this->firstname, $this->lastname, $this->email, password_hash($this->password, PASSWORD_DEFAULT), $birthDate, $this->role);

            $sql = "INSERT INTO users (f_name, l_name, email, password, birth_date, role) VALUES(?, ?, ?, ?, ?, ?)";
            $last_id = self::insert($sql, $params);
            return $last_id;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Find a user by a specific column
     */
    public static function findBy($column, $val)
    {
        $sql = "SELECT * FROM users WHERE $column = ?";
        $result = self::select($sql, [$val]);

        return empty($result) ? null : $result[0];
    }

    /**
     *  Find all users
     */
    public static function findAll()
    {
        $sql = "SELECT * FROM users ORDER BY created_at";
        $result = self::select($sql, []);
        return $result;
    }

    /**
     *  Update a user by ID
     */
    public static function updateById($id, $data)
    {
        $params = [];
        $sql = 'UPDATE users SET ';

        if (isset($data["firstname"])) {
            $sql .= ' f_name = ?, ';
            $params[] = $data["firstname"];
        }

        if (isset($data["lastname"])) {
            $sql .= ' l_name = ?, ';
            $params[] = $data["lastname"];
        }

        if (isset($data["email"])) {
            $sql .= ' email = ?, ';
            $params[] = $data["email"];
        }

        if (isset($data["birthDate"])) {
            $sql .= ' birth_date = ?, ';
            $params[] = $data["birthDate"];
        }

        if (isset($data["role"])) {
            $sql .= ' role = ?, ';
            $params[] = $data["role"];
        }

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
     *  Get number of users
     */
    public static function count()
    {
        $sql = "SELECT COUNT(*) AS QUANTITY FROM users";
        $result = self::select($sql, []);
        return (int)$result[0]["QUANTITY"];
    }

    /**
     *  Convert user object to array
     */
    public function toArray()
    {
        return [
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "email" => $this->email,
            "birthDate" => $this->birthDate,
            "role" => $this->role,
        ];
    }

    /**
     * Get the value of f_name
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of f_name
     *
     * @return  self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of l_name
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of l_name
     *
     * @return  self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of birth_date
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set the value of birth_date
     *
     * @return  self
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}
