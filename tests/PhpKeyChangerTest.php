<?php

namespace RonAppleton\PhpKeyChanger;

use PHPUnit\Framework\TestCase;

class PhpKeyChangerTest extends TestCase
{
    private PhpKeyChanger $keyChanger;

    public function __construct()
    {
        parent::__construct();

        $this->keyChanger = new PhpKeyChanger();
    }

    public function testReKeyTypeArray()
    {
        $foo = [
          'SingleLevelArrayKey' => 1
        ];

        $bar = $this->keyChanger->reKey($foo, 'snake');

        $this->assertIsArray($bar, 'Array passed in to reKey not returned as an array');

        $this->assertArrayHasKey('single_level_array_key', $bar);
    }

    public function testReKeyTypeString()
    {
        $foo = [
          'SingleLevelArrayKey' => 1
        ];

        $foo = json_encode($foo);

        $bar = $this->keyChanger->reKey($foo, 'snake');

        $this->assertIsString($bar, 'String passed in to reKey not returned as a string');

        $this->assertStringContainsString('single_level_array_key', $bar);
    }

    public function testReKeyTypeObject()
    {
        $foo = [
          'SingleLevelArrayKey' => 1
        ];

        $foo = json_decode(json_encode($foo));

        $bar = $this->keyChanger->reKey($foo, 'snake');

        $this->assertIsObject($bar, 'Object passed in to reKey not returned as an object');

        $this->assertObjectHasAttribute('single_level_array_key', $bar);
    }

    public function testReKeyTypeArrayMulti()
    {
        $foo = [
          'SingleLevelArrayKey' => [
              'SecondaryKey' => [
                  'ThirdLevelKey' => [
                      'FourthLevelKey' => 1
                  ]
              ]
          ]
        ];

        $bar = $this->keyChanger->reKey($foo, 'kebab');

        $this->assertIsArray($bar, 'Array passed in to reKey not returned as an array');

        $this->assertTrue(isset($bar['single-level-array-key']['secondary-key']['third-level-key']['fourth-level-key']));
    }

    public function testReKeyTypeStringMulti()
    {
        $foo = [
            'SingleLevelArrayKey' => [
                'SecondaryKey' => [
                    'ThirdLevelKey' => [
                        'FourthLevelKey' => 1
                    ]
                ]
            ]
        ];

        $foo = json_encode($foo);

        $bar = $this->keyChanger->reKey($foo, 'kebab');

        $this->assertIsString($bar, 'String passed in to reKey not returned as a string');

        $this->assertStringContainsString('single-level-array-key', $bar);

        $this->assertStringContainsString('fourth-level-key', $bar);
    }

    public function testReKeyTypeObjectMulti()
    {
        $foo = [
            'SingleLevelArrayKey' => [
                'SecondaryKey' => [
                    'ThirdLevelKey' => [
                        'FourthLevelKey' => 1
                    ]
                ]
            ]
        ];

        $foo = json_decode(json_encode($foo));

        $bar = $this->keyChanger->reKey($foo, 'kebab');

        $this->assertIsObject($bar, 'Object passed in to reKey not returned as an object');

        $this->assertObjectHasAttribute('single-level-array-key', $bar);

        $this->assertTrue(isset($bar->{'single-level-array-key'}->{'secondary-key'}->{'third-level-key'}->{'fourth-level-key'}));
    }

    public function testCamel()
    {
        $foo = [
            'SingleLevelArrayKey' => 1
        ];

        $bar = $this->keyChanger->reKey($foo, 'camel');

        $this->assertTrue(key($bar) === 'singleLevelArrayKey');
    }

    public function testPascal()
    {
        $foo = [
            'SingleLevelArrayKey' => 1
        ];

        $bar = $this->keyChanger->reKey($foo, 'pascal');

        $this->assertTrue(key($bar) === 'SingleLevelArrayKey');
    }

    public function testStudly()
    {
        $foo = [
            'Single_Level_Array_Key' => 1
        ];

        $bar = $this->keyChanger->reKey($foo, 'studly');

        $this->assertTrue(key($bar) === 'Single Level Array Key');
    }

    public function testSnake()
    {
        $foo = [
            'SingleLevelArrayKey' => 1
        ];

        $bar = $this->keyChanger->reKey($foo, 'snake');

        $this->assertTrue(key($bar) === 'single_level_array_key');
    }

    public function testKebab()
    {
        $foo = [
            'SingleLevelArrayKey' => 1
        ];

        $bar = $this->keyChanger->reKey($foo, 'kebab');

        $this->assertTrue(key($bar) === 'single-level-array-key');
    }

    public function testNumericKeys()
    {
        $foo['one'][0]['two'][0]['three'][0] = 99;

        $bar = $this->keyChanger->reKey($foo, 'kebab');

        $this->assertTrue(isset($bar['one'][0]['two'][0]['three'][0]));
    }
}