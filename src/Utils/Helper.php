<?php 

namespace App\Utils;

class Helper {
    public static function getQueryParameters()
    {
        $queryParams = explode("?", $_SERVER['REQUEST_URI'])[1];
        $queryParams = explode("&", $queryParams);

        $paramsArray = [];

        foreach ($queryParams as $param) {
            $p = explode("=", $param);
            $paramsArray[$p[0]] = $p[1];
        }

        return $paramsArray;
    }

    public static function updateFile($filename)
    {
        if ($_FILES[$filename]["name"] !== "") {
            $fileTmpName = $_FILES[$filename]["tmp_name"];
            $fileName = $_FILES[$filename]["name"];

            // Explode fileName to get extension
            $fileNameCmps = explode(".", $fileName);

            // Convert last element of array (extension) to lowercase
            $fileExtension = strtolower(end($fileNameCmps));

            // Create new hashed filename
            $fileName = md5(time() . $fileName) . "." . $fileExtension;

            // Directory where the file will be moved
            $uploadFileDir = dirname(__DIR__) . "/images/books/";
            ///Applications/MAMP/htdocs/book-store/src/images/books/09f407843a6133516aefe59d24fffe10.jpg
            // Full path of the file
            $filePath = $uploadFileDir . $fileName;

            // Create the directory if it does not exist
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
                chmod($uploadFileDir, 0755);
            }

            // Move file to directory
            if (!move_uploaded_file($fileTmpName, $filePath)) {
                $_SESSION["error"] = "An error ocurred while uploading the file. Please try again.";

                // Redirect back
                header("Location:" . $_SERVER["HTTP_REFERER"]);
                exit;
            }

            // Save fileName in array to be saved
            $_POST[$filename] = "/images/books/" . $fileName;
        }
    }
}

