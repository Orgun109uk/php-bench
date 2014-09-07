<?php
/**
 * phpBench library.
 *
 * A bench test to executing a classes function.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license LGPL v3 (See LICENSE file)
 * @copyright Copyright (c) 2014
 */

class ExampleClass
{
    public function example()
    {
        // Do nothing.
    }
}

/**
* PHP class function bench
*/
class ClassFunctionBench extends \phpBench\BenchCase
{
    /**
     * An internal event to return the custom bench configuration.
     *
     * @param array $config (optional) []
     *   A default config to pass to the internal configuration method, this may not actually get used by all cases.
     *
     * @return array
     *   The configuration options.
     *
     * @access protected
     */
    protected function config(array $config = [])
    {
        return [
            "iterations" => 1000,
            "title" => "Executing a function of a class.",
        ];
    }

    public function setUp()
    {
        $this->obj = new ExampleClass();
    }

    /**
     * Call the classes function normally.
     */
    public function benchCallFunctionNormally()
    {
        $this->obj->example();
    }

    /**
     * Call the classes function as a string.
     */
    public function benchCallFunctionWithString()
    {
        $ref = "example";
        $this->obj->$ref();
    }

    /**
     * Call the classes function as a string in brackets.
     */
    public function benchCallFunctionWithStringInBrackets()
    {
        $this->obj->{"example"}();
    }
}
