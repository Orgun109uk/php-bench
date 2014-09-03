<?php
/**
 * phpBench library.
 *
 * Defines the dry run class.
 *
 * @author Orgun109uk
 * @license LGPL v3 (See LICENSE file)
 *
 * Inspired by PHPBench <https://github.com/mnapoli/PHPBench>
 */

namespace phpBench\BenchCase;

use phpBench\BenchCase;

/**
 * This bench is intended to be run as a bench for calibration. The
 * execution time of a call to an empty bench will be substracted from
 * all the other benches.
 */
class DryRun extends BenchCase
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
        return array_merge([
            "iterations" => 1,
        ], $config);
    }

    /**
     * Empty bench test.
     *
     * @access public
     */
    public function benchEmpty()
    {
        // Does nothing.
    }
}
