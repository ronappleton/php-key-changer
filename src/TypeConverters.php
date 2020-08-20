<?php

declare(strict_types=1);

namespace RonAppleton\PhpKeyChanger;

class TypeConverters
{
    /**
     * Get array from given object.
     *
     * @param $object
     * @param string $type
     *
     * @return array|null
     */
    public function getArray($object, string $type): ?array
    {
        if ($type === 'object') {
            $object = json_decode(json_encode($object), true);
        }

        if ($type === 'string') {
            $object = json_decode($object, true);
        }

        return $this->getType($object) === 'array' ? $object : null;
    }

    /**
     * Returns an array as a json object.
     *
     * @param array $array
     *
     * @return object
     */
    public function getJsonObject(array $array): object
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
    public function getJsonString(array $array): string
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
    public function getType($object)
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
