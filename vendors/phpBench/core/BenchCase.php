<?php
/**
 * phpBench library.
 *
 * Defines the dry run class.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license LGPL v3 (See LICENSE file)
 * @copyright Copyright (c) 2014
 *
 * Inspired by PHPBench <https://github.com/mnapoli/PHPBench>
 */

namespace phpBench;

use phpBench\Utils\ArrayData;

/**
 * This bench is intended to be run as a bench for calibration. The
 * execution time of a call to an empty bench will be substracted from
 * all the other benches.
 */
abstract class BenchCase
{
    /**
     * The configuration object.
     *
     * @var \phpBench\Utils\ArrayData
     * @access protected
     */
    protected $config;

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
    abstract protected function config(array $config = []);

    /**
     * The bench case constructor.
     *
     * @param array $config (optional) []
     *   A default config to pass to the internal configuration method, this may not actually get used by all cases.
     *
     * @access public
     * @final
     */
    final public function __construct(array $config = [])
    {
        $this->config = new ArrayData(array_merge([
            "iterations" => 0,
        ], $this->onConfig($config)));

        if ($this->config->get("iterations") <= 0) {
            throw new \Exception(
                strtr(
                    "The protected property :classname::config[iterations] has not been defined, or is lower than 1.",
                    [
                        ":classname" => get_class($this),
                    ]
                )
            );
        }
    }

    /**
     * Get a config value.
     *
     * @param string $path
     *   The config path.
     * @param mixed $default (optional) null
     *   The value to return if the config does not contain the path.
     *
     * @return mixed
     *   The value from the config or the default value.
     *
     * @access public
     * @final
     */
    final public function getConfig($path, $default = null)
    {
        return $this->config->get($path, $default);
    }

    /**
     * Executed before the bench case.
     *
     * @access public
     */
    public function setUp()
    {
        // Does nothing.
    }

    /**
     * Executed before each bench test.
     *
     * @access public
     */
    public function setUpTest()
    {
        // Does nothing.
    }

    /**
     * Executed after the bench case.
     *
     * @access public
     */
    public function tearDown()
    {
        // Does nothing.
    }

    /**
     * Executed after each bench test.
     *
     * @access public
     */
    public function tearDownTest()
    {
        // Does nothing.
    }

    /**
     * Returns all the bench steps of this bench case
     *
     * @return array
     *   An array of found bench test function names.
     *
     * @access public
     * @final
     */
    final protected function getTests()
    {
        $tests = [];

        // Find all methods attached to this class.
        foreach (get_class_methods($this) as $method) {
            // If the method starts with 'bench' then add it to the array.
            if (mb_strpos($method, "bench") === 0) {
                $tests[] = $method;
            }
        }

        return $tests;
    }

    /**
     * Run all the tests in the bench case.
     *
     * @return array
     *   An array of times
     *
     * @access public
     * @final
     */
    final public function run()
    {
        $tests = $this->getTests();
        $results = [
            "name" => get_class($this),
            "filename" => __FILE__,
            "overall" => 0,
            "tests" => [],
        ];

        // Set up the bench case.
        $this->setUp();

        // Cycle through each bench test.
        foreach ($tests as $test) {
            // Set up the test.
            $this->setUpTest();

            // Start the timer.
            $timeStart = microtime(true);
            for ($i = 0; $i < $this->config->get("iterations"); $i++) {
                $this->$test();
            }

            // End the timer.
            $timeEnd = microtime(true);
            $results["tests"][$test] = $timeEnd - $timeStart;

            // Updated the overall time taken.
            $results["overall"] += $results["tests"][$test];

            // Tear down the test.
            $this->tearDownTest();
        }

        // Tear down the bench case.
        $this->tearDown();
        return $results;
    }
}
