<?php

namespace App\Models;

use App\DB;

class User
{
    protected static $instance;
    private $table = "users";
    public static $admin = "ADMIN";
    public static $librerian = "LIBRERIAN";
    public static $member = "MEMBER";
    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $birthDate;
    private $role;

    public function __construct()
    {
    }

    /**
     *  Create a new User instance if it does not exist
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
    protected function load(array $data)
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
     *  Create a new user
     */
    public function create(array $data)
    {
        $lastId = DB::table($this->table)->insert($data);
        $this->load($data, ["id" => $lastId]);

        return $this;
    }

    /**
     *  Update existing user
     */
    public function update(array $data)
    {
        return DB::table($this->table)->update($data);
    }

    /**
     *  Retreive all users from the database
     */
    public function getAll()
    {
        return DB::table($this->table)->select()->all();
    }

    /**
     *  Get a user by Id
     */
    public function getById($id)
    {
        $user = DB::table($this->table)->select()->where("id = :id", ["id" => $id]);

        return $user ? $user[0] : null;
    }

    /**
     *  Get a user by email
     */
    public function getByEmail($email)
    {
        $user = DB::table($this->table)->select()->where("email = :email", ["email" => $email]);

        return $user ? $user[0] : null;
    }

    /**
     *  Get the amount of users 
     */
    public static function count()
    {
        return DB::table("users")->count();
    }

    /**
     *  Convert user object to array
     */
    public function toArray()
    {
        return [
            "id" => $this->id,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "email" => $this->email,
            "birthDate" => $this->birthDate,
            "role" => $this->role,
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
     * Get the value of firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
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
     * Get the value of birthDate
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set the value of birthDate
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
