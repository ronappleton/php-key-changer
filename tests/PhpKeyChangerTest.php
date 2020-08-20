<?php

require_once ('../vendor/autoload.php');

use RonAppleton\PhpKeyChanger\PhpKeyChanger;
use RonAppleton\PhpKeyChanger\TypeConverters;
use RonAppleton\PhpKeyChanger\StringConverters;
use PHPUnit\Framework\TestCase;

class PhpKeyChangerTest extends TestCase
{
    private PhpKeyChanger $keyChanger;

    protected function setUp(): void
    {
        $this->keyChanger = new PhpKeyChanger(new TypeConverters(), new StringConverters());
    }

    public function testReKeyArray()
    {
        $foo = [
          'SingleLevelArrayKey' => 1
        ];

        $bar = $this->keyChanger->reKey($foo, 'snake');

        $this->assertIsArray($bar, 'Array passed in to reKey not returned as an array');

        $this->assertArrayHasKey('single_level_array_key', $bar);
    }

    public function testReKeyString()
    {
        $foo = [
          'SingleLevelArrayKey' => 1
        ];

        $foo = json_encode($foo);

        $bar = $this->keyChanger->reKey($foo, 'snake');

        $this->assertIsString($bar, 'String passed in to reKey not returned as a string');

        $this->assertStringContainsString('single_level_array_key', $bar);
    }

    public function testReKeyObject()
    {
        $foo = [
          'SingleLevelArrayKey' => 1
        ];

        $foo = json_decode(json_encode($foo));

        $bar = $this->keyChanger->reKey($foo, 'snake');

        $this->assertIsObject($bar, 'Object passed in to reKey not returned as an object');

        $this->assertObjectHasAttribute('single_level_array_key', $bar);
    }

    public function testReKeyArrayMulti()
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

    public function testReKeyStringMulti()
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

    public function testReKeyObjectMulti()
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

    public function testNumericKeys()
    {
        $foo['one'][0]['two'][0]['three'][0] = 99;

        $bar = $this->keyChanger->reKey($foo, 'kebab');

        $this->assertTrue(isset($bar['one'][0]['two'][0]['three'][0]));
    }
}
