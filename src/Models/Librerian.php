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
        self::$instance = new self("LIBRERIAN");

        return self::$instance;
    }
}
