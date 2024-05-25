<?php

namespace App\Models;

use App\Database\DB;

class Member extends User
{
    public function __construct($role)
    {
        $this->role = $role;
    }

    /**
     *  Create a new member instance if it does not exist
     */
    public static function action()
    {
        if (!self::$instance) {
            self::$instance = new self("MEMBER");
        }

        return self::$instance;
    }

    /**
     *  Get all the member's loans
     */
    public function getLoans()
    {
        return DB::table("loans")->select()->where("user_id = :user_id", [":user_id" => $this->getId()]);
    }
}
