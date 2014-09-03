<?php
/**
 * phpBench library.
 *
 * Defines the files helper class.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license LGPL v3 (See LICENSE file)
 * @copyright Copyright (c) 2014
 */

namespace phpBench\Helpers;

/**
 * A class that provides some file helper functions.
 */
class Files
{
    /**
     * A recursive glob, returns an array of files matching the pattern.
     *
     * @param string $pattern
     *   A glob pattern.
     * @param int $flags
     *   Glob flags to apply to the files.
     *
     * @return array
     *   An array of found files.
     *
     * @access public
     * @static
     */
    public static function rglob($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        $dirs = glob(dirname($pattern) . "/*", GLOB_ONLYDIR | GLOB_NOSORT);
        if ($dirs && count($dirs)) {
            foreach ($dirs as $dir) {
                $files = array_merge(
                    $files,
                    self::rglob("{$dir}/" . basename($pattern), $flags)
                );
            }
        }

        return $files;
    }
}
