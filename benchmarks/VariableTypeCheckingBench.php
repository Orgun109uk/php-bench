<?php
/**
 * phpBench library.
 *
 * A bench test to test various variable type checking.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license LGPL v3 (See LICENSE file)
 * @copyright Copyright (c) 2014
 */

/**
* PHP variable type checking bench.
*/
class VariableTypeCheckingBench extends \phpBench\BenchCase
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
            "title" => "Various variable type checking tests.",
        ];
    }

    /**
     * Setup the bench test.
     *
     * @access public
     */
    public function setUp()
    {
        $this->testArray = [];
        $this->testBoolFalse = false;
        $this->testBoolTrue = true;
        $this->testString = "";
        $this->testString0 = "0";
        $this->testInt0 = 0;
        $this->testInt1 = 1;

        $this->testWasArray = [];
        unset($this->testWasArray);
    }

    /**
     * Test the isset method on an assigned variable.
     */
    public function benchIssetWithAssignedVariable()
    {
        isset($this->testArray);
    }

    /**
     * Test the isset method on an unassigned variable.
     */
    public function benchIssetWithUnassignedVariable()
    {
        isset($this->testUnassigned);
    }

    /**
     * Test the empty method on an assigned variable.
     */
    public function benchEmptyWithAssignedVariable()
    {
        empty($this->testArray);
    }

    /**
     * Test the empty method on an unassigned variable.
     */
    public function benchEmptyWithUnassignedVariable()
    {
        empty($this->testUnassigned);
    }

    /**
     * Test the isset method on an assigned array variable.
     */
    public function benchIssetWithAssignedArrayVariable()
    {
        isset($this->testArray);
    }

    /**
     * Test the empty method on an assigned array variable.
     */
    public function benchEmptyWithAssignedArrayVariable()
    {
        empty($this->testArray);
    }

    /**
     * Test the empty method on an unassigned array variable.
     */
    public function benchEmptyWithUnassignedArrayVariable()
    {
        empty($this->testUnassigned);
    }
}
