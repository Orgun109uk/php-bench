module.exports = function (grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON("package.json"),

        // PHPUnit configuration.
        phpunit: {
            options: {
                bin: "composer_modules/bin/phpunit",
                bootstrap: "vendors/phpBench/tests/bootstrap.php",
                logJunit: "reports/php-unit.xml",
                coverage: true,
                coverageHtml: "reports/coverage",
                coverageClover: "reports/coverage.xml",
                configuration: "vendors/phpBench/tests/phpunit.xml"
            },
            all: {
                dir: "vendors/phpBench/tests/core"
            }
        },

        // PHPCS configuration.
        phpcs: {
            options: {
                bin: "composer_modules/bin/phpcs",
                ignoreExitCode: true,
                standard: "PSR2",
                reportFile: "reports/php-cs.txt"
            },
            all: {
                dir: [
                    "vendors/phpBench/*.php",
                    "vendors/phpBench/**/*.php"
                ]
            }
        },

        // PHPMD configuration.
        phpmd: {
            options: {
                bin: "composer_modules/bin/phpmd",
                rulesets: "codesize,unusedcode,naming",
                exclude: "vendors/",
                reportFile: "reports/php-md.xml"
            },
            all: {
                dir: "vendors/phpBench"
            }
        },

        // PHPCPD configuration.
        phpcpd: {
            options: {
                bin: "composer_modules/bin/phpcpd",
                exclude: "vendors/",
                reportFile: "reports/php-cpd.xml",
                quiet: false
            },
            all: {
                dir: "vendors/phpBench"
            }
        },

        // PHPDocumentor configuration.
        phpdocumentor: {
            all: {
                options: {
                    directory: "vendors/phpBench",
                    target : "docs",
                    template: "clean"
                }
            }
        }
    });

    // Load the plugin that provides the "phpunit" task.
    grunt.loadNpmTasks("grunt-phpunit");

    // Load the plugin that provides the "phpcs" task.
    grunt.loadNpmTasks("grunt-phpcs");

    // Load the plugin that provides the "phpmd" task.
    grunt.loadNpmTasks("grunt-phpmd");

    // Load the plugin that provides the "phpcpd" task.
    grunt.loadNpmTasks("grunt-phpcpd");

    // Load the plugin that provides the "phpdocumentor" task.
    grunt.loadNpmTasks("grunt-phpdocumentor");

    // Default tasks.
    grunt.registerTask("default", [ "phpunit", "phpcs", "phpmd", "phpcpd", "phpdocumentor" ]);

};
