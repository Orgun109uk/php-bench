<?php
/**
 * phpBench library.
 *
 * A bench test to test single quotes vs double quotes.
 *
 * @author Orgun109uk <orgun109uk@gmail.com>
 * @license LGPL v3 (See LICENSE file)
 * @copyright Copyright (c) 2014
 */

/**
* PHP quotes bench
*/
class SingleVsDoubleQuotesBench extends \phpBench\BenchCase
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
        return [
            "iterations" => 1000,
            "title" => "Quote types",
            "description" => "See if there's any differences in using double (\") and single (') quotes for strings " .
                "with 1,000 iterations.",
        ];
    }

    /**
     * An empty string using single (') quotes ($foo = '').
     */
    public function benchSingleQuotesEmpty()
    {
        $foo = '';
    }

    /**
     * An empty string using double (") quotes ($foo = "");
     */
    public function benchDoubleQuotesEmpty()
    {
        $foo = "";
    }

    /**
     * A string with 20 characters using single (') quotes ($foo = 'abcde12345fghij67890');
     */
    public function benchSingleQuotes20Chars()
    {
        $foo = 'abcde12345fghij67890';
    }

    /**
     * A string with 20 characters using double (") quotes ($foo = "abcde12345fghij67890");
     */
    public function benchDoubleQuotes20Chars()
    {
        $foo = "abcde12345fghij67890";
    }

    /**
     * A string with 16 characters and 4 $ using single (') quotes ($foo = 'abc$ 123$ fgh$ 678$ ');
     */
    public function benchSingleQuotes16Chars4Dollars()
    {
        $foo = 'abc$ 123$ fgh$ 678$ ';
    }

    /**
     * A string with 16 characters and 4 $ using double (") quotes ($foo = "abc$ 123$ fgh$ 678$ ");
     */
    public function benchDoubleQuotes16Chars4Dollars()
    {
        $foo = "abc$ 123$ fgh$ 678$ ";
    }

    /**
     * A string with 16 characters and 4 escaped $ using double (") quotes ($foo = "abc\$ 123\$ fgh\$ 678\$ ");
     */
    public function benchDoubleQuotes16Chars4DollarsEscaped()
    {
        $foo = "abc\$ 123\$ fgh\$ 678\$ ";
    }
}
