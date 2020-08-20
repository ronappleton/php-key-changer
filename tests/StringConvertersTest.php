<?php

use RonAppleton\PhpKeyChanger\StringConverters;
use PHPUnit\Framework\TestCase;

class StringConvertersTest extends TestCase
{
    private StringConverters $stringConverters;

    protected function setUp(): void
    {
        $this->stringConverters = new StringConverters();
    }

    public function testStudly()
    {
        $test = 'this_isTheStringTo-Convert';

        $result = $this->stringConverters->studly($test);

        $this->assertStringContainsString('This IsTheStringTo Convert', $result);
    }

    public function testKebab()
    {
        $test = 'this_isTheStringTo-Convert';

        $result = $this->stringConverters->kebab($test);

        $this->assertStringContainsString('this-is-the-string-to-convert', $result);
    }

    public function testLower()
    {
        $test = 'this_isTheStringTo-Convert';

        $result = $this->stringConverters->lower($test);

        $this->assertStringContainsString('this_isthestringto-convert', $result);
    }

    public function testCamel()
    {
        $test = 'this_isTheStringTo-Convert';

        $result = $this->stringConverters->camel($test);

        $this->assertStringContainsString('this IsTheStringTo Convert', $result);
    }

    public function testPascal()
    {
        $test = 'this_isTheStringTo-Convert';

        $result = $this->stringConverters->pascal($test);

        $this->assertStringContainsString('ThisIsTheStringToConvert', $result);
    }

    public function testSnake()
    {
        $test = 'this_isTheStringTo-Convert';

        $result = $this->stringConverters->snake($test);

        $this->assertStringContainsString('this_is_the_string_to_convert', $result);
    }
}
