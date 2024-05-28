<?php

namespace App\Models;

class Librerian extends User
{
    private static $librerian_id;

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

    public static function array()
    {
        return [
            "librerian_id" => self::$librerian_id,
        ];
    }
}
