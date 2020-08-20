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
     * @var TypeConverters
     */
    private TypeConverters $typeConverters;

    /**
     * PhpKeyChanger constructor.
     *
     * @param TypeConverters $typeConverters
     * @param StringConverters $stringConverters
     */
    public function __construct(TypeConverters $typeConverters, StringConverters $stringConverters)
    {
        $this->typeConverters = $typeConverters;
        $this->stringConverters = $stringConverters;
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
        $type = $this->typeConverters->getType($object);

        $object = $this->typeConverters->getArray($object, $type);

        if ($object === null) {
            throw new RuntimeException("Unable to convert object type for conversion [$type]");
        }

        $object = self::changeKeyCaseRecursive($object, $case);

        if ($type === 'object') {
            return $this->typeConverters->getJsonObject($object);
        }

        if ($type === 'string') {
            return $this->typeConverters->getJsonString($object);
        }

        return $object;
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
}
