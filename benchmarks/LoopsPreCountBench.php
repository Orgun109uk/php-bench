<?php
/**
 * phpBench library.
 *
 * A bench test to test read loops with precounts.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license LGPL v3 (See LICENSE file)
 * @copyright Copyright (c) 2014
 */

/**
* PHP loops with precounts bench
*/
class LoopsPreCountBench extends \phpBench\BenchCase
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
            "title" => "Read loops for precounts",
        ];
    }

    /**
     * Executed before the bench case.
     *
     * @access public
     */
    public function setUp()
    {
        $i = 0;
        $value = "";
        while ($i < 10000) {
            $value .= "a";
            ++$i;
        }

        $this->hash = array_fill(100000000000000000000000, 100, $value);
        unset($i, $value);
    }

    /**
     * Test a simple for loop with a pre-calculated count using count().
     */
    public function benchForLoopPreCalcCount()
    {
        $count = count($this->hash);
        for ($i = 0; $i < $count; $i++) {
            // Do nothing.
        }
    }

    /**
     * Test a simple for loop without using a pre-calculated count using count().
     */
    public function benchForLoopNoPreCalcCount()
    {
        for ($i = 0; $i < count($this->hash); $i++) {
            // Do nothing.
        }
    }

    /**
     * Test a simple for loop with a pre-calculated count using sizeof().
     */
    public function benchForLoopPreCalcSizeOf()
    {
        $count = sizeof($this->hash);
        for ($i = 0; $i < $count; $i++) {
            // Do nothing.
        }
    }

    /**
     * Test a simple for loop without using a pre-calculated count using sizeof().
     */
    public function benchForLoopNoPreCalcSizeOf()
    {
        for ($i = 0; $i < sizeof($this->hash); $i++) {
            // Do nothing.
        }
    }
}
