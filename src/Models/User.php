<?php

namespace App\Models;

use App\DB;

class User
{
    protected static $instance;
    private $table = "users";
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
        return DB::table($this->table)->select()->where("id = :id", ["id" => $id]);
    }

    /**
     *  Get a user by email
     */
    public function getByEmail($email)
    {
        return DB::table($this->table)->select()->where("email = :email", ["email" => $email]);
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
}
