<?php

/**
 * NAME: 
 *      Match
 *
 *  DESCRIPTION:
 *
 *      - Handle input
 *      - Process pattern load
 *      - Sort pattern with best-matching requirement
 *      - Match path against given patterns
 *
 */
class Match 
{
    /**
     * @var  $_paths      array       path collections
     */
    protected $_paths = array();

    /**
     * @var  $_patterns      array       pattern collections
     */
    protected $_patterns = array();

    /**
     * input hanlder
     *
     * @var $_handler       resource handler
     */
    protected $_handler = null;

    /**
     * constructor
     */
    public function __construct() {}

    /**
     * destructor
     */
    public function __destruct()
    {
        if ($this->_handler)
            fclose($this->_handler);
    }

    /**
     * - load patterns from input 
     * - sort pattern by defined priority
     *
     * @return  void
     * @throws  Exception
     */
    public function loadPatterns()
    {
        if (!$this->_handler)
            throw new Exception('Invalid input handler');

        $isFirstRow = true;
        $count = 0;
        while (($buffer = fgets($this->_handler)) !== false) {

            if ($isFirstRow) {

                if (!trim($buffer)) {
                    throw new Exception('Invalid input, please check if input is missing');
                }

                $buffer = (int)$buffer; 
                if (!$buffer)
                    throw new Exception('Invalid pattern number');
                
                $count = $buffer;
                $isFirstRow = false;
            } else {
                if ($count) {
                    $this->addPattern($buffer);
                    $count--;
                }
            }
        }
        $this->sortPatterns();

        rewind($this->_handler);
    }

    /**
     * add pattern to pattern list
     */
    public function addPattern($pattern)
    {
        return $this->_addPattern($pattern);
    }

    /**
     * get pattern list
     */
    public function getPatterns()
    {
        return $this->_getPatterns();
    }

    /**
     * sort pattern list by requirement
     */
    public function sortPatterns()
    {
        usort($this->_patterns, function($a, $b){

            $result = 0;
            $aCnt = substr_count($a, '*');
            $bCnt = substr_count($b, '*');

            if (($aCnt) && ($bCnt)) {
                if ($aCnt > $bCnt) $result = 1;
                elseif ($aCnt < $bCnt) $result = -1;
                else $result = strcmp(preg_replace('/[^\*]+/', '&', $a), preg_replace('/[^\*]+/', '&', $b));
            } elseif ($aCnt && !$bCnt) {
                $result = 1;
            } elseif (!$aCnt && $bCnt) {
                $result = -1;
            } else {
                $result = strcmp($a, $b);
            }

            return $result;
        });

    }

    /**
     * process path match using user input from stdin
     */
    public function process()
    {
        $this->_handler = STDIN;

        try {

            // load patterns
            $this->loadPatterns();

            $this->_process();

        } catch (Exception $e) {
            echo PHP_EOL . "Error: " . $e->getMessage() . PHP_EOL . PHP_EOL;
        }
    }

    //* implementation

    protected function _process()
    {
        $isPathCount = true;
        $pathCount = 0;

        if (!$this->_handler)
            throw new Exception('Invalid input handler');

        rewind($this->_handler);

        $isFirstRow = true;
        $patternRows = count($this->_patterns) + 1;
        $count = 0;

        while (($buffer = fgets($this->_handler)) !== false) {

            // skip patterns
            if ($count++ <= $patternRows)
                continue;

            $buffer = trim($buffer);

            $path = new Path($buffer);
            if ($p = $this->_pathMatch($path))
                echo $p . PHP_EOL;
            else
                echo 'NO MATCH' . PHP_EOL;
        }
    }

    protected function _addPattern($pattern)
    {
        return $this->_patterns[] = $pattern;
    }

    protected function _getPatterns()
    {
        return $this->_patterns;
    }

    protected function _pathMatch(Path $path)
    {
        foreach($this->_patterns as $_p) {
            $pattern = new Pattern($_p);

            if ($pattern->match($path))
                return $pattern->getPattern();
        }

        return false;
    }
}

