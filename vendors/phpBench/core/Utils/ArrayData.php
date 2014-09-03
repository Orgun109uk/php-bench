<?php
/**
 * phpBench library.
 *
 * Defines the array data class.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license LGPL v3 (See LICENSE file)
 * @copyright Copyright (c) 2014
 */

namespace phpBench\Utils;

/**
 * A helper class to allow using path's to access array data.
 */
class ArrayData
{
    /**
     * The data array.
     *
     * @var array
     * @access protected
     */
    protected $data;

    /**
     * The ArrayData constructor.
     *
     * @param array $data
     *   (optional) The initial data used.
     *
     * @access public
     */
    public function __construct(array $data = null)
    {
        $this->data = $data !== null ? $data : [];
    }

    /**
     * Gets the data array.
     *
     * @return array
     *   Returns the data array.
     *
     * @access public
     */
    public function raw()
    {
        return $this->data;
    }

    /**
     * Get a value from the data array.
     *
     * @example
     *   $data->get("config.locale.timezone", "UTC");
     *
     * @param string $path
     *   The path to lookup.
     * @param mixed $default
     *   (optional) The default value to return if the path couldn't be found.
     *
     * @return mixed
     *   Returns either the value of the path, or $default.
     *
     * @access public
     */
    public function get($path, $default = null)
    {
        if ($path === "") {
            return $this->data;
        }

        $xpath = implode("']['", explode(".", $path));
        return eval("return isset(\$this->data['{$xpath}']) ? \$this->data['{$xpath}'] : \$default;");
    }
}
