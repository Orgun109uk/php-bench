<?php
/**
 * phpBench library.
 *
 * PHPUnit tests bootstrap.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license LGPL v3 (See LICENSE file)
 * @copyright Copyright (c) 2014
 */

if (!ini_get("date.timezone")) {
    date_default_timezone_set("UTC");
}

require_once realpath(__DIR__ . "/../core/PHPBench.php");
