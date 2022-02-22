<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class AbstractRequestToEntityMapper
{

    /**
     * @param Request $request
     * @param object $entity
     * @param array $excludedFields
     */
    public static function map(Request $request, object $entity, array $excludedFields = [])
    {
        foreach ($request->toArray() as $key => $value) {
            if (!in_array($key, $excludedFields)) {
                $method = 'set' . ucfirst($key);
                if (method_exists($entity, $method)) {
                    $entity->{$method}($value);
                }
            }
        }
    }

}
