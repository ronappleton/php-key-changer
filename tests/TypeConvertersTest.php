<?php

use RonAppleton\PhpKeyChanger\TypeConverters;
use PHPUnit\Framework\TestCase;

class TypeConvertersTest extends TestCase
{
    /**
     * @var TypeConverters
     */
    private TypeConverters $typeConverters;

    protected function setUp(): void
    {
        $this->typeConverters = new TypeConverters();
    }

    public function testGetJsonString()
    {
        $array = ['TestKeyOne' => 'TestValueOne'];

        $this->assertIsString($this->typeConverters->getJsonString($array));
    }

    public function testGetType()
    {
        $jsonString = '{"TestKeyOne": "TestValueOne"}';

        $object = new stdClass();
        $object->TestKeyOne = 'TestValueOne';

        $array = ['TestKeyOne' => 'TestValueOne'];

        $this->assertStringContainsString('string', $this->typeConverters->getType($jsonString));
        $this->assertStringContainsString('object', $this->typeConverters->getType($object));
        $this->assertStringContainsString('array', $this->typeConverters->getType($array));
    }

    public function testGetArray()
    {
        $jsonString = '{"TestKeyOne": "TestValueOne"}';

        $object = new stdClass();
        $object->TestKeyOne = 'TestValueOne';

        $array = ['TestKeyOne' => 'TestValueOne'];

        $this->assertIsArray($this->typeConverters->getArray($jsonString, 'string'));

        $this->assertIsArray($this->typeConverters->getArray($object, 'object'));

        $this->assertIsArray($this->typeConverters->getArray($array, 'array'));
    }

    public function testGetJsonObject()
    {
        $array = ['TestKeyOne' => 'TestValueOne'];

        $this->assertIsObject($this->typeConverters->getJsonObject($array));
    }
}
