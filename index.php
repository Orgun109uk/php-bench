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

require_once "composer_modules/autoload.php";
require_once "vendors/phpBench/core/PHPBench.php";

// Setup the twig environment.
$loader = new Twig_Loader_Filesystem(__DIR__ . "/web/templates");
$GLOBALS["twig"] = new Twig_Environment($loader, array(
    "cache" => __DIR__ . "/web/cache",
));

// Check the cache directory is available.
if (!is_dir(__DIR__ . "/web/cache")) {
    mkdir(__DIR__ . "/web/cache");
}

//ini_set("display_errors", "0");
set_error_handler(function ($code, $msg, $file = null, $line = null) {
    throw new \ErrorException($msg, $code, 0, $file, $line);
});

// Register the shutdown function.
register_shutdown_function("phpBenchShutdown");

/**
 * PHP shutdown override, just to make sure we always get a nice output even upon exception.
 */
function phpBenchShutdown()
{
    // Get the last error.
    $error = error_get_last();

    // Render the output.
    echo $GLOBALS["twig"]->render(
        "html.twig",
        [
            "results" => $GLOBALS["bench_results"],
            "exception" => $error !== null ? $error["message"] : false,
        ]
    );
}

// Create the PHPBench class.
$phpBench = new phpBench\PHPBench([
    "dir" => __DIR__ . "/benchmarks",
]);

// Run the tests and capture any exceptions.
try {
    $GLOBALS["bench_results"] = $phpBench
        ->run()
        ->getResults();

    //var_dump(reset($GLOBALS["bench_results"])["results"]);
} catch (\Exception $e) {
    $GLOBALS["bench_results"] = [];
    throw $e;
}
