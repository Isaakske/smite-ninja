<?php

declare(strict_types=1);

namespace App\Common;

class Mapper
{
    public static function mapObjects(array $objects, callable $keyCallable, callable $valueCallable = null): array
    {
        return array_reduce($objects, function (array $carry, object $object) use ($keyCallable, $valueCallable) {
            $keys = $keyCallable($object);
            // Allow for clean syntax when there is a singular key
            if (!is_array($keys)) {
                $keys = [$keys];
            }

            // As long as we have keys defined, we want to keep digging deeper into the array to place or object/value at the lowest level
            $data = &$carry;
            foreach ($keys as $key) {
                if (!array_key_exists($key, $data)) {
                    $data[$key] = [];
                }

                $data = &$data[$key];
            }

            // Allow for clean syntax when the value should just be the complete object
            $value = $valueCallable
                ? $valueCallable($object)
                : $object;

            // If the value is in the format of an array, we want to array_push that value to the lowest level array, rather than assigning a key to it
            is_array($value)
                ? $data[] = reset($value)
                : $data = $value;

            return $carry;
        }, []);
    }
}
