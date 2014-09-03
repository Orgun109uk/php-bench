<?php
/**
 * phpVTS - PHP Visual Test Suite
 *
 * Test case for phpVTS\Helpers\Arrays class.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license GPL
 * @copyright Copyright (c) 2014
 */

namespace phpBench\Tests\Helpers;

use phpBench\Helpers\Files;

/**
 * Define the test class.
 */
class FilesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Setup the test case.
     */
    public function setUp()
    {
        $this->dir = sys_get_temp_dir() . "/phpBench-test";
    }

    /**
     * Clean up the test case.
     */
    public function tearDown()
    {
        if (is_dir($this->dir)) {
            unlink("{$this->dir}/filename1.txt");
            unlink("{$this->dir}/subdir1/filename2.txt");
            unlink("{$this->dir}/subdir2/filename3.txt");
            unlink("{$this->dir}/subdir1/subsubdir1/filename4.txt");
            unlink("{$this->dir}/filename5.txt");

            rmdir("{$this->dir}/subdir1/subsubdir1");
            rmdir("{$this->dir}/subdir1");
            rmdir("{$this->dir}/subdir2");
            rmdir($this->dir);
        }
    }

    /**
     * Test available.
     */
    public function testAvailable()
    {
        $this->assertTrue(class_exists("phpBench\Helpers\Files"));
    }

    /**
     * Test the rglob function.
     *
     * @depends testAvailable
     */
    public function testRglob()
    {
        mkdir($this->dir);

        mkdir("{$this->dir}/subdir1");
        mkdir("{$this->dir}/subdir1/subsubdir1");
        mkdir("{$this->dir}/subdir2");

        file_put_contents("{$this->dir}/filename1.txt", "");
        file_put_contents("{$this->dir}/subdir1/filename2.txt", "");
        file_put_contents("{$this->dir}/subdir2/filename3.txt", "");
        file_put_contents("{$this->dir}/subdir1/subsubdir1/filename4.txt", "");
        file_put_contents("{$this->dir}/filename5.txt", "");

        $this->assertSame(
            [
                "{$this->dir}/filename1.txt",
                "{$this->dir}/filename5.txt",
                "{$this->dir}/subdir2/filename3.txt",
                "{$this->dir}/subdir1/filename2.txt",
                "{$this->dir}/subdir1/subsubdir1/filename4.txt",
            ],
            Files::rglob("{$this->dir}/*.txt")
        );
    }
}
