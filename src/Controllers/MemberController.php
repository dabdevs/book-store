<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Member;
use App\Utils\Helper;
use App\Validations\UserValidation;

class MemberController extends Controller
{
    public function __construct()
    {
        session_start();

        if (!in_array($_SESSION["user"]->role, ["ADMIN", "LIBRERIAN"])) {
            header("Location:/forbidden");
            exit;
        }
    }

    /**
     *  Members index page
     */
    public function index()
    {
        try {
            $members = Member::action()->getAll();
            $cardsData = $this->getCardsData();
            $page = "Members";

            $this->render("dashboard", compact("members", "cardsData", "page"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Render create page
     */
    public function create()
    {
        try {
            $cardsData = $this->getCardsData();
            $page = "Create Member";
            $this->render("dashboard", compact("cardsData", "page"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Create a member in the database
     */
    public function store()
    {
        try {
            // Validate form
            $data = $this->validate(UserValidation::$rules);

            $data["avatar"] = $data["avatar"]["name"]; 

            // Upload file and set filename in POST data
            // Helper::uploadFile("avatar");

            // Create new book
            Member::action()->create($data);

            // Success message
            $_SESSION["success"] = "Member created successfuly!";

            // Redirect back
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit;
        } catch (\Exception $e) {
            // Error message
            $_SESSION["error"] = $e->getMessage();

            // Redirect back
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit;
        }
    }

    /**
     *  Render show page
     */
    public function show()
    {
        try {
            $id = $_GET["id"];
            $cardsData = $this->getCardsData();
            $page = "Show Member";
            $member = Member::action()->getById($id);
            $this->render("dashboard", compact("cardsData", "member", "page"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Update a member using ID
     */
    public function update()
    {
        try {
            // Validate form
            $data = $this->validate(UserValidation::$rules);

            $data["avatar"] = $data["avatar"]["name"]; 
            
            // Upload file and set filename in POST data
            // Helper::uploadFile("avatar");

            // Validate form data
            Member::action()->update($data);

            // Success message
            $_SESSION["success"] = "Member updated successfuly!";

            // Redirect back
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit;
        } catch (\Exception $e) {
            // Error message
            $_SESSION["error"] = $e->getMessage();

            // Redirect back
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit;
        }
    }

    /**
     *  Delete a member using ID
     */
    public function destroy()
    {
        try {
            $id = $_POST["id"];

            Member::action()->delete($id);

            session_start();

            // Success message
            $_SESSION["success"] = "Member deleted successfuly!";

            // Redirect back
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit;
        } catch (\Exception $e) {
            // Error message
            $_SESSION["error"] = $e->getMessage();

            // Redirect back
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit;
        }
    }

    /**
     *  Get member by email or document ID
     */
    public function getMember()
    {
        $search = $_GET["q"];

        if (Helper::validateEmail($search)) {
            // Get member by email
            $member = Member::action()->getByEmail($search);
        } else {
            // Get member by document ID
            $member = Member::action()->getByDocumentId($search);
        }

        echo json_encode(empty($member) ? null : $member->toArray());
    }
}
