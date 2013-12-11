<?php
include_once dirname(__FILE__) . '/init.php';
include_once ROOT . '/Pattern.class.php';

class PatternTest extends PHPUnit_Framework_TestCase
{
    /**
     * test if pattern getPcrePattern returns right expression for different 
     * test cases.
     */
    public function testGetPcrePattern()
    {
        $cases = array(
            array('*,b,*',      '|^[^/]+/b/[^/]+$|'),
            array('a,*,*',      '|^a/[^/]+/[^/]+$|'),
            array('foo,bar,baz','|^foo/bar/baz$|'),
        );

        foreach($cases as $case) {

            $pattern = new Pattern($case[0]);
            $this->assertEquals(
                $pattern->getPcrePattern(), 
                $case[1]
            );
            
        }
    }
}

