<?php

namespace App\Service;

class StringHelper
{

    /**
     * @param $input
     * @param false $capitalizeFirstCharacter
     * @return string
     */
    public static function snakeCaseToCamelCase($input, bool $capitalizeFirstCharacter = false): string
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $input)));
        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }
        return $str;
    }

    /**
     * @param string $input
     * @return string
     */
    public static function camelCaseToSnakeCase(string $input): string
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $result = $matches[0];
        foreach ($result as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $result);
    }

}
