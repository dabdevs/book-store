<?php

namespace App\Models;

class Admin extends User
{
    public function __construct($role)
    {
        $this->role = $role;
    }

    /**
     *  Create a new Admin instance if it does not exist
     */
    public static function action()
    {
        self::$instance = new self("ADMIN");

        return self::$instance;
    }
}
