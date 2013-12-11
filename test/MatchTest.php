<?php
include_once dirname(__FILE__) . '/init.php';
include_once ROOT . '/Match.class.php';

class MatchTest extends PHPUnit_Framework_TestCase
{
    protected $cases = array(
            '*,b,*',
            'a,*,*',
            '*,*,c',
            'foo,bar,baz',
            'w,x,*,*',
            '*,x,y,z',
        );

    protected $sortExpect = array(
            'foo,bar,baz',
            '*,x,y,z',
            'a,*,*',
            'w,x,*,*',
            '*,b,*',
            '*,*,c',
        );

    /**
     * test add patterns
     */
    public function testAddPatterns()
    {
        $match = new Match();
        foreach($this->cases as $case) {
            $match->addPattern($case);
        }

        $this->assertEquals(
            $match->getPatterns(), 
            $this->cases
        );
    }

    /**
     * test sort patterns
     */
    public function testSortPatterns()
    {
        $match = new Match();
        foreach($this->cases as $case) {
            $match->addPattern($case);
        }

        $match->sortPatterns();

        $this->assertEquals(
            $match->getPatterns(), 
            $this->sortExpect
        );
    }

    /**
     * test sort single case 1
     */
    public function testSortPattern1()
    {
        $case1 = array(
            'a,*,*',
            '*,*,c',
        );
        $case2 = array(
            '*,*,c',
            'a,*,*',
        );
        $expected = array(
            'a,*,*',
            '*,*,c',
        );

        $match = new Match();
        foreach($case1 as $case) {
            $match->addPattern($case);
        }
        $match->sortPatterns();
        $this->assertEquals(
            $match->getPatterns(), 
            $expected
        );
    }
}

