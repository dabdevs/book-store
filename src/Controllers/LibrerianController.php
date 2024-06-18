<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Librerian;
use App\Utils\Helper;
use App\Validations\UserValidation;

class LibrerianController extends Controller
{
    public function __construct()
    {
        session_start();

        if ($_SESSION["user"]->role !== "ADMIN") {
            header("Location:/forbidden");
            exit;
        }
    }

    /**
     *  Librerians index page
     */
    public function index()
    {
        try {
            $librerians = Librerian::action()->getAll();
            $cardsData = $this->getCardsData();
            $page = "Librerians";

            $this->render("dashboard", compact("librerians", "cardsData", "page"));
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
            $page = "Create Librerian";
            $this->render("dashboard", compact("cardsData", "page"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Create a librerian in the database
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
            Librerian::action()->create($data);

            // Success message
            $_SESSION["success"] = "Librerian created successfuly!";

            // Redirect back
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit;
        } catch (\Exception $e) {
            // Error message
            $_SESSION["error"] = "Operation failed! Please try again later.";

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
            $queryParams = Helper::getQueryParameters();
            $id = $queryParams["id"];
            $cardsData = $this->getCardsData();
            $page = "Show Librerian";
            $librerian = Librerian::action()->getById($id);

            $this->render("dashboard", compact("cardsData", "librerian", "page"));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *  Update a librerian using ID
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
            Librerian::action()->update($data);

            // Success message
            $_SESSION["success"] = "Librerian updated successfuly!";

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
     *  Delete a librerian using ID
     */
    public function destroy()
    {
        try {
            $id = $_POST["id"];

            Librerian::action()->delete($id);

            session_start();

            // Success message
            $_SESSION["success"] = "Librerian deleted successfuly!";

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
}
