<?php

declare(strict_types=1);

namespace RonAppleton\PhpKeyChanger;

class StringConverters
{
    /**
     * Convert a string to camel case.
     *
     * @param string $value
     *
     * @return string
     */
    public function camel(string $value): string
    {
        return lcfirst($this->studly($value));
    }

    /**
     * Convert a string to studly case.
     *
     * @param string $value
     *
     * @return string
     */
    public function studly(string $value): string
    {
        return ucwords(str_replace(['-', '_'], ' ', $value));
    }

    /**
     * Convert a string to pascal case.
     *
     * @param string $value
     *
     * @return string
     */
    public function pascal(string $value)
    {
        return str_replace(' ', '', $this->studly($value));
    }

    /**
     * Convert a string to kebab case.
     *
     * @param string $value
     *
     * @return string
     */
    public function kebab(string $value)
    {
        return $this->snake($value, '-');
    }

    /**
     * Convert a string to snake case.
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public function snake(string $value, string $delimiter = '_')
    {
        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));

            $value = $this->lower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value));
        }

        return $value;
    }

    /**
     * Convert the given string to lower-case.
     *
     * @param string $value
     *
     * @return string
     */
    public function lower(string $value)
    {
        return mb_strtolower($value, 'UTF-8');
    }
}
