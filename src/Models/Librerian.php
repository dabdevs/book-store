<?php

namespace App\Models;

class Librerian extends User
{
    public function __construct($role)
    {
        $this->role = $role;
    }

    /**
     *  Create a new Librerian instance if it does not exist
     */
    public static function action()
    {
        if (!self::$instance) {
            self::$instance = new self("LIBRERIAN");
        }

        return self::$instance;
    }

    // /**
    //  *  Get a librerian by Id
    //  */
    // public function getById($id)
    // {
    //     $librerian = DB::table($this->table)->select()->where("id = :id AND role = :role", ["id" => $id, "role" => self::$role]);

    //     if ($librerian) {
    //         $this->load((array)$librerian[0]);
    //         return $this;
    //     }

    //     return null;
    // }

    // /**
    //  *  Get a librerian by email
    //  */
    // public function getByEmail($email)
    // {
    //     $librerian = DB::table($this->table)->select()->where("email = :email AND role = :role", ["email" => $email, "role" => self::$role]);

    //     if ($librerian) {
    //         $this->load((array)$librerian[0]);
    //         return $this;
    //     }

    //     return null;
    // }

    // /**
    //  *  Get the amount of librerians 
    //  */
    // public static function count()
    // {
    //     return DB::table("users")->select()->where("role = :role", [":role" => self::$role]);
    // }

    // /**
    //  *  Get all the librerian's loans
    //  */
    // public function getLoans()
    // {
    //     return DB::table("loans")->select()->where("user_id = :user_id", [":user_id" => $this->getId()]);
    // }

    // /**
    //  *  Create a loan for the librerian
    //  */
    // public function createLoan(array $data)
    // {
    //     return DB::table("loans")->insert($data);
    // }
}
