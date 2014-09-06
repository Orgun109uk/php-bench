<?php
/**
 * phpBench library.
 *
 * A bench test to test read loops.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license LGPL v3 (See LICENSE file)
 * @copyright Copyright (c) 2014
 */

/**
* PHP quotes bench
*/
class LoopsBench extends \phpBench\BenchCase
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
            "title" => "Read loops",
            "description" => "What is the best way to loop a hash array? Given is a Hash array with 100 elements, " .
                "24byte key and 10k data per entry.",
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
     * Test a simple foreach loop.
     */
    public function benchForEachLoop()
    {
        foreach ($this->hash as $value) {
            // Do nothing.
        }
    }

    /**
     * Test a simple foreach loop with keys.
     */
    public function benchForEachLoopKeys()
    {
        foreach ($this->hash as $key => $value) {
            // Do nothing.
        }
    }

    /**
     * Test a simple while loop.
     */
    public function benchWhile()
    {
        while (list(, $value) = each($this->hash)) {
            // Do nothing.
        }
    }

    /**
     * Test a simple while loop with keys.
     */
    public function benchWhileKeys()
    {
        while (list($key, $value) = each($this->hash)) {
            // Do nothing.
        }
    }

    /**
     * Test a simple for incrementing loop.
     */
    public function benchIncrementingFor()
    {
        for ($i = 0; $i < 100; $i++) {
            // Do nothing.
        }
    }

    /**
     * Test a simple for incrementing while.
     */
    public function benchIncrementingWhile()
    {
        $i = 0;
        while ($i < 100) {
            // Do nothing.
            ++$i;
        }
    }

    /**
     * Test a simple for incrementing while-do.
     */
    public function benchIncrementingWhileDo()
    {
        $i = 0;
        do {
            // Do nothing.
            ++$i;
        } while ($i < 100);
    }

    /**
     * Test a simple foreach loop with references (without setting the item).
     */
    public function benchForLoopReferenceNoSetting()
    {
        foreach ($this->hash as &$item) {
            // Do nothing.
        }
    }

    /**
     * Test a simple foreach loop with references (with setting the item).
     */
    public function benchForLoopReferenceSetting()
    {
        foreach ($this->hash as &$item) {
            $item = "b";
        }
    }

    /**
     * Test a simple foreach loop with references and key (without setting the item).
     */
    public function benchForLoopReferenceKeyNoSetting()
    {
        foreach ($this->hash as $key => &$item) {
            // Do nothing.
        }
    }

    /**
     * Test a simple foreach loop with references and key (with setting the item).
     */
    public function benchForLoopReferenceKeySetting()
    {
        foreach ($this->hash as $key => &$item) {
            $item = "b";
        }
    }
}
