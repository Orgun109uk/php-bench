<?php
/**
 * phpBench library.
 *
 * Defines the main phpBench class.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license LGPL v3 (See LICENSE file)
 * @copyright Copyright (c) 2014
 *
 * Inspired by PHPBench <https://github.com/mnapoli/PHPBench>
 */

namespace phpBench;

require_once __DIR__ . "/Utils/ArrayData.php";
require_once __DIR__ . "/Helpers/Files.php";
require_once __DIR__ . "/BenchCase.php";
require_once __DIR__ . "/BenchCase/DryRun.php";

use phpBench\BenchCase\DryRun;
use phpBench\Utils\ArrayData;
use phpBench\Helpers\Files;

/**
 * The main phpBench class.
 */
class PHPBench
{
    /**
     * The configuration object.
     *
     * @var \phpBench\Utils\ArrayData
     * @access protected
     */
    protected $config;

    /**
     * An array of found/registered bench cases.
     *
     * @var array
     * @access protected
     */
    protected $benchCases = [];

    /**
     * An array containing the results of the last run.
     *
     * @var array
     * @access protected
     */
    protected $results = [];

    /**
     * The PHPBench class constructor.
     *
     * @param array $config (optional)
     *   The config to pass to the runner.
     *
     * @access public
     * @final
     */
    final public function __construct(array $config = [])
    {
        $this->config = new ArrayData(array_merge([
            "dir" => false,
        ], $config));

        $directory = $this->config->get("dir", false);
        if ($directory) {
            $this->import($directory);
        }
    }

    /**
     * Import any *Bench.php files provided in the paths or as a filename.
     *
     * @param string|array $paths
     *   Either a filename/directory or an array of filenames/directories.
     *
     * @@return \phpBench\PHPBench
     *   Returns self.
     *
     * @access public
     * @final
     */
    final public function import($paths)
    {
        if (is_array($paths)) {
            foreach ($paths as $path) {
                $this->import($path);
            }
        } elseif (is_dir($paths)) {
            // Search the directory for bench cases (*Bench.php).
            $files = Files::rglob("{$paths}/*Bench.php");
            $this->import($files);
        } elseif (is_file($paths)) {
            // Load the bench case.
            require_once $paths;

            $classname = basename($paths, ".php");
            if (!class_exists($classname)) {
                throw new \Exception(
                    strtr(
                        ":classname could not be found, note phpBench does not support namespaces.",
                        [
                            ":classname" => $classname,
                        ]
                    )
                );
            }

            $benchCase = new $classname();
            if (!$benchCase instanceof \phpBench\BenchCase) {
                throw new \Exception(
                    strtr(
                        ":classname must extend from phpBench\BenchCase.",
                        [
                            ":classname" => $classname,
                        ]
                    )
                );
            }

            $this->benchCases[$classname] = $benchCase;
        }

        return $this;
    }

    /**
     * Run the bench case.
     *
     * @return \phpBench\PHPBench
     *   Returns self.
     *
     * @access public
     * @final
     */
    final public function run()
    {
        $this->results = [];
        foreach ($this->benchCases as $benchCaseName => $benchCase) {
            // Calibrate the base time.
            $baseTime = $this->calibrate($benchCase->getConfig("iterations"));

            // Run the bench case.
            $results = $benchCase->run();

            // Render the results.
            $this->results[$benchCaseName] = [
                "base-time" => $baseTime,
                "title" => $benchCase->getConfig("title", ""),
                "description" => $benchCase->getConfig("description", ""),
                "results" => $results,
            ];
        }

        return $this;
    }

    /**
     * Calibrate the bench.
     *
     * @param int $iterations
     *   The number of iterations to run.
     *
     * @return float
     *   The execution time of an empty bench.
     *
     * @access public
     * @final
     */
    final public function calibrate($iterations)
    {
        // Create the dry run bench case and run it.
        $benchCase = new DryRun([ "iterations" => $iterations ]);
        $results = $benchCase->run();

        // Return the run time of the bench test.
        return array_pop($results["tests"])["time"];
    }

    /**
     * Get the results from the last run.
     *
     * @return array
     *   An array of results.
     *
     * @access public
     * @final
     */
    final public function getResults()
    {
        return $this->results;
    }
}
