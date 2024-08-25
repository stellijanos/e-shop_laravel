<?php

namespace App\Utils;


class Utils
{


    public static function getAllQueryParams($req)
    {

        $key = $req['specName'];
        $value = $req['specValue'];
        $apply = $req['apply'];
        $queryString = $req['queryString'];

        parse_str($queryString, $queryParams);

        if ($key === "sortBy") {
            $queryParams['sortBy'] = $value;
            if ($value === "default") {
                unset($queryParams['sortBy']);
            }
            return $queryParams;
        }

        if ($apply === "true") {

            if (!isset($queryParams[$key])) {
                $queryParams[$key] = [];
            }

            if (!is_array($queryParams[$key])) {
                $queryParams[$key] = [$queryParams[$key]];
            }

            if (!in_array($value, $queryParams[$key])) {
                $queryParams[$key][] = $value;
            }
        } else {

            if (!isset($queryParams[$key]))
                return;

            if (!is_array($queryParams[$key])) {
                if ($queryParams[$key] === $value) {
                    unset($queryParams[$key]);
                }
                return;
            }
            $queryParams[$key] = array_values(array_filter($queryParams[$key], function ($v) use ($value) {
                return $v !== $value;
            }));

            if (empty($queryParams[$key])) {
                unset($queryParams[$key]);
            }
        }

        return $queryParams;
    }


}