<?php
/**
 * phpBench library.
 *
 * Test case for phpBench\Utils\ArrayData class.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license LGPL v3 (See LICENSE file)
 * @copyright Copyright (c) 2014
 */

namespace phpBench\Tests\Utils;

use phpBench\Utils\ArrayData;

/**
 * Define the test class.
 */
class ArrayDataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the classes are available.
     */
    public function testAvailable()
    {
        $this->assertTrue(class_exists("phpBench\Utils\ArrayData"));
    }

    /**
     * Test the raw function.
     *
     * @depends testAvailable
     */
    public function testRaw()
    {
        $arrayData = new ArrayData();
        $this->assertSame([], $arrayData->raw());

        $data = [
            "data" => [ "value" => "hello" ],
        ];
        $arrayData = new ArrayData($data);
        $this->assertSame($data, $arrayData->raw());
    }

    /**
     * Test the get function.
     *
     * @depends testRaw
     */
    public function testGet()
    {
        $data = [
            "data" => [ "value" => "hello" ],
        ];
        $arrayData = new ArrayData($data);

        $this->assertSame("hello", $arrayData->get("data.value"));
        $this->assertSame("world", $arrayData->get("data.value.broken", "world"));
        $this->assertSame($data, $arrayData->get(""));
    }
}
