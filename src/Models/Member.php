<?php

namespace App\Models;

use App\DB;

class Member extends User
{
    private $table = "users";
    private $role = "MEMBER";

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
     *  Get a member by Id
     */
    public function getById($id)
    {
        $member = DB::table($this->table)->select()->where("id = :id AND role = :role", ["id" => $id, "role" => $this->role]);

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
        $member = DB::table($this->table)->select()->where("email = :email AND role = :role", ["email" => $email, "role" => $this->role]);

        if ($member) {
            $this->load((array)$member[0]);
            return $this;
        }

        return null;
    }

    /**
     *  Get all the member's loans
     */
    public function getLoans()
    {
        return DB::table("loans")->select()->where("user_id = :user_id", [":user_id" => $this->getId()]);
    }

    /**
     *  Create a loan for the member
     */
    public function createLoan(array $data)
    {
        return DB::table("loans")->insert($data);
    }
}
