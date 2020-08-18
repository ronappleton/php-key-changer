<?php

declare(strict_types=1);

namespace RonAppleton\PhpKeyChanger;

use http\Exception\RuntimeException;

class PhpKeyChanger
{
    /**
     * Return an array reKeyed to the chosen case.
     *
     * Valid cases: studly, camel, pascal, snake, kebab.
     *
     * @param mixed $object
     * @param string $case
     *
     * @return mixed
     */
    public static function reKey($object, string $case = 'snake')
    {
        $objectType = getType($object);

        $object = static::getArray($object, $objectType);

        if ($object === null) {
            throw new RuntimeException("Unable to convert object type for conversion [$objectType]");
        }

        $object = self::changeKeyCaseRecursive($object, $case);

        if ($objectType === 'object') {
            return static::getJsonObject($object);
        } elseif ($objectType === 'string') {
            return static::getJsonString($object);
        }

        return $object;
    }

    /**
     * Get array from given object.
     *
     * @param $object
     * @param string $type
     *
     * @return array|null
     */
    private static function getArray($object, string $type): ?array
    {
        if ($type === 'object') {
            $object = json_decode(json_encode($object), true);
        } else {
            if ($type === 'string') {
                $object = json_decode($object, true);
            }
        }

        return gettype($object) === 'array' ? $object : null;
    }

    /**
     * Change all the keys of a multidimensional array to the given case.
     *
     * @param array $array
     * @param string $case
     *
     * @return array
     */
    private static function changeKeyCaseRecursive(array $array, string $case = 'snake'): array
    {
        return array_map(
            function ($item) use ($case) {
                if (is_array($item)) {
                    $item = static::changeKeyCaseRecursive($item, $case);
                }
                return $item;
            },
            static::changeKeyCase($array, $case)
        );
    }

    /**
     * Change all the keys of an array to the given case.
     *
     * @param array $array
     * @param string $case
     *
     * @return array
     */
    private static function changeKeyCase(array $array, $case = 'snake'): array
    {
        $newArray = [];

        foreach ($array as $key => $value) {
            $newArray[is_string($key) ? StringConverters::$case($key) : $key] = $value;
        }

        return $newArray;
    }

    /**
     * Returns an array as a json object.
     *
     * @param array $array
     *
     * @return object
     */
    private static function getJsonObject(array $array): object
    {
        return json_decode(json_encode($array), false);
    }

    /**
     * Returns an array as a json string.
     *
     * @param array $array
     *
     * @return string
     */
    private static function getJsonString(array $array): string
    {
        return json_encode($array);
    }
}
