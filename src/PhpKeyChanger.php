<?php

declare(strict_types=1);

namespace RonAppleton\PhpKeyChanger;

use RuntimeException;

/**
 * Class PhpKeyChanger
 * @package RonAppleton\PhpKeyChanger
 *
 * Re key a json string, json object or an array
 * to your chosen case.
 */
class PhpKeyChanger
{
    /**
     * @var StringConverters
     */
    private StringConverters $stringConverters;

    /**
     * Track our object type.
     *
     * @var string
     */
    private string $type;

    /**
     * PhpKeyChanger constructor.
     */
    public function __construct()
    {
        $this->stringConverters = new StringConverters();
    }

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
    public function reKey($object, string $case = 'snake')
    {
        $this->type = $this->getType($object);

        $object = $this->getArray($object);

        if ($object === null) {
            throw new RuntimeException("Unable to convert object type for conversion [$this->type]");
        }

        $object = self::changeKeyCaseRecursive($object, $case);

        if ($this->type === 'object') {
            return $this->getJsonObject($object);
        }

        if ($this->type === 'string') {
            return $this->getJsonString($object);
        }

        return $object;
    }

    /**
     * Get array from given object.
     *
     * @param $object
     *
     * @return array|null
     */
    private function getArray($object): ?array
    {
        if ($this->type === 'object') {
            $object = json_decode(json_encode($object), true);
        }

        if ($this->type === 'string') {
            $object = json_decode($object, true);
        }

        return $this->getType($object) === 'array' ? $object : null;
    }

    /**
     * Change all the keys of a multidimensional array to the given case.
     *
     * @param array $array
     * @param string $case
     *
     * @return array
     */
    private function changeKeyCaseRecursive(array $array, string $case = 'snake'): array
    {
        return array_map(
            function ($item) use ($case) {
                if (is_array($item)) {
                    $item = $this->changeKeyCaseRecursive($item, $case);
                }
                return $item;
            },
            $this->changeKeyCase($array, $case)
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
    private function changeKeyCase(array $array, $case = 'snake'): array
    {
        $newArray = [];

        foreach ($array as $key => $value) {
            $newArray[is_string($key) ? $this->stringConverters->$case($key) : $key] = $value;
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
    private function getJsonObject(array $array): object
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
    private function getJsonString(array $array): string
    {
        return json_encode($array);
    }

    /**
     * Find the object type.
     *
     * @param $object
     *
     * @return string
     */
    private function getType($object)
    {
        if (is_array($object)) {
            return 'array';
        }

        if (is_object($object)) {
            return 'object';
        }

        if (is_string($object)) {
            return 'string';
        }

        if (is_bool($object)) {
            return 'boolean';
        }

        if (is_float($object)) {
            return 'float';
        }

        if (is_int($object)) {
            return 'integer';
        }

        if ($object === null) {
            return 'null';
        }

        if (is_numeric($object)) {
            return 'numeric';
        }

        if (is_resource($object)) {
            return 'resource';
        }

        return 'unknown';
    }
}
