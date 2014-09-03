<?php
/**
 * phpBench library.
 *
 * A bench test to test single quotes vs double quotes.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license LGPL v3 (See LICENSE file)
 * @copyright Copyright (c) 2014
 */

use phpBench\BenchCase;

/**
* PHP quotes bench
*/
class SingleVsDoubleQuotesBench extends BenchCase
{
    protected function config(array $config)
    {
        return [
            "iterations" => 1,
            "title" => "",
            "description" => "",
        ]; //500000
    }

    public function benchSingleQuotes1()
    {
        $foo = 'test';
    }

    public function benchSingleQuotes2()
    {
        $foo = 'test'.'test';
    }

    public function benchSingleQuotes3()
    {
        $bar = 'blah';
        $foo = 'test '.$bar.' test';
    }

    public function benchDoubleQuotes1()
    {
        $foo = "test";
    }

    public function benchDoubleQuotes2()
    {
        $foo = "test"."test";
    }

    public function benchDoubleQuotes3()
    {
        $bar = "blah";
        $foo = "test ".$bar." test";
    }

    public function benchDoubleQuotes4()
    {
        $bar = "blah";
        $foo = "test $bar test";
    }
}
