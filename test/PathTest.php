<?php
include_once dirname(__FILE__) . '/init.php';
include_once ROOT . '/Path.class.php';

class PathTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider pathValidList
     */
    public function testClean($raw)
    {
        static $real = null;

        if (is_null($real)) {
            $real = $raw;
            $this->assertTrue(TRUE);
        } else {
            $path = new Path($raw);
            $this->assertEquals($path->getPath(), $real);
        }
    }

    /**
     * path test cases
     */
    public function pathValidList()
    {
        return array(
            array('w/x/y/z'), // real path string
            array('/w/x/y/z'),
            array('w/x/y/z/'),
            array('w/x/y/z///'),
            array('///w/x/y/z///'),
            array('w/x/y/z  '),
            array("\t" . 'w/x/y/z' . "\t"),
            array('  w/x/y/z  '),
        );
    }
}


