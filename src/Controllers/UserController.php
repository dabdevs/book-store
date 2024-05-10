<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     *  Load all users from the database
     */
    public function index()
    {
        try {
            $user = User::find_all();
            $this->render('index', $user);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Create a user in the database
     */
    public function store()
    {
        try {
            $user = new User('Frandy', 'Jean', 'fjean@gmail.com', '1988/11/30', 'MEMBER');
            $last_id = $user->save();
            echo $last_id;
            $this->render('index', $user->to_array());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Update a user using ID
     */
    public function update()
    {
        try {
            $id = $_POST["id"];

            User::update_by_id($id, ["f_name" => "Alain", "email" => "alainjean@gmail.com"]);
            $user = User::find_by("id", $id);
            $this->render('index', $user);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Delete a user using ID
     */
    public function destroy()
    {
        try {
            $id = $_POST["id"];

            User::destroy($id);

            $this->render('index');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
