<?php
/**
 * phpBench library.
 *
 * The website index to display the results of phpBench tests.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license LGPL v3 (See LICENSE file)
 * @copyright Copyright (c) 2014
 */

require_once "composers_modules/autoload.php";
require_once "vendors/phpBench/core/PHPBench.php";

// Setup the twig environment.
$loader = new Twig_Loader_Filesystem("web/templates");
$twig = new Twig_Environment($loader, array(
    "cache" => "web/cache",
));

// Register the shutdown function.
register_shutdown_function("phpBenchShutdown");

/**
 * PHP shutdown override, just to make sure we always get a nice output even upon exception.
 */
function phpBenchShutdown()
{
    // Render the output.
    echo $twig->render(
        "html.twig",
        [
            "results" => $results,
            "exception" => $exception,
        ]
    );
}

// Create the PHPBench class.
$phpBench = new phpBench\PHPBench([
    "dir" => "benchmarks",
]);

// Run the tests and capture any exceptions.
$exception = false;
try {
    $results = $phpBench
        ->run()
        ->getResults();
} catch (\Exception $e) {
    $exception = $e->getMessage();
    $results = [];
}
