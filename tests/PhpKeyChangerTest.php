<?php

namespace RonAppleton\PhpKeyChanger;

use PHPUnit\Framework\TestCase;

class PhpKeyChangerTest extends TestCase
{

    public function testReKeyTypeArray()
    {
        $a = [
          'SingleLevelArrayKey' => 1
        ];

        $b = PhpKeyChanger::reKey($a, 'snake');

        $this->assertIsArray($b, 'Array passed in to reKey not returned as an array');

        $this->assertArrayHasKey('single_level_array_key', $b);
    }

    public function testReKeyTypeString()
    {
        $a = [
          'SingleLevelArrayKey' => 1
        ];

        $a = json_encode($a);

        $b = PhpKeyChanger::reKey($a, 'snake');

        $this->assertIsString($b, 'String passed in to reKey not returned as a string');

        $this->assertStringContainsString('single_level_array_key', $b);
    }

    public function testReKeyTypeObject()
    {
        $a = [
          'SingleLevelArrayKey' => 1
        ];

        $a = json_decode(json_encode($a));

        $b = PhpKeyChanger::reKey($a, 'snake');

        $this->assertIsObject($b, 'Object passed in to reKey not returned as an object');

        $this->assertObjectHasAttribute('single_level_array_key', $b);
    }

    public function testReKeyTypeArrayMulti()
    {
        $a = [
          'SingleLevelArrayKey' => [
              'SecondaryKey' => [
                  'ThirdLevelKey' => [
                      'FourthLevelKey' => 1
                  ]
              ]
          ]
        ];

        $b = PhpKeyChanger::reKey($a, 'kebab');

        $this->assertIsArray($b, 'Array passed in to reKey not returned as an array');

        $this->assertTrue(isset($b['single-level-array-key']['secondary-key']['third-level-key']['fourth-level-key']));
    }

    public function testReKeyTypeStringMulti()
    {
        $a = [
            'SingleLevelArrayKey' => [
                'SecondaryKey' => [
                    'ThirdLevelKey' => [
                        'FourthLevelKey' => 1
                    ]
                ]
            ]
        ];

        $a = json_encode($a);

        $b = PhpKeyChanger::reKey($a, 'kebab');

        $this->assertIsString($b, 'String passed in to reKey not returned as a string');

        $this->assertStringContainsString('single-level-array-key', $b);

        $this->assertStringContainsString('fourth-level-key', $b);
    }

    public function testReKeyTypeObjectMulti()
    {
        $a = [
            'SingleLevelArrayKey' => [
                'SecondaryKey' => [
                    'ThirdLevelKey' => [
                        'FourthLevelKey' => 1
                    ]
                ]
            ]
        ];

        $a = json_decode(json_encode($a));

        $b = PhpKeyChanger::reKey($a, 'kebab');

        $this->assertIsObject($b, 'Object passed in to reKey not returned as an object');

        $this->assertObjectHasAttribute('single-level-array-key', $b);

        $this->assertTrue(isset($b->{'single-level-array-key'}->{'secondary-key'}->{'third-level-key'}->{'fourth-level-key'}));
    }

    public function testCamel()
    {
        $a = [
            'SingleLevelArrayKey' => 1
        ];

        $b = PhpKeyChanger::reKey($a, 'camel');

        $this->assertTrue(key($b) === 'singleLevelArrayKey');
    }

    public function testPascal()
    {
        $a = [
            'SingleLevelArrayKey' => 1
        ];

        $b = PhpKeyChanger::reKey($a, 'pascal');

        $this->assertTrue(key($b) === 'SingleLevelArrayKey');
    }

    public function testStudly()
    {
        $a = [
            'Single_Level_Array_Key' => 1
        ];

        $b = PhpKeyChanger::reKey($a, 'studly');

        $this->assertTrue(key($b) === 'Single Level Array Key');
    }

    public function testSnake()
    {
        $a = [
            'SingleLevelArrayKey' => 1
        ];

        $b = PhpKeyChanger::reKey($a, 'snake');

        $this->assertTrue(key($b) === 'single_level_array_key');
    }

    public function testKebab()
    {
        $a = [
            'SingleLevelArrayKey' => 1
        ];

        $b = PhpKeyChanger::reKey($a, 'kebab');

        $this->assertTrue(key($b) === 'single-level-array-key');
    }
}
