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
}

