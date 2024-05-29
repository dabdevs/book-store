<?php

namespace App\Models;

use App\Database\DB;

abstract class User
{
    protected static $instance;
    protected $table = "users";
    public static $admin = "ADMIN";
    public static $librerian = "LIBRERIAN";
    public static $member = "MEMBER";
    protected $id;
    protected $firstname;
    protected $lastname;
    protected $email;
    protected $password;
    protected $birth_date;
    protected $role;
    protected $avatar;
    protected $member_id;
    protected $bio;
    protected $cellphone;
    protected $city;

    public function __construct()
    {
    }

    /**
     *  Create a new member instance if it does not exist
     */
    public static function action()
    {
        self::$instance = new self();

        return self::$instance;
    }

    /**
     *  Retreive all users from the database
     */
    public function getAll(array $orderBy = [])
    {
        $users = DB::table($this->table)->select()->where("role = :role", ["role" => $this->role]);

        return $users;
    }

    /**
     *  Load input data
     */
    public function load($data)
    {
        if (!empty($data)) {
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
     *  Delete existing user
     */
    public function delete($id)
    {
        return DB::table($this->table)->delete()->where("id = :id", ["id" => $id]);
    }

    /**
     *  Get a user by Id
     */
    public function getById($id)
    { 
        $user = DB::table($this->table)->select()->where("id = :id AND role = :role", ["id" => $id, "role" => $this->role]);
   
        if ($user) {
            $this->load((array)$user[0]);
            return $this;
        }

        return null;
    }

    /**
     *  Get a user by email
     */
    public function getByEmail($email)
    {
        $user = DB::table($this->table)->select()->where("email = :email AND role = :role", ["email" => $email, "role" => $this->role]);

        if ($user) {
            $this->load((array)$user[0]);
            return $this;
        }

        return null;
    }

    /**
     *  Get the amount of users 
     */
    public function count()
    {
        return (int)DB::table("users")->select("COUNT(id) as count")->where("role = :role", [":role" => $this->role])[0]->count;
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
            "birth_date" => $this->birth_date,
            "role" => $this->role,
            "avatar" => $this->avatar,
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
        return $this->birth_date;
    }

    /**
     * Set the value of birthDate
     *
     * @return  self
     */
    public function setBirthDate($birthDate)
    {
        $this->birth_date = $birthDate;

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

    /**
     * Get the value of avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the value of member_id
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     * Set the value of member_id
     *
     * @return  self
     */
    public function setMemberId($memberId)
    {
        $this->member_id = $memberId;

        return $this;
    }

    /**
     * Get the value of bio
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set the value of bio
     *
     * @return  self
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get the value of cellphone
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * Set the value of cellphone
     *
     * @return  self
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;

        return $this;
    }

    /**
     * Get the value of city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }
}
