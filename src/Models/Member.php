<?php

namespace App\Models;

use App\Database\DB;

class Member extends User
{
    private $table = "users";
    public static $role = "MEMBER";

    /**
     *  Create a new Member instance if it does not exist
     */
    public static function action()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     *  Retreive all members from the database
     */
    public function getAll()
    {
        return DB::table($this->table)->select()->where("role = :role", [":role" => self::$role]);
    }

    /**
     *  Get a member by Id
     */
    public function getById($id)
    {
        $member = DB::table($this->table)->select()->where("id = :id AND role = :role", ["id" => $id, "role" => self::$role]);

        if ($member) {
            $this->load((array)$member[0]);
            return $this;
        }

        return null;
    }

    /**
     *  Get a member by email
     */
    public function getByEmail($email)
    {
        $member = DB::table($this->table)->select()->where("email = :email AND role = :role", ["email" => $email, "role" => self::$role]);

        if ($member) {
            $this->load((array)$member[0]);
            return $this;
        }

        return null;
    }

    /**
     *  Get the amount of members 
     */
    public static function count()
    {
        return count(DB::table("users")->select()->where("role = :role", [":role" => self::$role]));
    }

    /**
     *  Get all the member's loans
     */
    public function getLoans()
    {
        return DB::table("loans")->select()->where("user_id = :user_id", [":user_id" => $this->getId()]);
    }
}
